document.addEventListener("DOMContentLoaded", () => {
    const verifyForm = document.querySelector('form[action*="verification.send"]');
    if (!verifyForm) return;

    const verifyButton = verifyForm.querySelector("button[type='submit']");
    if (!verifyButton) return;

    const buttonText = verifyButton.querySelector(".button-text");
    const spinner = verifyButton.querySelector(".loading-spinner");

    verifyForm.addEventListener("submit", () => {
        // disable button so user can't double-click
        verifyButton.disabled = true;

        // hide the text, show spinner (text replaced by spinner)
        if (buttonText) buttonText.classList.add("hidden");
        if (spinner) spinner.classList.remove("hidden");
    });
});