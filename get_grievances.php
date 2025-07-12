<?php
// get_grievances.php

require 'db_connect.php'; // Connect to the database
header('Content-Type: application/json');

// SQL query to get all pending grievances, sorted by severity and upvotes
$sql = "SELECT * FROM grievances WHERE status = 'pending' ORDER BY severity DESC, upvotes DESC";
$result = $conn->query($sql);

$grievances = [];
if ($result->num_rows > 0) {
    // Fetch all rows into an associative array
    while($row = $result->fetch_assoc()) {
        $grievances[] = $row;
    }
}

// Encode the array into JSON and echo it
echo json_encode($grievances);

$conn->close();
?>