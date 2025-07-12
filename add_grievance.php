<?php
// add_grievance.php

session_start();
require 'db_connect.php'; // Connect to the database

header('Content-Type: application/json'); // Set header for JSON response

// Security Check: Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a grievance.']);
    exit;
}

// Get data from the form submission
$title = $_POST['title'];
$description = $_POST['description'];
$location = $_POST['location'];
$severity = (int)$_POST['severity']; // Cast to integer
$user_id = (int)$_SESSION['user_id']; // Get user ID from the session

// Prepare and bind the SQL statement to prevent SQL injection
$stmt = $conn->prepare(
    "INSERT INTO grievances (user_id, title, description, location, severity) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("isssi", $user_id, $title, $description, $location, $severity);

// Execute the statement and send a response
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Grievance submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>