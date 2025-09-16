<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Create an Account</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
  <section class="card" aria-labelledby="form-title">
    <header class="header">
      <svg class="logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M32 4 c-10 0 -18 8 -18 18 0 8 3 12 3 20 0 10 -3 16 -3 20 0 4 3 6 5 6 4 0 6-3 7-6 2-5 2-7 3-10 1-3 3-3 4-3 1 0 3 0 4 3 1 3 1 5 3 10 1 3 3 6 7 6 2 0 5-2 5-6 0-4 -3-10 -3-20 0-8 3-12 3-20 0-10 -8-18 -18-18z"
              fill="none" stroke="#4d79ff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <h1 class="title" id="form-title">Create an Account</h1>
    </header>

    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif


    <form action="{{ route('register') }}" method="POST" novalidate>
      @csrf

      <!-- First & Last Name -->
      <div class="row">
        <div>
          <input class="field" name="first_name" type="text" placeholder="First name" value="{{ old('first_name') }}" required autofocus>
          <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>
        <div>
          <input class="field" name="last_name" type="text" placeholder="Last name" value="{{ old('last_name') }}" required>
          <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
      </div>

      <!-- Birthday -->
      <div>
        <div class="label">Birthday</div>
        <div class="inline-3">
          <select id="b_month" name="b_month" class="field"></select>
          <select id="b_day" name="b_day" class="field"></select>
          <select id="b_year" name="b_year" class="field"></select>
        </div>
      </div>

      <!-- Gender -->
      <div>
        <div class="label">Gender</div>
        <div class="radio-group">
          <label class="radio"><input type="radio" name="gender" value="female"> Female</label>
          <label class="radio"><input type="radio" name="gender" value="male"> Male</label>
          <label class="radio"><input type="radio" name="gender" value="custom"> Custom</label>
        </div>
      </div>

      <!-- Contact Number -->
      <div>
        <input class="field" name="contact_number" type="text" placeholder="Contact Number" value="{{ old('contact_number') }}">
        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
      </div>

      <!-- Address -->
      <div>
        <input class="field" name="address" type="text" placeholder="Address" value="{{ old('address') }}">
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
      </div>

      <!-- Email / Contact -->
      <div>
        <input class="field" name="email" type="email" placeholder="Email or mobile number" value="{{ old('email') }}" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div>
        <input class="field" name="password" type="password" placeholder="Password" required autocomplete="new-password">
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirm Password -->
      <div>
        <input class="field" name="password_confirmation" type="password" placeholder="Confirm Password" required>
      </div>

      <button class="btn" type="submit">Register</button>

      <p class="meta">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </form>
  </section>

  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
