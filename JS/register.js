// script.js

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("register-form");
  
    form.addEventListener("submit", function(event) {
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;
  
      if (password !== confirmPassword) {
        alert("Passwords do not match");
        event.preventDefault(); // Hindari pengiriman formulir jika password tidak cocok
      }
    });
  });
  