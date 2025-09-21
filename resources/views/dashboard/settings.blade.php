@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<section class="content">
  <h3 data-i18n="profile_settings">Profile Settings</h3>

  <!-- Profile Info -->
  <div class="form-group">
    <label for="name" data-i18n="name">Name</label>
    <input type="text" id="name" placeholder="Enter your name">
  </div>

  <div class="form-group">
    <label for="email" data-i18n="email">Email</label>
    <input type="email" id="email" placeholder="Enter your email">
  </div>

  <div class="form-group">
    <label for="phone" data-i18n="phone">Phone</label>
    <input type="tel" id="phone" placeholder="Enter your phone">
  </div>

  <!-- Security -->
  <h3 data-i18n="security">Security</h3>
  <div class="form-group">
    <label for="password" data-i18n="password">Password</label>
    <div class="password-wrapper">
      <input type="password" id="password" placeholder="Enter new password">
      <button type="button" class="show-pass" id="togglePassword" data-i18n="show">Show</button>
    </div>
  </div>

  <!-- Preferences -->
  <h3 data-i18n="preferences">Preferences</h3>
  <div class="checkbox-group">
    <input type="checkbox" id="emailNotif">
    <label for="emailNotif" data-i18n="enable_email">Enable Email Notification</label>
  </div>
  <div class="checkbox-group">
    <input type="checkbox" id="darkMode">
    <label for="darkMode" data-i18n="dark_mode">Dark Mode</label>
  </div>

  <!-- Language -->
  <h3 data-i18n="language">Language</h3>
  <div class="form-group">
    <select id="language">
      <option value="en">English</option>
      <option value="fil">Filipino</option>
    </select>
  </div>

  <!-- Actions -->
  <div class="actions">
    <button class="btn save" id="saveBtn" data-i18n="save">Save Changes</button>
    <button class="btn cancel" id="cancelBtn" data-i18n="cancel">Cancel</button>
  </div>
</section>
@endsection

