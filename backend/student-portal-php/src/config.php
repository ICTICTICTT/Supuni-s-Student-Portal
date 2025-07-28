<?php
// Configuration settings for the application

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'student_portal');

// Application settings
define('APP_NAME', 'Student Portal');
define('APP_URL', 'http://localhost/student-portal-php/public');

// Session settings
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
?>