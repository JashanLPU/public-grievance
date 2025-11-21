<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; 
header('Content-Type: application/json');

$fullName = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");

// This is the new part. We check if the prepare failed.
if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'Database prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $fullName, $username, $email, $passwordHash);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Account created! Please log in.']);
} else {
    // This part is now more detailed
    echo json_encode([
        'status' => 'error', 
        'message' => 'Database execute failed: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>