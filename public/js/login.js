// DOM Elements
const loginForm = document.getElementById('loginForm');
const loginButton = document.getElementById('loginButton');
const successMessage = document.getElementById('successMessage');

// Spinner control function
function setLoadingState(isLoading) {
    if (isLoading) {
        loginButton.classList.add('loading');
        loginButton.disabled = true;
    } else {
        loginButton.classList.remove('loading');
        loginButton.disabled = false;
    }
}

// Success popup function
function showSuccessMessage() {
    successMessage.classList.add('show');
    setTimeout(() => {
        successMessage.classList.remove('show');
    }, 2000);
}

// Form submit → spinner ON
loginForm.addEventListener('submit', () => {
    setLoadingState(true);
});

// When redirected to dashboard → show popup
window.addEventListener("load", () => {
    if (window.location.pathname.includes("dashboard")) {
        showSuccessMessage();
    }
});
