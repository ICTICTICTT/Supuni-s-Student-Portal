<?php
session_start();
require_once 'db.php';

function getUserProfile($userId) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserProfile($userId, $data) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE users SET name = :name, email = :email, phone = :phone, date_of_birth = :date_of_birth, course = :course WHERE id = :id");
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':date_of_birth', $data['dateOfBirth']);
    $stmt->bindParam(':course', $data['course']);
    $stmt->bindParam(':id', $userId);
    return $stmt->execute();
}

function saveProfilePicture($userId, $file) {
    $targetDir = "../public/uploads/";
    $targetFile = $targetDir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return false;
    }

    // Check file size
    if ($file["size"] > 500000) {
        return false;
    }

    // Allow certain file formats
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return false;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            // Update user profile with new picture path
            updateUserProfilePicturePath($userId, $targetFile);
            return true;
        } else {
            return false;
        }
    }
}

function updateUserProfilePicturePath($userId, $filePath) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
    $stmt->bindParam(':profile_picture', $filePath);
    $stmt->bindParam(':id', $userId);
    return $stmt->execute();
}
?>