<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\TextMail;
use App\Mail\VideoMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class TextMailController extends Controller
{
    public function text_mail()
    {
        Mail::to(User::first()->reciver_email)->send(new TextMail);
        return response()->json([
            'message' => true,
        ]);
    }

    public function video_mail()
    {
        Mail::to(User::first()->reciver_email)->send(new VideoMail);
        return response()->json([
            'message' => true,
        ]);
    }

    public function send_mail(){
        Mail::to(User::first()->reciver_email)->send(new VideoMail);
        Mail::to(User::first()->reciver_email)->send(new TextMail);
        return response()->json([
            'message' => true,
        ]);
    }
}
