document.addEventListener('DOMContentLoaded', () => {
    if (!localStorage.getItem('cookieAccepted')) {
        alert("Ce site utilise des cookies.");
        localStorage.setItem('cookieAccepted', true);
    }
});


console.log("Cookie script loaded.");