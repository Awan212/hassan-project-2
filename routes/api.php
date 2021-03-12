<?php

use App\Http\Controllers\Api\v1\TextMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/send-text-mail', [TextMailController::class, 'text_mail']);
Route::get('/send-video-mail', [TextMailController::class, 'video_mail']);
Route::get('/send_mail', [TextMailController::class, 'send_mail']);
