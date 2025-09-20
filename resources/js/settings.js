document.addEventListener("DOMContentLoaded", () => {
  const settingsPage = document.querySelector(".settings-page");
  if (!settingsPage) return; // Exit if not on settings page

  // Elements
  const darkModeCheckbox = settingsPage.querySelector("#darkMode");
  const saveBtn = settingsPage.querySelector("#saveBtn");
  const cancelBtn = settingsPage.querySelector("#cancelBtn");
  const togglePassword = settingsPage.querySelector("#togglePassword");
  const passwordInput = settingsPage.querySelector("#password");
  const languageSelect = settingsPage.querySelector("#language");

  // Dark mode toggle
  function applyDarkMode(state) {
    document.body.classList.toggle("dark", !!state);
    if (darkModeCheckbox) darkModeCheckbox.checked = !!state;
  }
  if (darkModeCheckbox) {
    darkModeCheckbox.addEventListener("change", () => {
      applyDarkMode(darkModeCheckbox.checked);
      localStorage.setItem("darkMode", darkModeCheckbox.checked ? "true" : "false");
    });
  }

  // Show/Hide password
  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", () => {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      togglePassword.textContent = type === "password" ? "Show" : "Hide";
    });
  }

  // Language translations
  const translations = {
    en: {
      profile_settings: "Profile Settings",
      name: "Name",
      email: "Email",
      phone: "Phone",
      security: "Security",
      password: "Password",
      show: "Show",
      hide: "Hide",
      preferences: "Preferences",
      enable_email: "Enable Email Notification",
      dark_mode: "Dark Mode",
      language: "Language",
      save: "Save Changes",
      cancel: "Cancel"
    },
    fil: {
      profile_settings: "Mga Setting ng Profile",
      name: "Pangalan",
      email: "Email",
      phone: "Telepono",
      security: "Seguridad",
      password: "Password",
      show: "Ipakita",
      hide: "Itago",
      preferences: "Mga Kagustuhan",
      enable_email: "Paganahin ang Abiso sa Email",
      dark_mode: "Madilim na Mode",
      language: "Wika",
      save: "I-save ang Pagbabago",
      cancel: "Kanselahin"
    }
  };

  function setLanguage(lang) {
    settingsPage.querySelectorAll("[data-i18n]").forEach(el => {
      const key = el.getAttribute("data-i18n");
      if (translations[lang] && translations[lang][key]) {
        el.textContent = translations[lang][key];
      }
    });
    localStorage.setItem("language", lang);
  }

  if (languageSelect) {
    languageSelect.addEventListener("change", function() {
      setLanguage(this.value);
    });
  }

  // Save / Cancel
  function loadSettings() {
    if (settingsPage.querySelector("#name")) 
      settingsPage.querySelector("#name").value = localStorage.getItem("name") || "";
    if (settingsPage.querySelector("#email")) 
      settingsPage.querySelector("#email").value = localStorage.getItem("email") || "";
    if (settingsPage.querySelector("#phone")) 
      settingsPage.querySelector("#phone").value = localStorage.getItem("phone") || "";
    if (passwordInput) 
      passwordInput.value = localStorage.getItem("password") || "";
    if (settingsPage.querySelector("#emailNotif")) 
      settingsPage.querySelector("#emailNotif").checked = localStorage.getItem("emailNotif") === "true";

    const savedLang = localStorage.getItem("language") || "en";
    if (languageSelect) languageSelect.value = savedLang;
    setLanguage(savedLang);

    const savedDark = localStorage.getItem("darkMode") === "true";
    applyDarkMode(savedDark);
  }

  if (saveBtn) {
    saveBtn.addEventListener("click", () => {
      if (settingsPage.querySelector("#name")) 
        localStorage.setItem("name", settingsPage.querySelector("#name").value);
      if (settingsPage.querySelector("#email")) 
        localStorage.setItem("email", settingsPage.querySelector("#email").value);
      if (settingsPage.querySelector("#phone")) 
        localStorage.setItem("phone", settingsPage.querySelector("#phone").value);
      if (passwordInput) 
        localStorage.setItem("password", passwordInput.value);
      if (settingsPage.querySelector("#emailNotif")) 
        localStorage.setItem("emailNotif", settingsPage.querySelector("#emailNotif").checked ? "true" : "false");
      if (languageSelect) 
        localStorage.setItem("language", languageSelect.value);
      if (darkModeCheckbox) 
        localStorage.setItem("darkMode", darkModeCheckbox.checked ? "true" : "false");
      alert("✅ Settings saved");
    });
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", () => {
      loadSettings();
      alert("✖ Changes reverted");
    });
  }

  // Init on page load
  loadSettings();
});
