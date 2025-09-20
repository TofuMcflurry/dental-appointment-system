@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<section class="content max-w-md mx-auto">
  <h3>Preferences</h3>
  <div class="checkbox-group">
    <input type="checkbox" id="darkMode">
    <label for="darkMode">Dark Mode</label>
  </div>

  <h3>Language</h3>
  <div class="form-group">
    <select id="language">
      <option value="en">English</option>
      <option value="fil">Filipino</option>
    </select>
  </div>

  <div class="actions">
    <button class="btn save" id="saveBtn">Save Changes</button>
    <button class="btn cancel" id="cancelBtn">Cancel</button>
  </div>
</section>
@endsection

@push('styles')
<style>
  :root {
    --bg: #f1f4f6;
    --card: #ffffff;
    --accent: #1A2B4C;
    --radius: 10px;
    --input-border: rgba(0,0,0,0.15);
  }
  body.dark {
    --bg: #181a1b;
    --card: #242729;
    --accent: #f5f6f7;
    --input-border: rgba(255,255,255,0.12);
    background: var(--bg);
    color: var(--accent);
  }
  .content {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid rgba(0,0,0,0.06);
    padding: 20px;
  }
  .content h3 { margin-bottom: 14px; font-size: 16px; font-weight: 600; }
  .checkbox-group { display:flex; align-items:center; gap:8px; margin-bottom:16px; }
  .form-group { margin-bottom: 16px; }
  .form-group select {
    padding:10px;
    border:1px solid var(--input-border);
    border-radius:6px;
    font-size:14px;
    background: var(--card);
    color: var(--accent);
    width: 100%;
  }
  .actions { margin-top:20px; display:flex; gap:12px; }
  .btn { padding:10px 18px; border:none; border-radius:6px; cursor:pointer; font-size:14px; font-weight:500; }
  .btn.save { background: var(--accent); color:#fff; }
  .btn.cancel { background:#ddd; color:#111; }
  body.dark .btn.cancel { background:#444; color:#fff; }
</style>
@endpush

@push('scripts')
<script>
  // Elements
  const darkModeCheckbox = document.getElementById("darkMode");
  const saveBtn = document.getElementById("saveBtn");
  const cancelBtn = document.getElementById("cancelBtn");

  // Dark mode toggle
  function applyDarkMode(state) {
    document.body.classList.toggle("dark", !!state);
    if(darkModeCheckbox) darkModeCheckbox.checked = !!state;
  }
  darkModeCheckbox.addEventListener("change", () => {
    applyDarkMode(darkModeCheckbox.checked);
    localStorage.setItem("darkMode", darkModeCheckbox.checked ? "true" : "false");
  });

  // Language
  function setLanguage(lang) {
    localStorage.setItem("language", lang);
  }
  document.getElementById("language").addEventListener("change", function() {
    setLanguage(this.value);
  });

  // Save / Cancel
  function loadSettings() {
    const savedLang = localStorage.getItem("language") || "en";
    document.getElementById("language").value = savedLang;
    const savedDark = localStorage.getItem("darkMode") === "true";
    applyDarkMode(savedDark);
  }

  saveBtn.addEventListener("click", () => {
    localStorage.setItem("language", document.getElementById("language").value);
    localStorage.setItem("darkMode", darkModeCheckbox.checked ? "true" : "false");
    alert("✅ Settings saved");
  });

  cancelBtn.addEventListener("click", () => {
    loadSettings();
    alert("✖ Changes reverted");
  });

  // Init on page load
  loadSettings();
</script>
@endpush
