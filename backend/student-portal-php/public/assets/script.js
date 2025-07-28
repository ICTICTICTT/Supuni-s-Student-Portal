// This file contains JavaScript for client-side functionality, such as form validation and user feedback.

document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Perform form validation here
            const isValid = validateForm();
            if (isValid) {
                registerForm.submit();
            } else {
                showModal('Error', 'Please correct the highlighted errors.');
            }
        });
    }

    function validateForm() {
        let valid = true;
        // Example validation logic
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');

        if (name.value.trim() === '') {
            valid = false;
            showError(name, 'Full Name is required.');
        } else {
            clearError(name);
        }

        if (email.value.trim() === '') {
            valid = false;
            showError(email, 'Email Address is required.');
        } else {
            clearError(email);
        }

        if (password.value.trim() === '') {
            valid = false;
            showError(password, 'Password is required.');
        } else {
            clearError(password);
        }

        if (confirmPassword.value !== password.value) {
            valid = false;
            showError(confirmPassword, 'Passwords do not match.');
        } else {
            clearError(confirmPassword);
        }

        return valid;
    }

    function showError(input, message) {
        const errorElement = document.getElementById(input.id + 'Error');
        errorElement.textContent = message;
        input.classList.add('error');
    }

    function clearError(input) {
        const errorElement = document.getElementById(input.id + 'Error');
        errorElement.textContent = '';
        input.classList.remove('error');
    }

    function showModal(title, message) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modal.style.display = 'block';
    }

    window.closeModal = function() {
        modal.style.display = 'none';
    };
});