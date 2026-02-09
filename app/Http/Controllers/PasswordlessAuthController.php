<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PasswordlessAuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Link sent to your email');
    }

    public function verify($user){
        Auth::guard()->loginUsingId($user);
        return to_route('blogs.my-blogs');
    }
}
