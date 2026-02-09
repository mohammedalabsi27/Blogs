<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;

class Twilio 
{
    public function send($user)
    {
        try {
            // Your Account SID and Auth Token from console.twilio.com
            $sid = env('APP_SID');
            $token = env('APP_TOKEN');
            $client = new Client($sid, $token);
    
            // Use the Client to make requests to the Twilio REST API
            $client->messages->create(
                // The number you'd like to send the message to
                $user->phone,
                [
                    // A Twilio phone number you purchased at https://console.twilio.com
                    'from' => env('APP_FROM_NUMBER'),
                    // The body of the text message you'd like to send
                    'body' => "Hey $user->name! Your OTP code is $user->otp!"
                ]
            );
        }
        catch (TwilioException $e) {
            Log::alert($e->getMessage());
        }
      
    }
}