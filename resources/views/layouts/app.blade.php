<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>LCAD Dental Care — Admin</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  @vite([
    'resources/css/dashboard.css',
    'resources/js/dashboard.js',
    'resources/css/appointments.css',
    'resources/js/appointments.js',
    'resources/css/notifications.css',
    'resources/js/notifications.js',
    'resources/css/patients.css',
    'resources/js/patients.js',
    'resources/css/settings.css',
    'resources/js/settings.js'
  ])
  <style>
    :root{
      --bg:#f1f4f6;
      --sidebar:#e9ecef;
      --nav:#1A2B4C;
      --card:#ffffff;
      --muted:#8b95a6;
      --accent:#1A2B4C;
      --shadow:0 1px 0 rgba(15,23,42,0.06), inset 0 -1px 0 rgba(0,0,0,0.02);
      --radius:10px;
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;background:var(--bg);font-family:"Poppins",sans-serif;}
    a{color:inherit;text-decoration:none;cursor:pointer;}
    .app {display:grid;grid-template-columns:240px 1fr;gap:24px;padding:24px;min-height:100vh;}
    .sidebar {background:linear-gradient(#f2f4f6,#f0f3f5);border-radius:var(--radius);padding:18px 12px;border:1px solid rgba(0,0,0,0.06);box-shadow:var(--shadow);display:flex;flex-direction:column;gap:12px;}
    .brand {height:56px;display:flex;align-items:center;gap:12px;padding:6px 8px;border-radius:6px;}
    .brand h2{font-size:16px;margin:0;color:var(--accent);font-weight:600;}
    .nav {margin-top:6px;display:flex;flex-direction:column;gap:6px;padding-top:10px;}
    .nav a{display:flex;align-items:center;gap:12px;padding:12px;border-radius:6px;color:var(--accent);font-weight:600;transition:all .15s;}
    .nav a.active{background:var(--nav);color:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.08);}
    .panel {display:flex;flex-direction:column;gap:16px;}
    .header {display:flex;justify-content:space-between;align-items:center;background:var(--nav);padding:14px 18px;border-radius:var(--radius);color:#fff;box-shadow:var(--shadow);}
    .header .title {font-size:18px;font-weight:600}
    .header .user {display:flex;align-items:center;gap:18px;font-weight:500}
    .header .logout {cursor:pointer;color:#fff;background:#59677f;padding:6px 14px;border-radius:6px;font-size:14px;border:none;}
  </style>
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <svg width="34" height="34" viewBox="0 0 24 24"><rect rx="6" width="24" height="24" fill="#1A2B4C"/></svg>
        <h2>LCAD Dental Care</h2>
      </div>
      <nav class="nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments') ? 'active' : '' }}">Appointments</a>
        <a href="{{ route('admin.patients') }}" class="{{ request()->routeIs('admin.patients') ? 'active' : '' }}">Patients</a>
        <a href="{{ route('admin.notifications') }}" class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}">Notifications</a>
        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">Settings</a>
      </nav>
    </aside>

    <!-- MAIN PANEL -->
    <main class="panel">
      <header class="header">
        <div class="title">@yield('title', 'Admin Dashboard')</div>
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
</body>
</html>
