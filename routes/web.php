<?php
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
    Route::post('/change-reciver-email', function(Request $request){
        User::where('id', Auth::user()->id)->update(['reciver_email'=> $request->email]);
        return response()->json([
            'response' => true,
            'message'  => 'Reciver email changed successfully'
        ]);
    });
});
Route::get('/foo', function () {
Artisan::call('storage:link');
});
require __DIR__.'/auth.php';
