<?php
$servername = "localhost";
$username = "root";  // Default username for XAMPP MySQL
$password = "";      // Default password is empty
$dbname = "social_media";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
