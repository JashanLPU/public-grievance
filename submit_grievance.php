<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a grievance.']);
    exit;
}

// Get the logged-in username
$username = $_SESSION['username'];

// Database connection
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Retrieve and sanitize POST data
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$location = trim($_POST['location'] ?? '');
$severity = intval($_POST['severity'] ?? 1);

// Validate inputs
if (empty($title) || empty($description) || empty($location)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Prepare and execute insert
$stmt = $conn->prepare("INSERT INTO grievances (username, title, description, location, severity) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $username, $title, $description, $location, $severity);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Grievance submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit grievance.']);
}

$stmt->close();
$conn->close();
?>
