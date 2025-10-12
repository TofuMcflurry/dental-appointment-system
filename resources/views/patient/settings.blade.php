@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div id="settingsPage" class="settings-page">
  <h3 id="settingsTitle">Profile Settings</h3>

  <div class="form-group">
    <label for="name" id="lblName">Name</label>
    <input type="text" id="name" placeholder="Enter your name">
  </div>

  <div class="form-group">
    <label for="email" id="lblEmail">Email</label>
    <input type="email" id="email" placeholder="Enter your email">
  </div>

  <div class="form-group">
    <label for="phone" id="lblPhone">Phone</label>
    <input type="tel" id="phone" placeholder="Enter your phone">
  </div>

  <h3 id="securityTitle">Security</h3>
  <div class="form-group">
    <label for="password" id="lblPassword">Password</label>
    <div class="password-wrapper">
      <input type="password" id="password" placeholder="Enter new password">
      <button type="button" class="show-pass" id="togglePassword">Show</button>
    </div>
  </div>

  <h3 id="prefTitle">Preferences</h3>
  <div class="checkbox-group">
    <input type="checkbox" id="emailNotif">
    <label for="emailNotif" id="lblEmailNotif">Enable Email Notification</label>
  </div>
  <div class="checkbox-group">
    <input type="checkbox" id="darkMode">
    <label for="darkMode" id="lblDarkMode">Dark Mode</label>
  </div>

  <h3 id="langTitle">Language</h3>
  <div class="form-group">
    <select id="language">
      <option value="en">English</option>
      <option value="fil">Filipino</option>
    </select>
  </div>

  <div class="actions">
    <button class="btn save" id="saveBtn">Save Changes</button>
    <button class="btn cancel" id="cancelBtnSettings">Cancel</button>
  </div>
</div>
@endsection

@push('scripts')
  @vite('resources/js/patient/core.js')
@endpush
