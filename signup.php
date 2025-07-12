<?php
session_start();

$host = "localhost";
$dbname = "project";
$dbuser = "root";
$dbpass = "";

// Connect to database
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

// Get form data
$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name']);
$username = trim($data['username']);
$email = trim($data['email']);
$password = $data['password'];

// Validate input
if (!$name || !$username || !$email || !$password) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["status" => "error", "message" => "Username or email already taken."]);
    exit;
}

// Insert new user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Signup failed."]);
}
?>
