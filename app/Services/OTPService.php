<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OTPService
{
    public static function generateOTP(User $user)
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->settings()->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15)
        ]);

        return $otp;
    }

    public static function sendOTPEmail(User $user, $otp)
    {
        try {
            Mail::raw("Your password change verification code is: $otp\n\nThis code expires in 15 minutes.", function ($message) use ($user) {
                $message->to($user->email)
                       ->subject('Password Change Verification - Dental Clinic');
            });
            return true;
        } catch (\Exception $e) {
            \Log::error('OTP Email failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function verifyOTP(User $user, $otp)
    {
        $settings = $user->settings;
        
        if (!$settings->otp_code || !$settings->otp_expires_at) {
            return false;
        }

        if ($settings->otp_code === $otp && now()->lt($settings->otp_expires_at)) {
            $settings->update([
                'otp_code' => null,
                'otp_expires_at' => null
            ]);
            return true;
        }

        return false;
    }
}