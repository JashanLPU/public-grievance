<?php
// login.php - Corrected Version

// These lines force PHP to show errors.
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db_connect.php';
header('Content-Type: application/json');

// Check if email and password are set
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

// Prepare a statement to select the user by email
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // User found, now verify the password
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Password is correct, create the session
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
    } else {
        // Incorrect password
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }
} else {
    // No user found with that email
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
}

$stmt->close();
$conn->close();
?>