<?php
// register.php - Corrected Version

// These lines force PHP to show errors.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Use the central database connection
require 'db_connect.php'; 
header('Content-Type: application/json');

// Get data from the signup form
$fullName = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Basic validation to ensure no fields are empty
if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Hash the password for security before storing it
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement to prevent SQL injection
// THIS IS THE FIX: Added the 'full_name' column to the query
$stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");

// THIS IS THE FIX: Bind four parameters instead of three ("ssss")
$stmt->bind_param("ssss", $fullName, $username, $email, $passwordHash);

// Execute the statement and check for errors
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Account created! Please log in.']);
} else {
    // Check if the error is a duplicate entry (error code 1062)
    if ($conn->errno == 1062) {
        echo json_encode(['status' => 'error', 'message' => 'Username or email already exists.']);
    } else {
        // For any other error
        echo json_encode(['status' => 'error', 'message' => 'An error occurred during registration.']);
    }
}

$stmt->close();
$conn->close();
?>