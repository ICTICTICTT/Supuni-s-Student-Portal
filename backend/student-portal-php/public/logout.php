<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Clear cookies
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/'); // Set cookie expiration in the past
}

// Redirect to the login page or homepage
header("Location: login.php");
exit();
?>