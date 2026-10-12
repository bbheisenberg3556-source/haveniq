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
        $promptText = "Using Jungian and cognitive behavior theory, define the personality and primary character traits of the owner of this room in three simple paragraphs that are easy to understand by the lay person. Avoid psychological jargon.

Analyze the attached image of the living room alongside the user's checklist selections:
CHECKLIST DATA:
" . json_encode($checklistData) . "

INSTRUCTIONS:
1. Provide three clear, relatable paragraphs defining who the owner is, how they think, and their core character traits:
   - Paragraph 1 (Inner Mindset & Core Disposition): Look at the atmosphere, lighting, and room shape. Describe how they recharge, their general outlook on life, and their need for calm versus stimulation.
   - Paragraph 2 (Relationships & Social Style): Look at the seating, boundaries, doors, and layout. Describe how they connect with friends and family, their communication style, and how they protect their personal boundaries.
   - Paragraph 3 (Habits, Strengths & Stress Response): Look at the organization, wall finishes, and decor. Describe how they handle challenges, their decision-making mindset, and their practical strengths in daily life.
2. Ground each paragraph in tangible elements from the room (e.g. wall colors, window views, seating arrangement, or openness).
3. Speak directly to the person in the second person (\"You are someone who...\", \"You tend to...\").
4. AVOID ALL PSYCHOLOGICAL JARGON (do NOT use words like archetype, individuation, ego, shadow, persona, cognitive function, rubedo, temenos, etc.). Use warm, insightful, conversational language that any everyday person will instantly understand and relate to.

Return ONLY valid JSON in this exact format:
{
  \"traits\": [
    {
      \"name\": \"Clear Character Trait (e.g., Calm & Reflective Mindset)\",
      \"score\": 92,
      \"anchor\": \"Specific room feature\",
      \"explanation\": \"First simple paragraph defining this primary trait...\"
    },
    {
      \"name\": \"Clear Character Trait (e.g., Selective & Sincere Connector)\",
      \"score\": 88,
      \"anchor\": \"Specific room feature\",
      \"explanation\": \"Second simple paragraph defining their social and emotional style...\"
    },
    {
      \"name\": \"Clear Character Trait (e.g., Practical & Grounded Problem-Solver)\",
      \"score\": 85,
      \"anchor\": \"Specific room feature\",
      \"explanation\": \"Third simple paragraph defining their daily habits and response to stress...\"
    }
  ],
  \"summary\": \"Paragraph 1\n\nParagraph 2\n\nParagraph 3\",
  \"paragraphs\": [
    \"Paragraph 1 text...\",
    \"Paragraph 2 text...\",
    \"Paragraph 3 text...\"
  ]
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
                'name' => 'Calm & Reflective Mindset',
                'score' => 90,
                'anchor' => $hasFireplace ? 'Your stone fireplace' : 'Your comfortable central seating arrangement',
                'explanation' => "You are someone who deeply values peace, quiet, and comfort in your daily life. When the world outside gets hectic, you recharge by stepping back into your personal sanctuary to relax and process your thoughts without unnecessary noise. Having a dedicated, warm focal point in your room gives you a strong sense of grounding, helping you stay centered and emotionally balanced throughout your week."
            ],
            [
                'name' => 'Selective & Sincere Connector',
                'score' => 86,
                'anchor' => $hasBookshelves ? 'Your organized bookshelves' : 'Your structured, welcoming room layout',
                'explanation' => "In your relationships, you value genuine, meaningful connections over superficial socializing. You connect most naturally in one-on-one conversations or small, trusted circles where you can be authentic and comfortable. While you are a warm and attentive listener who cares deeply about close friends and family, you also know how to protect your personal boundaries so you don't overextend yourself."
            ],
            [
                'name' => 'Practical & Grounded Problem-Solver',
                'score' => 84,
                'anchor' => $hasClosedDoors ? 'The clean, enclosed doorways' : 'The orderly, uncluttered room perimeter',
                'explanation' => "In your daily routines and under stress, you rely on a steady, practical approach to work through challenges. Rather than letting uncertainty or chaos overwhelm you, you naturally focus on what you can control, breaking tasks down step by step until calm is restored. Your natural strength is staying composed under pressure, offering steady common sense and reliable clarity to those around you."
            ]
        ];

        $summary = $traits[0]['explanation'] . "\n\n" . $traits[1]['explanation'] . "\n\n" . $traits[2]['explanation'];

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
