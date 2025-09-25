<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
       if ($request->user()->hasVerifiedEmail()) {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'patient') {
            return redirect()->intended(route('patient.dashboard'));
        }

        return redirect('/'); // fallback
    }

    return view('auth.verify-email');
    }
}
