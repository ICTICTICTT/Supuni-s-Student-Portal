<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/auth.php';
require_once '../src/user.php';

// Check if the user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Get user information
$userId = $_SESSION['user_id'];
$user = getUserById($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentPortal - Profile</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main class="profile-page">
        <div class="container">
            <h2>Your Profile</h2>
            <div class="profile-info">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
                <p><strong>Course:</strong> <?php echo htmlspecialchars($user['course']); ?></p>
            </div>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>