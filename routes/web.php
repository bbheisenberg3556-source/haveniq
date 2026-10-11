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
