// Theme Management
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update theme toggle button
    const themeToggle = document.querySelector('.theme-toggle');
    themeToggle.textContent = newTheme === 'dark' ? '☀️' : '🌙';
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.textContent = savedTheme === 'dark' ? '☀️' : '🌙';
    }
});

// Mobile Navigation
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
});

// Form Validation Functions
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}

function getPasswordStrength(password) {
    if (password.length === 0) return null;
    if (password.length < 8) return 'weak';
    if (password.length >= 8 && password.length < 12) return 'medium';
    return 'strong';
}

function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + 'Error');
    if (errorElement) {
        errorElement.textContent = message;
    }
}

function clearError(fieldId) {
    const errorElement = document.getElementById(fieldId + 'Error');
    if (errorElement) {
        errorElement.textContent = '';
    }
}

function clearAllErrors() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(element => {
        element.textContent = '';
    });
}

// Password Toggle Functionality
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const toggleButton = passwordField.nextElementSibling;
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleButton.textContent = '👁️‍🗨️';
    } else {
        passwordField.type = 'password';
        toggleButton.textContent = '👁️‍🗨️';
    }
}

// Password Strength Indicator
function updatePasswordStrength(password) {
    const strengthElement = document.getElementById('passwordStrength');
    if (!strengthElement) return;
    
    const strength = getPasswordStrength(password);
    
    if (!strength) {
        strengthElement.innerHTML = '';
        return;
    }
    
    const strengthClass = `strength-${strength}`;
    const strengthText = strength.charAt(0).toUpperCase() + strength.slice(1);
    
    strengthElement.innerHTML = `
        <div class="strength-bar ${strengthClass}"></div>
        <span class="strength-text">${strengthText}</span>
    `;
}

// Password Match Indicator
function updatePasswordMatch(password, confirmPassword) {
    const matchElement = document.getElementById('passwordMatch');
    if (!matchElement) return;
    
    if (confirmPassword === '') {
        matchElement.innerHTML = '';
        return;
    }
    
    if (password === confirmPassword) {
        matchElement.innerHTML = '<span class="match-success">✓ Passwords match</span>';
    } else {
        matchElement.innerHTML = '<span class="match-error">✗ Passwords don\'t match</span>';
    }
}

// Registration Form Validation
if (document.getElementById('registerForm')) {
    const form = document.getElementById('registerForm');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPassword');
    
    // Real-time password strength checking
    passwordField.addEventListener('input', function() {
        updatePasswordStrength(this.value);
        if (confirmPasswordField.value) {
            updatePasswordMatch(this.value, confirmPasswordField.value);
        }
    });
    
    // Real-time password match checking
    confirmPasswordField.addEventListener('input', function() {
        updatePasswordMatch(passwordField.value, this.value);
    });
    
    // Clear errors on input
    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', function() {
            clearError(this.id);
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        clearAllErrors();
        let isValid = true;
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Validate all fields
        if (!data.name.trim()) {
            showError('name', 'Name is required');
            isValid = false;
        }
        
        if (!data.email.trim()) {
            showError('email', 'Email is required');
            isValid = false;
        } else if (!validateEmail(data.email)) {
            showError('email', 'Please enter a valid email format');
            isValid = false;
        }
        
        if (!data.password) {
            showError('password', 'Password is required');
            isValid = false;
        } else if (!validatePassword(data.password)) {
            showError('password', 'Password must be at least 8 characters long');
            isValid = false;
        }
        
        if (!data.confirmPassword) {
            showError('confirmPassword', 'Please confirm your password');
            isValid = false;
        } else if (data.password !== data.confirmPassword) {
            showError('confirmPassword', 'Passwords do not match');
            isValid = false;
        }
        
        if (!data.phone.trim()) {
            showError('phone', 'Phone number is required');
            isValid = false;
        }
        
        if (!data.dateOfBirth) {
            showError('dateOfBirth', 'Date of birth is required');
            isValid = false;
        }
        
        if (!data.course) {
            showError('course', 'Course is required');
            isValid = false;
        }
        
        if (isValid) {
            // Check if user already exists
            const existingUsers = JSON.parse(localStorage.getItem('users') || '[]');
            const userExists = existingUsers.find(user => user.email === data.email);
            
            if (userExists) {
                showModal('Registration Failed', 'An account with this email already exists. Please use a different email or try logging in.');
                return;
            }
            
            // Create new user
            const newUser = {
                id: Date.now().toString(),
                name: data.name,
                email: data.email,
                phone: data.phone,
                dateOfBirth: data.dateOfBirth,
                course: data.course,
                registeredAt: new Date().toISOString()
            };
            
            // Save user data
            existingUsers.push(newUser);
            localStorage.setItem('users', JSON.stringify(existingUsers));
            
            // Save password separately (in real app, this would be hashed)
            const passwords = JSON.parse(localStorage.getItem('passwords') || '{}');
            passwords[data.email] = data.password;
            localStorage.setItem('passwords', JSON.stringify(passwords));
            
            showModal('Registration Successful!', 'Your account has been created successfully. You can now log in with your credentials.');
            
            // Reset form
            form.reset();
            document.getElementById('passwordStrength').innerHTML = '';
            document.getElementById('passwordMatch').innerHTML = '';
        }
    });
}

