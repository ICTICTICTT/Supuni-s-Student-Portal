<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $message = sanitizeInput($_POST['message']);

    $errors = [];

    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
    }

    if (empty($message)) {
        $errors['message'] = 'Message cannot be empty.';
    }

    if (empty($errors)) {
        $contactData = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $filePath = '../data/contacts.json';
        $contacts = [];

        if (file_exists($filePath)) {
            $contacts = json_decode(file_get_contents($filePath), true);
        }

        $contacts[] = $contactData;
        file_put_contents($filePath, json_encode($contacts, JSON_PRETTY_PRINT));

        $_SESSION['success'] = 'Your message has been sent successfully!';
        header('Location: contact.php');
        exit();
    }
}

include '../templates/header.php';
?>

<main class="form-page">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Contact Us</h2>
            </div>

            <form action="contact.php" method="POST" novalidate>
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
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required></textarea>
                    <span class="error-message"><?php echo $errors['message'] ?? ''; ?></span>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Send Message</button>
            </form>

            <div class="form-footer">
                <p>We will get back to you shortly!</p>
            </div>
        </div>
    </div>
</main>

<?php include '../templates/footer.php'; ?>