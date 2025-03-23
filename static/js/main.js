/* JavaScript File (static/js/main.js) */

// Toggle Mobile Menu
document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menu-toggle");
    const navMenu = document.querySelector("nav");
    
    if (menuToggle) {
        menuToggle.addEventListener("click", function() {
            navMenu.classList.toggle("active");
        });
    }
});

// Form Validation Example
const contactForm = document.querySelector("#contact-form");
if (contactForm) {
    contactForm.addEventListener("submit", function(event) {
        const emailField = document.querySelector("#email");
        if (!emailField.value.includes("@")) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });
}