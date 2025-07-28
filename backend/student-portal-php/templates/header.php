<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="nav-logo">StudentPortal</h1>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>