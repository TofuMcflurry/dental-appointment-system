<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        // Fulfill method exists here
        $request->fulfill();

        // Optional event
        event(new Verified($request->user()));

        // Auto login the user after verification
        Auth::login($request->user());

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('status', 'Email verified!');
    }
}
