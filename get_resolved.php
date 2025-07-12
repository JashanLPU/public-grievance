<?php
// get_resolved.php
// This script fetches the 5 most recently resolved grievances.

// THIS LINE IS THE FIX: The filename is now correct.
require 'db_connect.php'; 

header('Content-Type: application/json');

// SQL query to get the title and location of the 5 most recently resolved items.
$sql = "SELECT title, location FROM grievances WHERE status = 'resolved' ORDER BY resolved_at DESC LIMIT 5";
$result = $conn->query($sql);

$resolved_items = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $resolved_items[] = $row;
    }
}

echo json_encode($resolved_items);

$conn->close();
?>