<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - LCAD DentalCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container">

    <!-- LEFT SIDE: Form -->
    <div class="form-section">
        <h2>LCAD DentalCare</h2>
        <div class="form-box">

            <div class="form forgot-form" style="display: flex; flex-direction: column;">
                <h3>Reset Password</h3>
                <p class="text-sm text-gray-600">
                    Forgot your password? No problem. Just enter your email and we will send you a password reset link.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email" required>
                    @error('email')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <button type="submit">Send Reset Link</button>
                </form>

                <p class="mt-2 text-sm text-gray-600">
                    Back to <a href="{{ route('login') }}" class="text-blue-700">Login</a>
                </p>
            </div>

        </div>
    </div>

    <!-- RIGHT SIDE: Image -->
    <div class="image-section">
        <img src="{{ asset('images/dentist.jpg') }}" alt="Dental Clinic">
    </div>
</div>
</body>
</html>
