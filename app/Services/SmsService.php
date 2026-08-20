<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function sendOtp(string $phone, string $otp): bool
    {
        $apiUrl    = env('HUTCH_SMS_URL',      'https://smsgateway.hutch.lk/api/send');
        $username  = env('HUTCH_SMS_USER',     '');
        $password  = env('HUTCH_SMS_PASS',     '');
        $senderId  = env('HUTCH_SMS_SENDER',   'CeylonAroma');

        if (!$username || !$password) {
            // Dev mode — log instead of sending
            Log::info("OTP for {$phone}: {$otp}");
            return true;
        }

        try {
            $response = Http::timeout(10)->post($apiUrl, [
                'username'    => $username,
                'password'    => $password,
                'sender'      => $senderId,
                'destination' => $phone,
                'message'     => "Your Ceylon Aroma verification code is: {$otp}. Valid for 10 minutes.",
            ]);
            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Hutch SMS failed: ' . $e->getMessage());
            return false;
        }
    }
}
