<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomVerificationTokenController extends Controller
{
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? to_route('blogs.my-blogs')
            : view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $user = User::where('verification_token', $request->token)->firstOrFail();

        if(now() < $user->verification_token_till){
            $user->verifyUsingVerificationToken();
            return to_route('blogs.my-blogs');
        }
        abort(401); 
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return to_route('blogs.my-blogs');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
