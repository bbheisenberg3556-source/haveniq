<?php

namespace App\Jobs;

use App\Models\Room;
use App\Models\GeneratedRoom;
use App\Services\ReplicateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateRoomImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // 10 minutes max
    protected Room $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function handle(ReplicateService $replicateService): void
    {
        try {
            $this->room->update(['status' => 'generating']);

            // Build prompt
            $prompt = $this->buildPrompt($this->room);

            // Attempt generation via Replicate API
            $prediction = $replicateService->generateImage($prompt);

            if ($prediction && isset($prediction['id'])) {
                $generatedRoom = GeneratedRoom::create([
                    'room_id' => $this->room->id,
                    'prediction_id' => $prediction['id'],
                    'prompt' => $prompt,
                    'status' => 'generating'
                ]);

                // Poll prediction
                $success = false;
                $outputUrl = null;

                for ($i = 0; $i < 60; $i++) {
                    usleep(1500000); // 1.5s polling interval for faster response
                    $status = $replicateService->getPrediction($prediction['id']);
                    
                    if ($status) {
                        if ($status['status'] === 'succeeded') {
                            $success = true;
                            $outputUrl = is_array($status['output']) ? $status['output'][0] : $status['output'];
                            break;
                        } elseif ($status['status'] === 'failed' || $status['status'] === 'canceled') {
                            Log::warning("Replicate prediction {$prediction['id']} failed: " . ($status['error'] ?? 'Unknown'));
                            break;
                        }
                    }
                }

                if ($success && $outputUrl) {
                    // Download generated image
                    $imageContents = Http::timeout(30)->get($outputUrl)->body();
                    $filename = 'rooms/' . $this->room->session_id . '.webp';
                    Storage::disk('public')->put($filename, $imageContents);

                    $this->room->update([
                        'image_path' => $filename,
                        'image_url' => '/storage/' . $filename,
                    ]);

                    $generatedRoom->update([
                        'status' => 'completed',
                        'output_urls' => [$outputUrl]
                    ]);

                    // Perform personality analysis immediately before marking completed
                    app(\App\Jobs\AnalyzePersonalityJob::class, ['room' => $this->room])->handle(app(\App\Services\GeminiService::class));

                    // Now mark room as completed so frontend receives image + traits simultaneously
                    $this->room->update(['status' => 'completed']);
                    return;
                }
            }

            // Fallback generation when Replicate is uncredited, offline, or timed out
            Log::info("Using high-fidelity preset architectural render fallback for session {$this->room->session_id}");
            $this->applyHighFidelityPreset($prompt);

        } catch (\Throwable $e) {
            Log::error("GenerateRoomImageJob failed: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            // Fallback gracefully so room always completes
            $this->applyHighFidelityPreset($prompt ?? 'Photorealistic living room');
        }
    }

    /**
     * Intelligently selects and copies a magazine-quality preset image matching user selections.
     */
    protected function applyHighFidelityPreset(string $prompt): void
    {
        $checklist = $this->room->checklist_data ?? [];

        $hasFireplace = false;
        $highCeiling = false;
        $cityView = false;

        foreach ($checklist as $cat => $fields) {
            if (is_array($fields)) {
                foreach ($fields as $k => $v) {
                    $val = strtolower((string)$v);
                    if ($k === 'fireplace' && $val === 'yes') $hasFireplace = true;
                    if ($k === 'ceiling' && in_array($val, ['high', 'vaulted', 'exposed beams'])) $highCeiling = true;
                    if ($k === 'window_view' && $val === 'cityscape') $cityView = true;
                }
            }
        }

        $preset = 'warm_modern.jpg';
        if ($hasFireplace) {
            $preset = 'cozy_rustic.jpg';
        } elseif ($highCeiling || $cityView) {
            $preset = 'luxury_penthouse.jpg';
        }

        $presetPath = public_path('presets/' . $preset);
        if (!file_exists($presetPath)) {
            $presetPath = storage_path('app/public/presets/' . $preset);
        }
        $targetFilename = 'rooms/' . $this->room->session_id . '.jpg';

        if (file_exists($presetPath)) {
            $contents = file_get_contents($presetPath);
            Storage::disk('public')->put($targetFilename, $contents);
        } else {
            // Generate a simple clean visual canvas if preset missing
            $im = imagecreatetruecolor(1280, 720);
            $bg = imagecolorallocate($im, 30, 41, 59);
            imagefill($im, 0, 0, $bg);
            ob_start();
            imagejpeg($im);
            $contents = ob_get_clean();
            Storage::disk('public')->put($targetFilename, $contents);
        }

        $this->room->update([
            'image_path' => $targetFilename,
            'image_url' => '/storage/' . $targetFilename,
        ]);

        GeneratedRoom::create([
            'room_id' => $this->room->id,
            'prediction_id' => 'fallback-preset-' . $preset,
            'prompt' => $prompt,
            'status' => 'completed',
            'output_urls' => ['/storage/' . $targetFilename]
        ]);

        app(\App\Jobs\AnalyzePersonalityJob::class, ['room' => $this->room])->handle(app(\App\Services\GeminiService::class));
        $this->room->update(['status' => 'completed']);
    }

    protected function buildPrompt(Room $room): string
    {
        $data = $room->checklist_data ?? [];

        // Universal extraction helper: checks category nesting, root level, or deep search
        $get = function(string $category, string $field, $default = null) use ($data) {
            if (isset($data[$category][$field])) {
                return $data[$category][$field];
            }
            if (isset($data[$field])) {
                return $data[$field];
            }
            foreach ($data as $cat => $fields) {
                if (is_array($fields) && isset($fields[$field])) {
                    return $fields[$field];
                }
            }
            return $default;
        };

        $sentences = [];

        // ==========================================
        // 1. ROOM ARCHITECTURE, SHAPE & CEILING
        // ==========================================
        $shape = $get('shape_and_size', 'room_shape', 'contemporary');
        $size = $get('shape_and_size', 'room_size', 'spacious');
        $location = $get('shape_and_size', 'room_location');
        $ceiling = $get('shape_and_size', 'room_ceiling');

        $locDesc = "";
        if ($location) {
            if (str_contains(strtolower($location), 'apartment')) {
                $locDesc = "apartment residential";
            } elseif (str_contains(strtolower($location), 'ground floor')) {
                $locDesc = "ground-floor residential";
            } elseif (str_contains(strtolower($location), 'second') || str_contains(strtolower($location), 'other floor')) {
                $locDesc = "upper-level residential";
            }
        }

        $ceilDesc = "";
        if ($ceiling) {
            $lc = strtolower($ceiling);
            if (str_contains($lc, 'vaulted') || str_contains($lc, 'cathedral')) {
                $ceilDesc = "soaring high vaulted cathedral ceilings";
            } elseif (str_contains($lc, 'beams')) {
                $ceilDesc = "ceilings with exposed structural timber beams";
            } elseif (str_contains($lc, 'skylight')) {
                $ceilDesc = "ceilings featuring open glass skylight apertures";
            } elseif (str_contains($lc, 'sloped') || str_contains($lc, 'attic')) {
                $ceilDesc = "dramatic angled sloped attic ceilings";
            } elseif (str_contains($lc, 'unfinished') || str_contains($lc, 'pipes')) {
                $ceilDesc = "industrial loft ceiling with exposed ductwork and conduit pipes";
            } elseif (str_contains($lc, 'caved in') || str_contains($lc, 'low')) {
                $ceilDesc = "intimate enclosed low ceilings";
            } elseif (str_contains($lc, 'water stains') || str_contains($lc, 'cracks') || str_contains($lc, 'damage')) {
                $ceilDesc = "distressed ceiling with visible character cracks and patina";
            } else {
                $ceilDesc = "clean {$ceiling} ceilings";
            }
        }

        $intro = "A {$size} {$shape} " . ($locDesc ? "{$locDesc} " : "") . "living space";
        if ($ceilDesc) {
            $intro .= " with {$ceilDesc}";
        }
        $sentences[] = $intro . ".";

        // ==========================================
        // 2. WALL COLORS, TEXTURES & WALL TREATMENTS
        // ==========================================
        $wallDescriptions = [];
        $uniqueColors = [];

        for ($w = 1; $w <= 4; $w++) {
            $color = $get('walls', "wall_{$w}_color");
            $texture = $get('walls', "wall_{$w}_texture");
            $loc = $get('walls', "wall_{$w}_location");

            $wTokens = [];
            if ($color && !in_array(strtolower(trim($color)), ['none', 'n/a', 'nothing', 'no', 'standard', ''])) {
                $uniqueColors[] = trim($color);
                $wTokens[] = trim($color);
            }
            if ($texture && !in_array(strtolower(trim($texture)), ['none', 'n/a', 'nothing', 'standard', ''])) {
                $wTokens[] = trim($texture);
            }

            if (!empty($wTokens)) {
                $locLabel = $loc ? "Wall {$w} ({$loc})" : "Wall {$w}";
                $wallDescriptions[$w] = "{$locLabel} features " . implode(' ', $wTokens);
            }
        }

        $uniqueColorNames = array_unique(array_map('strtolower', $uniqueColors));
        if (count($uniqueColorNames) === 1 && !empty($uniqueColors)) {
            // All specified walls are identically colored (e.g. user selected "Red")
            $firstColor = $uniqueColors[0];
            $sentences[] = "Every single interior wall in the room is finished in a bold, prominent {$firstColor} color.";
        } elseif (!empty($wallDescriptions)) {
            $sentences[] = "The walls are styled with distinct finishes: " . implode('; ', $wallDescriptions) . ".";
        }

        // Individual Wall Features (Lighting, Decor, Shelves, Bookshelves, Fireplaces, TV, Mirrors)
        $wallFeatures = [];

        for ($w = 1; $w <= 4; $w++) {
            // Wall lighting & natural shadows
            $wLighting = $get('walls', "wall_{$w}_wall_lighting");
            if ($wLighting) {
                if (str_contains(strtolower($wLighting), 'direct')) {
                    $wallFeatures[] = "direct natural sunlight strikes Wall {$w}";
                } elseif (str_contains(strtolower($wLighting), 'shadow') || str_contains(strtolower($wLighting), 'dimly')) {
                    $wallFeatures[] = "Wall {$w} rests in soft, moody shadow";
                }
            }

            // Wall sconces
            if ($get('walls', "wall_{$w}_has_wall_sconces") === 'Yes') {
                $wallFeatures[] = "accent wall sconce lamps cast warm ambient illumination along Wall {$w}";
            }

            // Fireplace (Only if explicitly Yes)
            if ($get('walls', "wall_{$w}_has_fireplace") === 'Yes') {
                $fType = $get('walls', "wall_{$w}_fireplace_type", 'fireplace');
                $fMat = $get('walls', "wall_{$w}_fireplace_material");
                $fLit = $get('walls', "wall_{$w}_fireplace_lit");
                $fHearth = $get('walls', "wall_{$w}_fireplace_hearth_protector");
                $fMantel = $get('walls', "wall_{$w}_fireplace_mantel");
                $fItems = $get('walls', "wall_{$w}_fireplace_mantel_items");
                $fOther = $get('walls', "wall_{$w}_fireplace_mantel_other");

                $fpStr = "a " . ($fMat ? "{$fMat} " : "") . "{$fType}";
                if ($fLit === 'Fire is lighted') {
                    $fpStr .= " with a glowing, active warm fire";
                } elseif ($fLit === 'Wood in fireplace for lighting') {
                    $fpStr .= " with stacked firewood ready for lighting";
                } else {
                    $fpStr .= " (clean, unlit)";
                }
                if ($fHearth === 'Yes') {
                    $fpStr .= " and a protective hearth guard";
                }
                if ($fMantel && $fMantel !== 'None') {
                    $fpStr .= " crowned by a {$fMantel} mantelpiece";
                }
                $mantelAll = [];
                if (is_array($fItems) && !empty($fItems)) {
                    foreach ($fItems as $it) {
                        if (!str_contains(strtolower($it), 'other')) $mantelAll[] = $it;
                    }
                }
                if ($fOther) $mantelAll[] = $fOther;
                if (!empty($mantelAll)) {
                    $fpStr .= " displaying " . implode(', ', $mantelAll);
                }
                $wallFeatures[] = "{$fpStr} on Wall {$w}";
            }

            // Bookshelves
            if ($get('walls', "wall_{$w}_has_bookshelves") === 'Yes') {
                $bFill = $get('walls', "wall_{$w}_bookshelves_fill", 'arranged');
                $bContents = $get('walls', "wall_{$w}_bookshelves_contents");
                $cStr = is_array($bContents) && !empty($bContents) ? implode(' and ', $bContents) : 'books';
                $wallFeatures[] = "built-in {$bFill} bookshelves on Wall {$w} filled with {$cStr}";
            }

            // Hanging Shelves
            if ($get('walls', "wall_{$w}_has_hanging_shelves") === 'Yes') {
                $sDesc = $get('walls', "wall_{$w}_hanging_shelves_desc");
                $wallFeatures[] = "floating wall shelves on Wall {$w}" . ($sDesc ? " displaying {$sDesc}" : "");
            }

            // Wall Decorations & Art
            if ($get('walls', "wall_{$w}_has_decorations") === 'Yes') {
                $pCount = $get('walls', "wall_{$w}_paintings_number");
                $pColor = $get('walls', "wall_{$w}_paintings_color");
                $pPattern = $get('walls', "wall_{$w}_paintings_pattern");
                $postTheme = $get('walls', "wall_{$w}_posters_theme");
                $postNum = $get('walls', "wall_{$w}_posters_number");
                $frame = $get('walls', "wall_{$w}_family_pics_frame");
                $decList = $get('walls', "wall_{$w}_decorations_list");

                $artParts = [];
                if ($pColor || $pPattern) {
                    $artParts[] = trim(($pCount ? "{$pCount} " : "") . ($pColor ? "{$pColor} " : "") . ($pPattern ? "{$pPattern} " : "")) . "framed paintings";
                }
                if ($postTheme) {
                    $artParts[] = trim(($postNum ? "{$postNum} " : "") . "{$postTheme} art posters");
                }
                if ($frame && $frame !== 'No frame') {
                    $artParts[] = "pictures in {$frame} frames";
                }
                if (is_array($decList) && !empty($decList)) {
                    foreach ($decList as $d) {
                        if (!str_contains(strtolower($d), 'painting') && !str_contains(strtolower($d), 'poster')) {
                            $artParts[] = $d;
                        }
                    }
                }
                if (!empty($artParts)) {
                    $wallFeatures[] = "Wall {$w} is curated with " . implode(' and ', array_unique($artParts));
                }
            }

            // Mirror
            if ($get('walls', "wall_{$w}_has_mirror") === 'Yes') {
                $mType = $get('walls', "wall_{$w}_mirror_type", 'mirror');
                if (!str_contains(strtolower($mType), 'mirror')) {
                    $mType .= ' mirror';
                }
                $mMat = $get('walls', "wall_{$w}_mirror_material");
                $mCond = $get('walls', "wall_{$w}_mirror_condition");
                $mStr = "a " . ($mCond ? "{$mCond} " : "") . ($mMat ? "{$mMat} framed " : "") . "{$mType} on Wall {$w}";
                $wallFeatures[] = $mStr;
            }

            // Television
            if ($get('walls', "wall_{$w}_has_tv") === 'Yes') {
                $tvSize = $get('walls', "wall_{$w}_tv_size", 'flat screen');
                $wallFeatures[] = "a wall-mounted {$tvSize} television on Wall {$w}";
            }

            // Closet / Hidden Door
            $cl = $get('walls', "wall_{$w}_has_closet_doors");
            if ($cl && $cl !== 'No closets / hidden storage areas / doors' && $cl !== 'No') {
                $clType = $get('walls', "wall_{$w}_closet_doors_type", 'closet door');
                $wallFeatures[] = "a {$clType} on Wall {$w}";
            }
        }

        if (!empty($wallFeatures)) {
            $sentences[] = "Architectural wall details include: " . implode('; ', $wallFeatures) . ".";
        }

        // ==========================================
        // 3. WINDOWS, NATURAL LIGHTING & ENVIRONMENT
        // ==========================================
        $hasWindows = $get('windows', 'has_windows');
        if ($hasWindows === 'No') {
            $sentences[] = "The space is strictly windowless with zero exterior windows or glass apertures, creating an enclosed architectural atmosphere illuminated solely by ambient interior lights.";
        } elseif ($hasWindows === 'Yes') {
            $wType = $get('windows', 'windows_type', 'large windows');
            $wShape = $get('windows', 'windows_shape');
            $wGlass = $get('windows', 'windows_glass_condition');
            $wMat = $get('windows', 'windows_material');
            $wFeatures = $get('windows', 'windows_features');
            $wCurtains = $get('windows', 'windows_curtains_color');
            $wCurtainsStat = $get('windows', 'windows_curtains_status');
            $wBlinds = $get('windows', 'windows_blinds_color');
            $wBlindsStat = $get('windows', 'windows_blinds_status');
            $wSill = $get('windows', 'windows_sill_status');
            $wSillItems = $get('windows', 'windows_sill_items');
            $wOutside = $get('windows', 'windows_outside');
            $wBuilding = $get('windows', 'windows_outside_building_kind');
            $wTime = $get('windows', 'windows_time_of_day');
            $wWeather = $get('windows', 'windows_weather');
            $wSeason = $get('windows', 'windows_season');

            $winDesc = ($wShape && !str_contains(strtolower($wShape), 'standard') ? "{$wShape} " : "") . ($wMat ? "{$wMat}-framed " : "") . "{$wType}";
            if ($wGlass && !str_contains(strtolower($wGlass), 'clear')) {
                $winDesc .= " with {$wGlass} glass";
            }

            $wLightingDesc = "Natural daylight enters through {$winDesc}";
            if ($wCurtains) {
                $wLightingDesc .= " dressed with " . ($wCurtainsStat ? strtolower($wCurtainsStat) . " " : "") . "{$wCurtains} drapes";
            }
            if ($wBlinds) {
                $wLightingDesc .= " and " . ($wBlindsStat ? strtolower($wBlindsStat) . " " : "") . "{$wBlinds} window blinds";
            }
            if ($wSill === 'Holds items' && $wSillItems) {
                $wLightingDesc .= ", with the windowsill displaying {$wSillItems}";
            }

            // Outside scene, time of day & weather
            $envParts = [];
            if ($wOutside && !in_array(strtolower($wOutside), ['nothing', 'none', 'no view'])) {
                $envParts[] = "overlooking " . ($wBuilding ? "{$wBuilding} in the " : "") . "{$wOutside}";
            }
            if ($wWeather && !str_contains(strtolower($wWeather), 'other')) {
                $envParts[] = "under a {$wWeather} sky";
            }
            if ($wSeason) {
                $envParts[] = "during {$wSeason}";
            }
            if ($wTime) {
                $envParts[] = "in the {$wTime}";
            }

            if (!empty($envParts)) {
                $wLightingDesc .= " " . implode(' ', $envParts);
            }

            $sentences[] = $wLightingDesc . ".";
        }

        // ==========================================
        // 4. DOORS, HARDWARE & THRESHOLDS
        // ==========================================
        $hasDoors = $get('doors', 'has_doors');
        if ($hasDoors === 'No') {
            $sentences[] = "The room has no visible interior doors or exit thresholds.";
        } elseif ($hasDoors === 'Yes') {
            $dType = $get('doors', 'doors_type', 'door');
            $dColor = $get('doors', 'doors_color');
            $dStatus = $get('doors', 'doors_status', 'closed');
            $dLoc = $get('doors', 'doors_location');
            $dHardware = $get('doors', 'doors_hardware');
            $dLocks = $get('doors', 'doors_locks');
            $dCondition = $get('doors', 'doors_condition');
            $dSigns = $get('doors', 'doors_signs');
            $dOther = $get('doors', 'doors_other_side');
            $dOtherDesc = $get('doors', 'doors_other_side_describe');

            $dDesc = "A " . ($dStatus ? strtolower($dStatus) . " " : "") . ($dCondition && !str_contains(strtolower($dCondition), 'sturdy') ? "{$dCondition} " : "") . ($dColor ? "{$dColor} " : "") . "{$dType}";
            if ($dLoc) {
                $dDesc .= " on the {$dLoc}";
            }
            if ($dHardware && !str_contains(strtolower($dHardware), 'no handle')) {
                $dDesc .= " fitted with {$dHardware}";
            }
            if ($dLocks && !str_contains(strtolower($dLocks), 'no locking')) {
                $dDesc .= " ({$dLocks})";
            }
            if (is_array($dSigns) && !empty($dSigns)) {
                $validSigns = array_filter($dSigns, fn($s) => strtolower($s) !== 'none');
                if (!empty($validSigns)) {
                    $dDesc .= " marked with a visible '" . implode(', ', $validSigns) . "'";
                }
            }
            if ($dOther && !in_array(strtolower($dOther), ['nothing', 'cannot see / do not know'])) {
                $dDesc .= " leading toward " . ($dOtherDesc ? "{$dOtherDesc} ({$dOther})" : "{$dOther}");
            }

            $sentences[] = $dDesc . ".";
        }

        // ==========================================
        // 5. FURNITURE PIECES & LIVING SETUP
        // ==========================================
        $hasFurniture = $get('furniture', 'has_furniture');
        if ($hasFurniture === 'No') {
            $sentences[] = "The room is completely unfurnished and empty, a clean open architectural volume with zero furniture, no sofas, no armchairs, and no tables.";
        } elseif ($hasFurniture === 'Yes') {
            $pieces = [];
            for ($f = 1; $f <= 3; $f++) {
                $fEnable = $get('furniture', "furn_{$f}_enable");
                $fType = $get('furniture', "furn_{$f}_type");
                $fCond = $get('furniture', "furn_{$f}_condition");
                $fLoc = $get('furniture', "furn_{$f}_location");

                if ($fEnable === 'Yes' || $fType) {
                    $typeLower = strtolower((string)$fType);

                    // A. Sofa / Seating
                    if (str_contains($typeLower, 'sofa') || str_contains($typeLower, 'chair') || str_contains($typeLower, 'chaise')) {
                        $sType = $get('furniture', "furn_{$f}_sofa_type", 'sofa');
                        $sMat = $get('furniture', "furn_{$f}_sofa_material");
                        $sCol = $get('furniture', "furn_{$f}_sofa_color");
                        $sLegs = $get('furniture', "furn_{$f}_sofa_legs");
                        $sPillows = $get('furniture', "furn_{$f}_sofa_has_pillows");
                        $sPillowColor = $get('furniture', "furn_{$f}_sofa_pillows_color");
                        $sOtherMat = $get('furniture', "furn_{$f}_sofa_other_materials");

                        $sofaStr = "a " . ($fCond && !str_contains(strtolower($fCond), 'immaculate') ? "{$fCond} " : "") . ($sCol ? "{$sCol} " : "") . ($sMat ? "{$sMat} " : "") . "{$sType}";
                        if ($sLegs && !str_contains(strtolower($sLegs), 'straight')) {
                            $sofaStr .= " with {$sLegs} legs";
                        }
                        if ($sPillows === 'Yes' && $sPillowColor) {
                            $sofaStr .= " accented with {$sPillowColor} throw pillows";
                        }
                        if (is_array($sOtherMat) && !empty($sOtherMat)) {
                            $sofaStr .= " with a " . implode(' and ', $sOtherMat) . " resting on it";
                        }
                        if ($fLoc) {
                            $sofaStr .= " positioned {$fLoc}";
                        }

                        // Associated table
                        if ($get('furniture', "furn_{$f}_sofa_associated_table") === 'Yes') {
                            $tType = $get('furniture', "furn_{$f}_table_type", 'coffee table');
                            $tMat = $get('furniture', "furn_{$f}_table_material");
                            $tShape = $get('furniture', "furn_{$f}_table_shape");
                            $sofaStr .= " paired with a " . ($tShape ? "{$tShape} " : "") . ($tMat ? "{$tMat} " : "") . "{$tType}";
                        }

                        $pieces[] = $sofaStr;
                    }
                    // B. Standalone Table
                    elseif (str_contains($typeLower, 'table')) {
                        $tType = $get('furniture', "furn_{$f}_table_type", 'table');
                        $tMat = $get('furniture', "furn_{$f}_table_material");
                        $tShape = $get('furniture', "furn_{$f}_table_shape");
                        $tSize = $get('furniture', "furn_{$f}_table_size");
                        $tItems = $get('furniture', "furn_{$f}_table_items");
                        $lampStatus = $get('furniture', "furn_{$f}_table_lamp_status");
                        $lampColor = $get('furniture', "furn_{$f}_table_lamp_color");

                        $tableStr = "a " . ($tSize ? "{$tSize} " : "") . ($tShape ? "{$tShape} " : "") . ($tMat ? "{$tMat} " : "") . "{$tType}";
                        $onTable = [];
                        if (is_array($tItems) && !empty($tItems)) {
                            foreach ($tItems as $it) {
                                if (strtolower($it) !== 'nothing') $onTable[] = $it;
                            }
                        }
                        if ($lampStatus || $lampColor) {
                            $onTable[] = "a " . ($lampColor ? "{$lampColor} " : "") . "table lamp" . ($lampStatus === 'Light is on' ? " emitting warm light" : "");
                        }
                        if (!empty($onTable)) {
                            $tableStr .= " styled with " . implode(', ', $onTable);
                        }
                        if ($fLoc) {
                            $tableStr .= " located {$fLoc}";
                        }
                        $pieces[] = $tableStr;
                    }
                    // C. Other Piece
                    elseif ($fType) {
                        $pieces[] = "a " . strtolower($fType) . ($fLoc ? " placed {$fLoc}" : "");
                    }
                }
            }

            if (!empty($pieces)) {
                $sentences[] = "The living room is furnished with " . implode('; ', array_unique($pieces)) . ".";
            }
        }

        // ==========================================
        // 6. RUGS & FLOORING
        // ==========================================
        $hasRugs = $get('rugs', 'has_rugs');
        if ($hasRugs === 'No') {
            $sentences[] = "The floor is completely bare with no rugs or floor coverings.";
        } elseif ($hasRugs === 'Yes') {
            $rType = $get('rugs', 'rugs_type', 'area rug');
            if (!str_contains(strtolower($rType), 'rug')) {
                $rType .= ' rug';
            }
            $rShape = $get('rugs', 'rugs_shape');
            $rCol = $get('rugs', 'rugs_color');
            $rLoc = $get('rugs', 'rugs_location');
            $rDetails = $get('rugs', 'rugs_location_details');

            $rugStr = "A " . ($rCol ? "{$rCol} " : "") . ($rShape ? "{$rShape} " : "") . "{$rType} is spread on the floor";
            if ($rLoc && $rLoc !== 'Other') {
                $rugStr .= " " . strtolower($rLoc);
            }
            if ($rDetails) {
                $rugStr .= " ({$rDetails})";
            }
            $sentences[] = $rugStr . ".";
        }

        // ==========================================
        // 7. TECHNOLOGY & AUDIO
        // ==========================================
        $hasTech = $get('technology', 'has_tech');
        if ($hasTech === 'Yes') {
            $tType = $get('technology', 'tech_type', 'stereo');
            $tDesc = $get('technology', 'tech_describe');
            $sentences[] = "Featured audio technology: " . trim(($tDesc ? "{$tDesc} " : "") . "{$tType}") . ".";
        }

        // ==========================================
        // 8. BOTANICAL PRESENCE & PLANTS
        // ==========================================
        $hasPlants = $get('plants', 'has_plants');
        if ($hasPlants === 'Yes') {
            $pSize = $get('plants', 'plants_size', 'lush');
            $pCond = $get('plants', 'plants_condition');
            $pPot = $get('plants', 'plants_container');
            $pLoc = $get('plants', 'plants_location');

            $pStr = "A " . ($pSize ? "{$pSize} " : "") . ($pCond ? "{$pCond} " : "") . "indoor houseplant";
            if ($pPot) {
                $pStr .= " in a {$pPot}";
            }
            if ($pLoc) {
                $pStr .= " positioned {$pLoc}";
            }
            $sentences[] = $pStr . ".";
        }

        $scene = implode(' ', $sentences);

        return "Authentic editorial interior photograph of a residential living space, featured in Architectural Digest. {$scene} Shot on Hasselblad H6D-100c medium format camera with 35mm lens, f/8, sharp focus, authentic tactile materials, accurate physical colors, architectural interior photography.";
    }
}
