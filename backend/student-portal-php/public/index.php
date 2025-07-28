<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/auth.php';
require_once '../src/user.php';
require_once '../src/contact.php';

$loggedIn = isset($_SESSION['user_id']);

include '../templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <main>
        <h1>Welcome to Student Portal</h1>
        <p>Your one-stop solution for managing your academic journey.</p>
        
        <nav>
            <ul>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <?php if ($loggedIn): ?>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>