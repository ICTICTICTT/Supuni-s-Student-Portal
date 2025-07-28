<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'studentportal';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $dateOfBirth = $_POST['dateOfBirth'] ?? '';
    $course = $_POST['course'] ?? '';
    
    // Server-side validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }
    
    if (empty($dateOfBirth)) {
        $errors[] = 'Date of birth is required';
    }
    
    if (empty($course)) {
        $errors[] = 'Course is required';
    }
    
    if (empty($errors)) {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $response['message'] = 'An account with this email already exists';
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $pdo->prepare("
                    INSERT INTO users (name, email, password, phone, date_of_birth, course, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())
                ");
                
                if ($stmt->execute([$name, $email, $hashedPassword, $phone, $dateOfBirth, $course])) {
                    $response['success'] = true;
                    $response['message'] = 'Registration successful! You can now log in.';
                } else {
                    $response['message'] = 'Registration failed. Please try again.';
                }
            }
        } catch(PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = implode(', ', $errors);
    }
}

// Return JSON response for AJAX requests
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Redirect back to registration page with message
$_SESSION['message'] = $response['message'];
$_SESSION['message_type'] = $response['success'] ? 'success' : 'error';
header('Location: register.html');
exit;
?>