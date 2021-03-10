<?php

use App\Http\Controllers\TextMessageController;
use App\Mail\TextMail;
use App\Models\TextMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'messages' => TextMessage::count(),
        ]);
    })->name('dashboard');

    // text message routes
    Route::get('text-message', [TextMessageController::class, 'index']);
    Route::post('text-message', [TextMessageController::class, 'store']);
    Route::get('update-text-message/{id}', [TextMessageController::class, 'edit']);
    Route::post('update-text-message/{id}', [TextMessageController::class, 'update']);
    Route::get('remove-text-message/{id}', [TextMessageController::class, 'destroy']);
});

require __DIR__.'/auth.php';
