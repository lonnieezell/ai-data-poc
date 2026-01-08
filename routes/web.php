<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('/chat');
});

Route::get('/chat', [ChatController::class, 'show']);
Route::post('/chat/stream', [ChatController::class, 'stream']);
