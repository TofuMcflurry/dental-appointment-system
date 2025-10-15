<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title') — LCAD Dental Care</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="{{ asset('css/app-header.css') }}">

  <!-- Page-Specific Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @if(Auth::user()->role === 'admin')
    @vite([
      'resources/css/admin/dashboard.css',
      'resources/js/admin/dashboard.js',
      'resources/css/admin/appointments.css',
      'resources/js/admin/appointments.js',
      'resources/css/admin/audittrail.css',
      'resources/js/admin/audittrail.js',
      'resources/css/admin/patients.css',
      'resources/js/admin/patients.js',
      'resources/css/admin/settings.css',
      'resources/js/admin/settings.js'
    ])
  @else
    @vite([
      'resources/css/patient/patient.css',
      'resources/css/patient/dashboard.css',
      'resources/js/patient/dashboard.js',
      'resources/css/patient/appointments.css',
      'resources/js/patient/appointments.js',
      'resources/css/patient/notification.css',
      'resources/js/patient/notification.js',
      'resources/css/patient/settings.css',
      'resources/js/patient/settings.js'
    ])
  @endif
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <svg width="34" height="34" viewBox="0 0 24 24"><rect rx="6" width="24" height="24" fill="#1A2B4C"/></svg>
        <h2>LCAD Dental Care</h2>
      </div>

      <!-- 🌐 Dynamic Navigation -->
      <nav class="nav">
        @if(Auth::user()->role === 'admin')
          <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
          <a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
          <a href="{{ route('admin.patients') }}" class="{{ request()->routeIs('admin.patients') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Patients</a>
          <a href="{{ route('admin.audittrail') }}" class="{{ request()->routeIs('admin.audittrail') ? 'active' : '' }}"><i class="fa-solid fa-clipboard-list"></i> Audit Trail</a>
          <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Settings</a>
        @else
          <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
          <a href="{{ route('patient.appointments') }}" class="{{ request()->routeIs('patient.appointments') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
          <a href="{{ route('patient.notifications') }}" class="{{ request()->routeIs('patient.notifications') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Notifications</a>
          <a href="{{ route('patient.settings') }}" class="{{ request()->routeIs('patient.settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Settings</a>
        @endif
      </nav>
    </aside>

    <!-- MAIN PANEL -->
    <main class="panel">
      <header class="header">
        <div class="title">@yield('title')</div>
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

  <!-- ✅ Global Core Script (for both dashboards) -->
  @vite('resources/js/patient/core.js')
  @stack('scripts')
</body>
</html>
