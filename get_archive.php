<?php
// get_archive.php
// This script fetches ALL grievances marked as 'resolved'.

require 'db_connect.php'; // Connect to the database
header('Content-Type: application/json'); // Set header for JSON response

// SQL query to get all resolved grievances, showing the most recently resolved first
$sql = "SELECT * FROM grievances WHERE status = 'resolved' ORDER BY resolved_at DESC";
$result = $conn->query($sql);

$archive_items = [];
if ($result && $result->num_rows > 0) {
    // Fetch all resulting rows into an array
    while($row = $result->fetch_assoc()) {
        $archive_items[] = $row;
    }
}

// Encode the array into JSON and echo it
// This will send an empty array [] if no resolved items are found, which is correct.
echo json_encode($archive_items);

$conn->close();
?>