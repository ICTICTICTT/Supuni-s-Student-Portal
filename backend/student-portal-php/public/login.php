<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (login($email, $password)) {
        $_SESSION['user'] = $email;
        setcookie('user', $email, time() + (86400 * 30), "/"); // 30 days
        header("Location: profile.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StudentPortal</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main class="form-page">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Login</h2>
                    <p>Welcome back! Please login to your account.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST" novalidate>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Login</button>
                </form>

                <div class="form-footer">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>