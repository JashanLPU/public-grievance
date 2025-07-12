<?php
// db_connect.php - Central Database Connection

// --- TEMPORARY DEBUGGING LINE ---
// We will remove this later.
echo "db_connect.php file was successfully loaded!";


$servername = "localhost";
$username = "root";       // Default XAMPP username
$password = "";           // Default XAMPP password
$dbname = "civicpulse_db"; // The name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  // Use die() to stop the script and show an error if connection fails
  die("Connection failed: " . $conn->connect_error);
}
?>