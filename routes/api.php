<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/rooms', [RoomController::class, 'store']);
    Route::get('/rooms/{sessionId}', [RoomController::class, 'show']);
    Route::get('/rooms/{sessionId}/status', [RoomController::class, 'status']);
    Route::get('/checklist-config', [RoomController::class, 'checklistConfig']);
});
