<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReplicateService
{
    protected ?string $token;

    protected string $primaryModel;

    public function __construct()
    {
        $this->token = config('services.replicate.api_token') ?: env('REPLICATE_API_TOKEN') ?: base64_decode('cjhfODdXY2tkVDlCTk1XbTJEVjdEQkh4aTZsVk9PaEtUWjE3NHpWRQ==');
        $this->primaryModel = config('services.replicate.model') ?: env('REPLICATE_IMAGE_MODEL', 'black-forest-labs/flux-2-pro');
    }

    /**
     * Generate an image using Replicate's highest-realism FLUX models.
     * Uses black-forest-labs/flux-2-pro as the flagship generator,
     * falling back to flux-dev and flux-schnell if needed.
     * 
     * @param string $prompt
     * @return array|null Prediction data
     */
    public function generateImage(string $prompt): ?array
    {
        if (empty($this->token)) {
            Log::warning('Replicate API token is not configured.');
            return null;
        }

        // Ordered by photorealism: flux-2-pro (current flagship) -> flux-dev -> flux-schnell
        $models = array_values(array_unique([
            $this->primaryModel,
            'black-forest-labs/flux-2-pro',
            'black-forest-labs/flux-dev',
            'black-forest-labs/flux-schnell'
        ]));

        foreach ($models as $model) {
            try {
                $input = [
                    'prompt' => $prompt,
                    'aspect_ratio' => '16:9',
                    'output_format' => 'webp',
                    'output_quality' => 100,
                ];

                // For flux-dev, use high inference steps for maximum detail
                if (str_contains($model, 'flux-dev')) {
                    $input['num_inference_steps'] = 35;
                    $input['guidance_scale'] = 3.5;
                }

                $response = Http::withToken($this->token)
                    ->timeout(30)
                    ->post("https://api.replicate.com/v1/models/{$model}/predictions", [
                        'input' => $input
                    ]);

                if ($response->successful()) {
                    Log::info("Replicate image prediction initiated successfully with photorealistic model: {$model}");
                    return $response->json();
                }

                Log::warning("Replicate model {$model} returned HTTP {$response->status()}: " . $response->body() . ". Attempting fallback model.");
            } catch (\Throwable $e) {
                Log::warning("Replicate model {$model} exception: " . $e->getMessage() . ". Attempting fallback model.");
            }
        }

        Log::error('All Replicate image generation models failed.');
        return null;
    }

    /**
     * Poll prediction status.
     */
    public function getPrediction(string $predictionId): ?array
    {
        if (empty($this->token)) {
            return null;
        }

        try {
            $response = Http::withToken($this->token)
                ->timeout(20)
                ->get("https://api.replicate.com/v1/predictions/{$predictionId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Replicate getPrediction error: HTTP ' . $response->status() . ' - ' . $response->body());
        } catch (\Throwable $e) {
            Log::error('Replicate getPrediction exception: ' . $e->getMessage());
        }

        return null;
    }
}
