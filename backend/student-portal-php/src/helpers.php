<?php
// helpers.php

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function redirectTo($url) {
    header("Location: $url");
    exit();
}

function setFlashMessage($message) {
    $_SESSION['flash_message'] = $message;
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function restrictAccess() {
    if (!isLoggedIn()) {
        redirectTo('login.php');
    }
}
?>