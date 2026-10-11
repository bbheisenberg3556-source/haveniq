<?php

namespace App\Jobs;

use App\Models\Room;
use App\Models\PersonalityProfile;
use App\Services\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnalyzePersonalityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 180;
    protected Room $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function handle(GeminiService $geminiService): void
    {
        try {
            $checklistData = $this->room->checklist_data ?? [];

            // Determine image and mime type
            $imagePath = $this->room->image_path;
            $base64Image = '';
            $mimeType = 'image/jpeg';

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                $imageContents = Storage::disk('public')->get($imagePath);
                $base64Image = base64_encode($imageContents);
                $mimeType = str_ends_with(strtolower($imagePath), '.webp') ? 'image/webp' : 'image/jpeg';
            }

            $response = null;
            if (!empty($base64Image)) {
                $response = $geminiService->analyzePersonality($base64Image, $checklistData, $mimeType);
            }

            $profileCreated = false;

            if ($response && isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                $text = $response['candidates'][0]['content']['parts'][0]['text'];
                
                // Remove markdown code fences if present
                $text = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $text);
                $text = preg_replace('/```\s*(.*?)\s*```/s', '$1', $text);
                
                $data = json_decode(trim($text), true);

                if ($data && isset($data['traits']) && isset($data['summary'])) {
                    PersonalityProfile::updateOrCreate(
                        ['room_id' => $this->room->id],
                        [
                            'traits' => $data['traits'],
                            'summary' => $data['summary'],
                            'raw_response' => $response
                        ]
                    );
                    $profileCreated = true;
                }
            }

            // Fallback if parsing failed or response was invalid
            if (!$profileCreated) {
                Log::warning("Gemini analysis yielded non-standard output for room {$this->room->id}. Applying psychometric fallback.");
                $fallback = $geminiService->generateHeuristicProfile($checklistData);
                $parsedFallback = json_decode($fallback['candidates'][0]['content']['parts'][0]['text'], true);

                PersonalityProfile::updateOrCreate(
                    ['room_id' => $this->room->id],
                    [
                        'traits' => $parsedFallback['traits'],
                        'summary' => $parsedFallback['summary'],
                        'raw_response' => $fallback
                    ]
                );
            }

            Log::info("Personality profile created successfully for room {$this->room->id}");

        } catch (\Throwable $e) {
            Log::error("AnalyzePersonalityJob failed for room {$this->room->id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            // Last line of defense: guarantee profile existence
            try {
                $fallback = $geminiService->generateHeuristicProfile($this->room->checklist_data ?? []);
                $parsedFallback = json_decode($fallback['candidates'][0]['content']['parts'][0]['text'], true);
                PersonalityProfile::updateOrCreate(
                    ['room_id' => $this->room->id],
                    [
                        'traits' => $parsedFallback['traits'],
                        'summary' => $parsedFallback['summary'],
                        'raw_response' => $fallback
                    ]
                );
            } catch (\Throwable $ex) {
                Log::critical("Fatal: Could not apply fallback profile: " . $ex->getMessage());
            }
        }
    }
}
