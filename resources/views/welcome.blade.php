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
  <div class="container">
    <header>
      <span class="logo">Dental Clinic</span>
      <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn login">Log in</a>
        <a href="{{ route('register') }}" class="btn register">Register</a>
      </div>
    </header>

    <section class="hero" style="background-image: url('{{ asset('images/v598_52.png') }}');">
      <div class="overlay"></div>
      <div class="v598_64"></div>
      <div class="content">
        <h1>Your Journey to a<br> Brighter Smile <br> Starts Here</h1>
        <p>Modern Care, Gentle Touch, Lasting Health.</p>
      </div>
    </section>
  </div>
</body>
</html>