// Login Form Validation
if (document.getElementById('loginForm')) {
    const form = document.getElementById('loginForm');
    
    // Clear errors on input
    form.querySelectorAll('input').forEach(field => {
        field.addEventListener('input', function() {
            clearError(this.id);
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        clearAllErrors();
        let isValid = true;
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        if (!data.email.trim()) {
            showError('email', 'Email is required');
            isValid = false;
        }
        
        if (!data.password) {
            showError('password', 'Password is required');
            isValid = false;
        }
        
        if (isValid) {
            // Check credentials
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            const passwords = JSON.parse(localStorage.getItem('passwords') || '{}');
            
            const user = users.find(u => u.email === data.email);
            
            if (!user) {
                showModal('Login Failed', 'No account found with this email address. Please check your email or register for a new account.');
                return;
            }
            
            if (passwords[data.email] !== data.password) {
                showModal('Login Failed', 'Incorrect password. Please try again.');
                return;
            }
            
            // Save current user session
            localStorage.setItem('currentUser', JSON.stringify(user));
            
            showModal('Login Successful!', 'Welcome back! You will be redirected to your profile.', function() {
                window.location.href = 'profile.html';
            });
        }
    });
}

// Contact Form Validation and Rating
if (document.getElementById('contactForm')) {
    const form = document.getElementById('contactForm');
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    
    // Rating functionality
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = rating;
            
            // Update star display
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Update rating text
            const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = ratingTexts[rating];
            
            clearError('rating');
        });
        
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.opacity = '1';
                } else {
                    s.style.opacity = '0.3';
                }
            });
        });
    });
    
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value);
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.style.opacity = '1';
            } else {
                s.style.opacity = '0.3';
            }
        });
    });
    
    // Clear errors on input
    form.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', function() {
            clearError(this.id);
        });
    });
    
    // Pre-fill form if user is logged in
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || 'null');
    if (currentUser) {
        document.getElementById('name').value = currentUser.name;
        document.getElementById('email').value = currentUser.email;
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        clearAllErrors();
        let isValid = true;
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        if (!data.name.trim()) {
            showError('name', 'Name is required');
            isValid = false;
        }
        
        if (!data.email.trim()) {
            showError('email', 'Email is required');
            isValid = false;
        } else if (!validateEmail(data.email)) {
            showError('email', 'Please enter a valid email format');
            isValid = false;
        }
        
        if (!data.subject) {
            showError('subject', 'Subject is required');
            isValid = false;
        }
        
        if (!data.message.trim()) {
            showError('message', 'Message is required');
            isValid = false;
        }
        
        if (!data.rating || data.rating === '0') {
            showError('rating', 'Please provide a rating');
            isValid = false;
        }
        
        if (isValid) {
            // Save contact submission
            const contactSubmissions = JSON.parse(localStorage.getItem('contactSubmissions') || '[]');
            const newSubmission = {
                id: Date.now().toString(),
                ...data,
                submittedAt: new Date().toISOString(),
                userId: currentUser ? currentUser.id : null
            };
            
            contactSubmissions.push(newSubmission);
            localStorage.setItem('contactSubmissions', JSON.stringify(contactSubmissions));
            
            showModal('Message Sent Successfully!', 'Thank you for contacting us. We have received your message and will get back to you within 24 hours.');
            
            // Reset form
            form.reset();
            ratingInput.value = '0';
            stars.forEach(s => s.classList.remove('active'));
            ratingText.textContent = 'Please rate';
        }
    });
}

// Profile Page Functions
function loadUserProfile() {
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || 'null');
    
    if (!currentUser) {
        window.location.href = 'login.html';
        return;
    }
    
    // Update profile information
    document.getElementById('profileInitial').textContent = currentUser.name.charAt(0).toUpperCase();
    document.getElementById('profileName').textContent = currentUser.name;
    document.getElementById('profileEmail').textContent = currentUser.email;
    document.getElementById('profilePhone').textContent = currentUser.phone || 'Not provided';
    
    if (currentUser.dateOfBirth) {
        const date = new Date(currentUser.dateOfBirth);
        document.getElementById('profileDOB').textContent = date.toLocaleDateString();
    }
    
    document.getElementById('profileCourse').textContent = currentUser.course || 'Not specified';
}

function logout() {
    localStorage.removeItem('currentUser');
    window.location.href = 'index.html';
}

// Modal Functions
function showModal(title, message, callback) {
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    modal.style.display = 'block';
    
    // Store callback for later use
    modal.callback = callback;
}

function closeModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';
    
    // Execute callback if exists
    if (modal.callback) {
        modal.callback();
        modal.callback = null;
    }
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        closeModal();
    }
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Form animation on focus
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Check if input has value on page load
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
});