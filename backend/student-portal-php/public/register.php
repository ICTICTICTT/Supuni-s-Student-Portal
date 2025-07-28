<?php
// filepath: student-portal-php/public/register.php

require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $phone = trim($_POST['phone']);
    $dateOfBirth = trim($_POST['dateOfBirth']);
    $course = trim($_POST['course']);

    $errors = [];

    // Validate inputs
    if (empty($name)) {
        $errors['name'] = 'Full Name is required.';
    }
    if (empty($email)) {
        $errors['email'] = 'Email Address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match.';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone Number is required.';
    }
    if (empty($dateOfBirth)) {
        $errors['dateOfBirth'] = 'Date of Birth is required.';
    }
    if (empty($course)) {
        $errors['course'] = 'Course selection is required.';
    }

    // If no errors, proceed to register the user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'dateOfBirth' => $dateOfBirth,
            'course' => $course,
        ];

        if (registerUser($userData)) {
            header('Location: login.php?success=Registration successful. Please log in.');
            exit;
        } else {
            $errors['general'] = 'Registration failed. Please try again.';
        }
    }
}

include '../templates/header.php';
?>

<main class="form-page">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Create Account</h2>
                <p>Join StudentPortal today</p>
            </div>

            <form id="registerForm" action="register.php" method="POST" novalidate>
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required>
                    <span class="error-message"><?php echo $errors['name'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message"><?php echo $errors['email'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error-message"><?php echo $errors['password'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password *</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                    <span class="error-message"><?php echo $errors['confirmPassword'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" required>
                    <span class="error-message"><?php echo $errors['phone'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth *</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" required>
                    <span class="error-message"><?php echo $errors['dateOfBirth'] ?? ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="course">Course *</label>
                    <select id="course" name="course" required>
                        <option value="">Select your course</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Business Administration">Business Administration</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Psychology">Psychology</option>
                        <option value="Biology">Biology</option>
                        <option value="Chemistry">Chemistry</option>
                        <option value="Physics">Physics</option>
                        <option value="Literature">Literature</option>
                        <option value="History">History</option>
                    </select>
                    <span class="error-message"><?php echo $errors['course'] ?? ''; ?></span>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Create Account</button>
            </form>

            <div class="form-footer">
                <p>Already have an account? <a href="login.php">Sign in here</a></p>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>