<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function login(){
        return Socialite::driver('google')->redirect();
    }

    public function redirect(){
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        $user = User::updateOrCreate([
            'prvider_id' => $googleUser->getId(),
        ], [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
        ]);

        Auth::login($user);

        return to_route('blogs.my-blogs');
    }
}
