<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\ChecklistResponse;
use App\Jobs\GenerateRoomImageJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Create a new room generation session.
     */
    public function store(Request $request)
    {
        try {
            $checklist = $request->input('checklist');
            if (empty($checklist) || !is_array($checklist)) {
                $checklist = $request->except(['_token', 'session_id']);
            }

            if (empty($checklist) || !is_array($checklist)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Checklist data is required and must be an object or array.',
                ], 422);
            }

            $room = \Illuminate\Support\Facades\DB::transaction(function () use ($checklist) {
                $room = Room::create([
                    'session_id' => (string) Str::uuid(),
                    'status' => 'generating',
                    'checklist_data' => $checklist,
                ]);

                foreach ($checklist as $category => $items) {
                    if (is_array($items)) {
                        foreach ($items as $fieldName => $fieldValue) {
                            ChecklistResponse::create([
                                'room_id' => $room->id,
                                'category' => $category,
                                'field_name' => $fieldName,
                                'field_value' => is_array($fieldValue) ? json_encode($fieldValue) : (string) $fieldValue,
                            ]);
                        }
                    }
                }

                return $room;
            });

            // Dispatch background job to database queue
            GenerateRoomImageJob::dispatch($room);

            return response()->json([
                'message' => 'Room submitted successfully',
                'session_id' => $room->session_id,
                'status' => $room->status,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("RoomController::store failed: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Get full room data including image and personality profile.
     */
    public function show($sessionId)
    {
        $room = Room::where('session_id', $sessionId)->firstOrFail();
        
        $profile = \App\Models\PersonalityProfile::where('room_id', $room->id)->first();

        $imageUrl = $room->image_url;
        if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
            $imageUrl = url($imageUrl);
        }

        $profileData = $profile ? [
            'traits' => $profile->traits,
            'summary' => $profile->summary,
        ] : null;

        return response()->json([
            'session_id' => $room->session_id,
            'status' => $room->status,
            'image_url' => $imageUrl,
            'checklist_data' => $room->checklist_data,
            'personality_profile' => $profileData,
            'profile' => $profileData,
            'room' => [
                'id' => $room->id,
                'session_id' => $room->session_id,
                'status' => $room->status,
                'image_url' => $imageUrl,
                'profile' => $profileData,
                'personality_profile' => $profileData,
            ]
        ]);
    }

    /**
     * Polling endpoint for status.
     */
    public function status($sessionId)
    {
        try {
            $room = Room::where('session_id', $sessionId)->firstOrFail();

            $profile = \App\Models\PersonalityProfile::where('room_id', $room->id)->first();

            $imageUrl = $room->image_url;
            if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                $imageUrl = url($imageUrl);
            }

            $profileData = $profile ? [
                'traits' => $profile->traits,
                'summary' => $profile->summary,
            ] : null;

            return response()->json([
                'status' => $room->status,
                'image_url' => $imageUrl,
                'has_personality_profile' => !is_null($profile),
                'personality_profile' => $profileData,
                'profile' => $profileData,
                'room' => [
                    'id' => $room->id,
                    'session_id' => $room->session_id,
                    'status' => $room->status,
                    'image_url' => $imageUrl,
                    'profile' => $profileData,
                    'personality_profile' => $profileData,
                ]
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("RoomController::status error: " . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Return the checklist configuration for frontend and iOS.
     */
    public function checklistConfig()
    {
        return response()->json(config('checklist'));
    }
}
