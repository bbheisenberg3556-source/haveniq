<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Checklist', [
        'config' => config('checklist')
    ]);
});

Route::get('/rooms/{sessionId}', function ($sessionId) {
    return Inertia::render('Results', [
        'sessionId' => $sessionId
    ]);
});

Route::get('/storage/{path}', function (string $path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');
