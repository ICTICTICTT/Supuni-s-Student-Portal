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
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    
    // Get user ID if logged in
    $userId = $_SESSION['user_id'] ?? null;
    
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
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = 'Please provide a valid rating (1-5)';
    }
    
    if (empty($errors)) {
        try {
            // Insert contact submission
            $stmt = $pdo->prepare("
                INSERT INTO contact_submissions (user_id, name, email, subject, message, rating, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            if ($stmt->execute([$userId, $name, $email, $subject, $message, $rating])) {
                $response['success'] = true;
                $response['message'] = 'Thank you for contacting us! We have received your message and will get back to you within 24 hours.';
                
                // Send email notification (you would implement this with a mail library)
                // mail($email, "Contact Form Submission Received", $message);
                
            } else {
                $response['message'] = 'Failed to submit your message. Please try again.';
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

// Redirect back to contact page with message
$_SESSION['message'] = $response['message'];
$_SESSION['message_type'] = $response['success'] ? 'success' : 'error';
header('Location: contact.html');
exit;
?>