<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dental Clinic</title>
    <link href="https://fonts.googleapis.com/css?family=Inclusive+Sans&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inknut+Antiqua&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
    <div class="v598_51">
        <div class="v598_52" style="background-image: url('{{ asset('images/v598_52.png') }}');"></div>
        <div class="v598_54"></div>
        <div class="v598_64"></div>

        <span class="v598_55">Modern Care, Gentle Touch, Lasting Health.</span>
        <span class="v598_57">
            Your Journey to<br>
            Brighter Smile<br>
            Starts Here
        </span>

        <div class="v598_53"></div>

        @if (Route::has('login'))
            <a href="{{ route('login') }}">
                <span class="v598_58 cursor-pointer">Log in</span>
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    <span class="v598_59 cursor-pointer">Register</span>
                </a>
            @endif
        @endif
        <span class="v598_60">Dental Clinic</span>
    </div>
</body>
</html>
