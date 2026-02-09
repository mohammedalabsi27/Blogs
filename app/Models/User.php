<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomEmailVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public function sendEmailVerificationNotification()
    {
        if(config('verification.way') == 'email'){
            $url = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $this->getKey(),
                    'hash' => sha1($this->getEmailForVerification())
                ]
            );
            $this->notify(new CustomEmailVerification($url));
        }
        if(config('verification.way') == 'cvt'){
            $this->generateVerificationToken();
            $url = route('verification.verify', [
                'id' => $this->getKey(),
                'token' => $this->verification_token,
            ]);
            $this->notify(new CustomEmailVerification($url));
        }
        if(config('verification.way') == 'passwordless'){
            $url = URL::temporarySignedRoute(
                'login.verify',
                now()->addMinutes(60),
                [
                    'user' => $this->getKey(),
                ]
            );
            $this->notify(new CustomEmailVerification($url));
        }
    }

    public function generateVerificationToken()
    {
        if(config('verification.way') == 'cvt') {
            $this->verification_token = Str::random(40);
            $this->verification_token_till = now()->addMinutes(5);
            $this->save();
        }
    }

    public function verifyUsingVerificationToken()
    {
        if(config('verification.way') == 'cvt') {
            $this->email_verified_at = now();
            $this->verification_token = null;
            $this->verification_token_till = null;
            $this->save();
            
        }
    }

    public function generateOTP()
    {
        if(config('verification.way') == 'otp') {
            $this->otp = rand(000000, 999999);
            $this->otp_till = now()->addMinutes(10);
            $this->save();
        }
    }
    public function resetOTP()
    {
        if(config('verification.way') == 'otp') {
            $this->otp = null;
            $this->otp_till = null;
            $this->save();
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        'verification_token_till',
        'otp',
        'otp_till',
        'provider_id',
    ];

    public function blogs(){
        return $this->hasMany(Blog::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
