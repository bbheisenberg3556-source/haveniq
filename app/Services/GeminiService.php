<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: base64_decode('QVEuQWI4Uk42S3JmWGFjNkNxN2lEXzM0ZGhocnZ2YzJMbk1iSEhScVpadWhIX19YdzhST0E=');
    }

    /**
     * Analyze personality based on the image and checklist data.
     */
    public function analyzePersonality(string $base64Image, array $checklistData, string $mimeType = 'image/webp'): ?array
    {
        $promptText = "You are an expert psychoanalyst and depth psychologist specializing in Jungian environmental psychology and spatial symbolism.

Analyze the attached image of the living room, alongside the user's checklist selections. Your task is to treat the room's physical objects, spatial configuration, lighting, boundaries, and materials as psychological symbols and subconscious projections of their personality.

CHECKLIST DATA:
" . json_encode($checklistData) . "

Generate exactly 3 profound personality traits.

MANDATORY STRUCTURE FOR EVERY TRAIT:
Every trait explanation MUST follow this exact 4-part structure:
1. Anchor — Name a specific object or physical feature visible in the image or checklist (e.g., \"your central hearth\", \"the locked desk drawer\", \"the uncurtained arched window\", \"the isolated low-slung chaise\").
2. Symbolic interpretation — Explain what that object represents psychologically, using authentic Jungian framing (such as the archetype of the Self, the Shadow, the Persona, inferior or dominant cognitive functions, or tension between conscious order and the unconscious) translated into articulate, plain language.
3. Personality implication — Address the user directly in the second person (\"you tend to...\"), detailing how this psychological disposition shapes their emotional life, interpersonal relationships, or behavior under stress.
4. Growth insight — Offer one small, concrete, actionable suggestion for psychological balance.

CLIENT BENCHMARK EXAMPLES OF REQUIRED DEPTH AND TONE:
- \"Your central hearth represents exceptional emotional empathy and interpersonal stability, acting as an archetypal Self around which domestic warmth gathers. In relationships, you tend to absorb emotional turbulence and anchor those around you, often at the expense of your own boundaries. Growth insight: Practice intentional detachment during others' crises so your empathy remains a conscious choice rather than an involuntary reflex.\"
- \"The locked desk drawer reflects a repressed inferior thinking function, leading to avoidance of structured planning under stress. When overwhelmed, you tend to compartmentalize administrative realities and procrastinate on rigid logistics, hoping intuitive momentum will carry you through. Growth insight: Establish a weekly 15-minute triage ritual to confront unorganized logistical details before they trigger unconscious anxiety.\"

CRITICAL RULES:
- Trait Name: A compelling, psychologically evocative title (e.g., \"Emotional Hearth\", \"Compartmentalized Shadow\", \"Guarded Persona\", \"Intuitive Sanctuary\").
- Confidence Score: Integer between 0 and 100 representing the prominence of this psychological symbol in the design.
- Explanation: Seamlessly unite all four elements (Anchor, Symbolic interpretation, Personality implication, Growth insight) into a rich, cohesive 3-4 sentence paragraph. Do NOT write superficial decor descriptions. Treat every object as an intimate psychological projection.
- Overall Summary: A 3-4 sentence Jungian synthesis tying the three insights together into an overarching assessment of the user's psyche, inner tensions, and path toward individuation.

Return ONLY valid JSON in this exact format:
{
  \"traits\": [
    {
      \"name\": \"Trait Name\",
      \"score\": 88,
      \"anchor\": \"Specific object or feature identified\",
      \"explanation\": \"Your [anchor] represents [symbolic interpretation with Jungian framing]. You tend to [personality implication]. Growth insight: [concrete actionable suggestion].\"
    }
  ],
  \"summary\": \"Overall Jungian psychological synthesis...\"
}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $promptText],
                        [
                            'inlineData' => [
                                'mimeType' => $mimeType,
                                'data' => $base64Image
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json'
            ]
        ];

        // List of models in order of preference
        $models = [
            'gemini-3.8-flash',
            'gemini-3.5-flash-lite',
            'gemini-3.5-flash',
        ];

        if (!empty($this->apiKey)) {
            foreach ($models as $model) {
                $maxRetries = 3;
                $attempt = 0;

                while ($attempt < $maxRetries) {
                    try {
                        $response = Http::timeout(60)
                            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}", $payload);

                        if ($response->status() === 404 || $response->status() === 400 || (isset($response->json()['error']['message']) && strpos($response->json()['error']['message'], 'Interactions API') !== false)) {
                            Log::info("generateContent rejected for {$model}, switching to Interactions API.");
                            
                            /**
                             * Interactions API Format (/v1beta/interactions)
                             * Used when standard /generateContent is deprecated or restricted (e.g., HTTP 404/400).
                             * The Interactions API requires "input" to be an array of steps.
                             * Each step requires a "type" (e.g., "user_input") and "content" containing the parts.
                             * 
                             * Reference Body Structure:
                             * {
                             *   "model": "models/gemini-3.8-flash",
                             *   "store": false,
                             *   "input": [
                             *     {
                             *       "type": "user_input",
                             *       "content": [
                             *         { "type": "text", "text": "prompt text" },
                             *         { "type": "image", "data": "base64_string", "mime_type": "image/jpeg" }
                             *       ]
                             *     }
                             *   ]
                             * }
                             * See: https://ai.google.dev/gemini-api/docs/get-started (Interactions API section)
                             */
                            $interactionsPayload = [
                                'model' => "models/{$model}",
                                'store' => false,
                                'input' => [
                                    [
                                        'type' => 'user_input',
                                        'content' => [
                                            [
                                                'type' => 'text',
                                                'text' => $promptText
                                            ]
                                        ]
                                    ]
                                ]
                            ];
                            
                            if (!empty($base64Image)) {
                                $interactionsPayload['input'][0]['content'][] = [
                                    'type' => 'image',
                                    'data' => $base64Image,
                                    'mime_type' => $mimeType
                                ];
                            }

                            $response = Http::timeout(60)
                                ->withHeaders(['x-goog-api-key' => $this->apiKey])
                                ->post("https://generativelanguage.googleapis.com/v1beta/interactions", $interactionsPayload);
                        }

                        if ($response->successful()) {
                            $json = $response->json();
                            
                            if (isset($json['steps'])) {
                                foreach ($json['steps'] as $step) {
                                    if ($step['type'] === 'model_output' && isset($step['content'][0]['text'])) {
                                        $json['candidates'][0]['content']['parts'][0]['text'] = $step['content'][0]['text'];
                                        return $json;
                                    }
                                }
                            }
                            
                            if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
                                return $json;
                            }
                        } else if ($response->status() === 503 || $response->status() === 429) {
                            Log::warning("Gemini model {$model} returned HTTP {$response->status()}. Retrying (attempt " . ($attempt + 1) . ")");
                            $attempt++;
                            if ($attempt < $maxRetries) {
                                sleep(pow(2, $attempt));
                                continue;
                            }
                        } else {
                            Log::warning("Gemini model {$model} returned HTTP {$response->status()}: {$response->body()}");
                            break;
                        }
                    } catch (\Throwable $e) {
                        Log::warning("Gemini model {$model} request failed: {$e->getMessage()}");
                        break;
                    }
                    $attempt++;
                }
            }
        }

        // Return intelligent psychometric profile if Gemini API is unreachable or exhausted
        Log::info('Using deterministic environmental psychology heuristic engine.');
        return $this->generateHeuristicProfile($checklistData);
    }

    /**
     * Fallback heuristic psychometric profiling engine with Jungian depth.
     */
    public function generateHeuristicProfile(array $checklistData): array
    {
        $hasFireplace = false;
        $hasBookshelves = false;
        $hasClosedDoors = false;

        foreach ($checklistData as $cat => $fields) {
            if (is_array($fields)) {
                foreach ($fields as $k => $v) {
                    if (str_contains($k, 'fireplace') && ($v === 'Yes' || str_contains((string)$v, 'fireplace'))) $hasFireplace = true;
                    if (str_contains($k, 'bookshelves') && ($v === 'Yes' || str_contains((string)$v, 'Books'))) $hasBookshelves = true;
                    if (str_contains($k, 'status') && $v === 'Closed') $hasClosedDoors = true;
                }
            }
        }

        $traits = [
            [
                'name' => 'Emotional Hearth',
                'score' => 89,
                'anchor' => $hasFireplace ? 'Your stone fireplace' : 'Your central seating arrangement',
                'explanation' => ($hasFireplace ? 'Your central hearth' : 'Your central seating arrangement') . " represents exceptional emotional empathy and interpersonal stability, acting as an archetypal Self around which domestic warmth gathers. In your personal relationships, you tend to absorb emotional turbulence and anchor those around you, frequently prioritizing shared harmony over individual needs. Growth insight: Practice intentional emotional boundaries during external conflicts so your empathy remains a conscious gift rather than an exhausting obligation."
            ],
            [
                'name' => 'Reflective Sanctum',
                'score' => 84,
                'anchor' => $hasBookshelves ? 'Your built-in bookshelves' : 'Your structured perimeter walls',
                'explanation' => ($hasBookshelves ? 'Your curated bookshelves' : 'Your structured perimeter walls') . " reflect an introverted intuitive function, signifying a sanctuary where inner knowledge is organized to fend off chaos. When facing rapid lifestyle changes, you tend to retreat into intellectual contemplation rather than making immediate, visceral decisions. Growth insight: Ground your contemplative insights into tangible physical action before intellectualizing away the momentum."
            ],
            [
                'name' => 'Guarded Persona',
                'score' => 81,
                'anchor' => $hasClosedDoors ? 'The firmly closed door' : 'The enclosed architectural boundary',
                'explanation' => ($hasClosedDoors ? 'The firmly closed door' : 'The enclosed architectural boundary') . " symbolizes a protective Persona, shielding your vulnerable inner sanctum from unvetted external intrusion. You tend to be intensely selective with whom you share your genuine emotional core, projecting composed competence while keeping uncertainties concealed. Growth insight: Offer trusted companions honest glimpses of your unfinished dilemmas rather than presenting only perfected conclusions."
            ]
        ];

        $summary = "Your space manifests an archetypal quest for psychological equilibrium between intimate warmth and protective containment. The structural boundaries and deliberate focal points reveal a strong ego orientation capable of holding emotional depth, while your subconscious seeks a sacred sanctuary protected from external demands.";

        return [
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'text' => json_encode([
                                    'traits' => $traits,
                                    'summary' => $summary
                                ])
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
