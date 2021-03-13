<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_pass' => 'required',
            'new_pass'     => 'required|min:11'
        ]);
        if($validator->fails())
        {
            $data = [
                'response' => false,
                'message'  => $validator->errors()->all(),
            ];
            return response()->json($data);
        }
        else
        {
            $user = User::find(Auth::user()->id);
            if(Hash::check($request->current_pass,$user->password))
            {
                $user->password = Hash::make($request->new_pass);
                $user->save();
                $data = [
                    'response' => true,
                    'message'  => ['Password changed successfully.'],
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'response' => false,
                    'message'  => ['Current Password not matched with your password'],
                ];
                return response()->json($data);
            }
        }
    }
}
