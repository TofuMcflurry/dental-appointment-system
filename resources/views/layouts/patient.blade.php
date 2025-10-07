<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — LCAD Dental Care</title>

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Shared CSS & JS -->
    @vite([
        'resources/css/patient/patient.css',
        'resources/js/patient/core.js',
        'resources/js/patient/dashboard.js',
        'resources/js/patient/appointments.js',
        'resources/js/patient/notification.js',
        'resources/js/patient/settings.js',
    ])
</head>
<body>
  <h2 id="page-title" style="display:none"></h2>
  
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand">
        <svg width="34" height="34" viewBox="0 0 24 24"><rect rx="6" width="24" height="24" fill="#1A2B4C"/></svg>
        <h2>LCAD Dental</h2>
      </div>
      <nav class="nav">
        <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="{{ route('patient.appointments') }}" class="{{ request()->routeIs('patient.appointments') ? 'active' : '' }}">
          <i class="fa-solid fa-calendar-check"></i> Appointments
        </a>
        <a href="{{ route('patient.notifications') }}" class="{{ request()->routeIs('patient.notifications') ? 'active' : '' }}">
          <i class="fa-solid fa-bell"></i> Notifications
        </a>
        <a href="{{ route('patient.settings') }}" class="{{ request()->routeIs('patient.settings') ? 'active' : '' }}">
          <i class="fa-solid fa-gear"></i> Settings
        </a>
      </nav>
    </aside>

    <!-- Main Panel -->
    <main class="panel">
      <header class="header">
        <h1 class="title">@yield('title')</h1>
        <div class="user">
          <div>{{ Auth::user()->name }}</div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
          </form>
        </div>
      </header>

      <section class="content">
        @yield('content')
      </section>
    </main>
  </div>

  <!-- ✅ Global JS so every page works -->
  <script>
      // Provide patient data globally (safe default)
      window.patientData = @json($patientData ?? []);
  </script>
  <script type="module">
      import { App } from '/resources/js/patient/core.js';
      window.addEventListener('DOMContentLoaded', () => new App());
  </script>

  @stack('scripts')
</body>
</html>
