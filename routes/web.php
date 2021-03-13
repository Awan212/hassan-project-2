<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoMessageController;
use App\Http\Controllers\TextMessageController;
use App\Models\TextMessage;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\VideoMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'messages' => TextMessage::count(),
            'videoMessage' => VideoMessage::count(),
        ]);
    })->name('dashboard');

    // text message routes
    Route::get('text-message', [TextMessageController::class, 'index']);
    Route::post('text-message', [TextMessageController::class, 'store']);
    Route::get('update-text-message/{id}', [TextMessageController::class, 'edit']);
    Route::post('update-text-message/{id}', [TextMessageController::class, 'update']);
    Route::get('remove-text-message/{id}', [TextMessageController::class, 'destroy']);

    // video message routes
    Route::get('video-message', [VideoMessageController::class, 'index'])->name('video-message');
    Route::post('/save-video-message', [VideoMessageController::class, 'store']);
    Route::get('/show-video-message', [VideoMessageController::class, 'show']);
    Route::get('/remove-video-message/{id}', [VideoMessageController::class, 'destroy']);
    // some changes
    Route::get('/reciver-email', function(){
        return response()->json(Auth::user()->reciver_email);
    });
    Route::get('/reciver-tel', function(){
        return response()->json(Auth::user()->tel_no);
    });


    Route::post('/change-reciver-email', function(Request $request){
        User::where('id', Auth::user()->id)->update(['reciver_email'=> $request->email]);
        return response()->json([
            'response' => true,
            'message'  => 'Reciver email changed successfully'
        ]);
    });

    Route::post('/change-reciver-tel', function(Request $request){
        User::where('id', Auth::user()->id)->update(['tel_no'=> $request->tel]);
        return response()->json([
            'response' => true,
            'message'  => 'Reciver Tel No changed successfully'
        ]);
    });

    Route::post('/change-password', [HomeController::class, 'change_password']);
});
require __DIR__.'/auth.php';
