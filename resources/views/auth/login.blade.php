<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - LCAD DentalCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <!-- LEFT SECTION: Form -->
    <div class="form-section">
        <h2>LCAD DentalCare</h2>

        <div class="form-box">
            <!-- LOGIN FORM -->
            <div class="form login-form">
                <h3>Welcome Back!</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Remember Me -->
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>

                    <!-- Submit -->
                    <button type="submit">Login</button>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <p class="mt-3 text-sm text-gray-600">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </p>
                    @endif

                    <!-- Register Link -->
                    <p class="mt-2 text-sm text-gray-600">
                        Don’t have an account? <a href="{{ route('register') }}" style="color: #0b3d91;">Sign Up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION: Image -->
    <div class="image-section">
        <img src="{{ asset('images/dentist.jpg') }}" alt="Dental Clinic">
    </div>
</div>

</body>
</html>
