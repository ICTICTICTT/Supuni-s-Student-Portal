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
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['rememberMe']);
    
    // Server-side validation
    $errors = [];
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    
    if (empty($errors)) {
        try {
            // Get user from database
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Update last login
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                // Set remember me cookie if requested
                if ($rememberMe) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
                    
                    // Store token in database (you would need a remember_tokens table)
                    // This is a simplified version
                }
                
                $response['success'] = true;
                $response['message'] = 'Login successful!';
                $response['redirect'] = 'profile.html';
            } else {
                $response['message'] = 'Invalid email or password';
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

// Redirect based on login result
if ($response['success']) {
    header('Location: profile.html');
} else {
    $_SESSION['message'] = $response['message'];
    $_SESSION['message_type'] = 'error';
    header('Location: login.html');
}
exit;
?>