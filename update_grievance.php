<?php
// update_grievance.php

session_start();
require 'db_connect.php'; // Connect to the database
header('Content-Type: application/json');

// Security Check: User must be logged in for these actions
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to perform this action.']);
    exit;
}

// Check if the required POST variables are set
if (!isset($_POST['id']) || !isset($_POST['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request. ID or action is missing.']);
    exit;
}

$id = (int)$_POST['id'];
$action = $_POST['action'];

if ($action === 'upvote') {
    // Upvote a grievance
    $stmt = $conn->prepare("UPDATE grievances SET upvotes = upvotes + 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

} elseif ($action === 'resolve') {
    // Mark a grievance as resolved
    $stmt = $conn->prepare("UPDATE grievances SET status = 'resolved', resolved_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
    exit;
}

// Execute the prepared statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Action completed successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
}

$stmt->close();
$conn->close();
?>