<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientSettingsController extends Controller
{
    public function edit()
    {
        return view('patient.settings');
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $patient = $user->patient;
            $settings = $user->settings;

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'password' => 'nullable|min:8|confirmed',
                'dark_mode' => 'sometimes|boolean',
                'language' => 'sometimes|in:en,fil'
            ]);

            // SIMPLE OTP CHECK - Only if password is being changed
            if (!empty($validated['password']) && !session('otp_verified')) {
                // Store the pending password in session
                session(['pending_password_change' => $validated['password']]);
                session(['pending_settings' => $request->all()]);
                
                // Check if OTPService exists and works
                if (class_exists('App\Services\OTPService')) {
                    $otp = \App\Services\OTPService::generateOTP($user);
                    $emailSent = \App\Services\OTPService::sendOTPEmail($user, $otp);
                    
                    if ($emailSent) {
                        return response()->json([
                            'otp_required' => true,
                            'message' => '📧 Verification code sent to your email! Check your inbox.'
                        ]); // ✅ REMOVED: , 422
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => '❌ Failed to send verification email. Please try again.'
                        ], 422);
                    }
                }
            }

            // Update other settings (name, phone, dark_mode, language)
            $user->name = $validated['name'];
            
            if ($patient) {
                $patient->contact_number = $validated['phone'] ?? $patient->contact_number;
                $patient->save();
            }

            $settings->dark_mode = $request->has('dark_mode');
            $settings->language = $validated['language'] ?? 'en';
            $settings->save();

            // If OTP was already verified, save the password
            if (!empty($validated['password']) && session('otp_verified')) {
                $user->password = Hash::make($validated['password']);
                session()->forget('otp_verified');
                session()->forget('pending_password_change');
                session()->forget('pending_settings');
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Settings update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating settings'
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6'
        ]);

        $user = Auth::user();

        if (\App\Services\OTPService::verifyOTP($user, $request->otp_code)) {
            // OTP verified - mark session as verified
            session(['otp_verified' => true]);
            
            // Get the pending password from session and update it
            $pendingPassword = session('pending_password_change');
            if ($pendingPassword) {
                $user->password = Hash::make($pendingPassword);
                $user->save();
                
                // Clear session data
                session()->forget('pending_password_change');
                session()->forget('pending_settings');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully!',
                    'redirect' => route('patient.settings')
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Identity verified successfully!',
                'redirect' => route('patient.settings')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code.'
        ], 422);
    }

    public function resendOTP(Request $request)
    {
        $user = Auth::user();
        
        $otp = \App\Services\OTPService::generateOTP($user);
        $emailSent = \App\Services\OTPService::sendOTPEmail($user, $otp);
        
        if ($emailSent) {
            return response()->json([
                'success' => true,
                'message' => 'New verification code sent!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send verification code.'
        ], 500);
    }
}