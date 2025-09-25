<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'        => ['required', 'string', 'min:3', 'confirmed'],
            'b_year'          => ['required', 'numeric'],
            'b_month'         => ['required', 'numeric'],
            'b_day'           => ['required', 'numeric'],
            'gender'          => ['required', 'string'],
            'address'         => ['required', 'string', 'max:255'],
            'contact_number'  => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id'        => $user->user_id,
            'full_name'      => $request->first_name . ' ' . $request->last_name,
            'birthdate'      => $request->birthdate,
            'gender'         => $request->gender,
            'contact_number' => $request->contact_number,
            'email'          => $request->email,
            'address'        => $request->address,
            'treatment_plan' => $request->treatment_plan,
        ]);

        event(new Registered($user));

        return redirect()->route('login');
    }
}
