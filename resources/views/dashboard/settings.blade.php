@extends('layouts.app')

@section('title', 'Settings')

@section('page-style')
  @vite(['resources/css/patient/settings.css'])
@endsection

@section('content')
<div id="settingsPage" class="settings-page">
    <h3>Profile Settings</h3>

    <form id="settingsForm" action="{{ route('patient.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        @php
            $user = auth()->user();
            $settings = $user->settings;
        @endphp

        <!-- Profile Information -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" 
                   value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" 
                   value="{{ $user->email }}" 
                   readonly
                   style="background: #f5f5f5; color: #666; cursor: not-allowed;">
            <small style="color: #666; font-size: 12px; display: block; margin-top: 4px;">
                Email cannot be changed. Contact administration for updates.
            </small>
        </div>

        <div class="form-group">
            <label for="phone">Contact Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your contact number">
        </div>

        <!-- Security -->
        <h3 style="margin: 24px 0 16px 0; color: var(--accent);">Security</h3>
        
        <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 16px; border-left: 4px solid #3b82f6;">
            <strong>🔒 Password Change Security</strong>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: #666;">
                You'll receive a verification code via email when changing your password.
            </p>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter new password (leave blank to keep current)">
                <button type="button" class="show-pass" id="togglePassword">Show</button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                   placeholder="Confirm new password">
        </div>

        <!-- Preferences -->
        <h3 style="margin: 24px 0 16px 0; color: var(--accent);">Preferences</h3>
        
        <div class="form-group" style="flex-direction: row; align-items: center; gap: 8px;">
            <input type="checkbox" id="dark_mode" name="dark_mode" value="1"
                   {{ $settings->dark_mode ? 'checked' : '' }}
                   style="width: auto;">
            <label for="dark_mode" style="margin-bottom: 0;">Dark Mode</label>
        </div>

        <div class="form-group">
            <label for="language">Language</label>
            <select id="language" name="language">
                <option value="en" {{ $settings->language == 'en' ? 'selected' : '' }}>English</option>
                <option value="fil" {{ $settings->language == 'fil' ? 'selected' : '' }}>Filipino</option>
            </select>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn save" id="saveBtn">Save Changes</button>
            <button type="button" class="btn cancel" id="cancelBtnSettings">Cancel</button>
        </div>
    </form>
</div>
@endsection

@section('page-script')
  @vite(['resources/js/patient/settings.js'])
@endsection