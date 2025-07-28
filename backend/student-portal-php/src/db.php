<?php
// Database connection settings
$host = 'localhost';
$dbname = 'student_portal';
$username = 'root';
$password = '';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to execute a query
function executeQuery($query, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

// Function to fetch all results
function fetchAll($query, $params = []) {
    return executeQuery($query, $params)->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch a single result
function fetchOne($query, $params = []) {
    return executeQuery($query, $params)->fetch(PDO::FETCH_ASSOC);
}

// Function to insert data
function insert($query, $params = []) {
    executeQuery($query, $params);
    return $pdo->lastInsertId();
}

// Function to update data
function update($query, $params = []) {
    executeQuery($query, $params);
}

// Function to delete data
function delete($query, $params = []) {
    executeQuery($query, $params);
}
?>