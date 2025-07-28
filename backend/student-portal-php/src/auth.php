<?php
session_start();

function login($email, $password) {
    // Include database connection
    require_once 'db.php';
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $GLOBALS['db']->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['logged_in'] = true;

            // Set a cookie for remember me functionality (optional)
            if (isset($_POST['remember'])) {
                setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 30 days
            }
            return true;
        }
    }
    return false;
}

function logout() {
    // Clear session and cookies
    session_unset();
    session_destroy();
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, "/"); // Expire the cookie
    }
}

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getUserName() {
    return $_SESSION['user_name'] ?? null;
}
?>