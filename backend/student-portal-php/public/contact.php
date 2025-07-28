<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/contact.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    $rating  = trim($_POST['rating'] ?? '');

    // Validate input
    if (empty($name) || empty($email) || empty($subject) || empty($message) || empty($rating)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!in_array($rating, ['1','2','3','4','5'])) {
        $error = "Please provide a valid rating.";
    } elseif (strlen($name) < 2) {
        $error = "Name must be at least 2 characters.";
    } elseif (strlen($subject) < 3) {
        $error = "Subject must be at least 3 characters.";
    } elseif (strlen($message) < 10) {
        $error = "Message must be at least 10 characters.";
    } else {
        // Save contact form submission to MySQL database, include user_id for traceability
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (user_id, name, email, subject, message, rating, timestamp) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$_SESSION['user_id'], $name, $email, $subject, $message, $rating]);
            $success = "Your message has been sent successfully!";
        } catch (PDOException $e) {
            $error = "Failed to save your message. Please try again later.";
        }
    }
}

// Include header
include '../templates/header.php';
?>

<main class="form-page">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Contact Us</h2>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="contact.php" method="POST" novalidate>
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" required>
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <select id="rating" name="rating" required>
                        <option value="">Select rating</option>
                        <option value="1">Poor</option>
                        <option value="2">Fair</option>
                        <option value="3">Good</option>
                        <option value="4">Very Good</option>
                        <option value="5">Excellent</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Send Message</button>
            </form>
        </div>
    </div>
</main>

<?php
// Include footer
include '../templates/footer.php';
?>