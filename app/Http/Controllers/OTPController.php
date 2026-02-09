<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Twilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OTPController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        
        $user->generateOTP();

        (new Twilio())->send($user);

        return view('theme.verify-otp', ['email' => $user->email]);

    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250',
            'otp' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if($user && $user->otp == $request->otp){
            if(now() < $user->otp_till){
                $user->resetOTP();
                Auth::guard()->login($user);
                return to_route('blogs.my-blogs');
            } else {
                throw ValidationException::withMessages([
                    'email' => 'Expired OTP',
                ]); 
            }
        }else {
            throw ValidationException::withMessages([
                'email' => 'otp is wrong',
            ]);    
        }

    }
}
