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
            $request->validate([
                'checklist' => 'required|array',
            ]);

            $room = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $room = Room::create([
                    'session_id' => (string) Str::uuid(),
                    'status' => 'generating',
                    'checklist_data' => $request->checklist,
                ]);

                foreach ($request->checklist as $category => $items) {
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

        return response()->json([
            'session_id' => $room->session_id,
            'status' => $room->status,
            'image_url' => $room->image_url,
            'checklist_data' => $room->checklist_data,
            'personality_profile' => $profile ? [
                'traits' => $profile->traits,
                'summary' => $profile->summary,
            ] : null
        ]);
    }

    /**
     * Polling endpoint for status.
     */
    public function status($sessionId)
    {
        $room = Room::where('session_id', $sessionId)->firstOrFail();

        // Resilient self-healing: if the room has been generating for >= 7 seconds and isn't completed,
        // execute the generation immediately to guarantee the user receives their results without waiting.
        if ($room->status === 'generating' && $room->created_at && $room->created_at->diffInSeconds(now()) >= 7) {
            try {
                \Illuminate\Support\Facades\Log::info("Self-healing on-demand generation invoked for session {$room->session_id}");
                app(\App\Jobs\GenerateRoomImageJob::class, ['room' => $room])->handle(app(\App\Services\ReplicateService::class));
                $room->refresh();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("On-demand execution failed: " . $e->getMessage());
            }
        }

        $profile = \App\Models\PersonalityProfile::where('room_id', $room->id)->first();

        return response()->json([
            'status' => $room->status,
            'image_url' => $room->image_url,
            'has_personality_profile' => !is_null($profile),
            'personality_profile' => $profile ? [
                'traits' => $profile->traits,
                'summary' => $profile->summary,
            ] : null,
        ]);
    }

    /**
     * Return the checklist configuration for frontend and iOS.
     */
    public function checklistConfig()
    {
        return response()->json(config('checklist'));
    }
}
