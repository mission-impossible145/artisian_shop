<?php
// db_connection.php

$servername = "localhost"; // Use localhost for local development
$username = "root"; // Default MySQL username
$password = ""; // Usually no password for XAMPP/WAMP, otherwise put your password here
$dbname = "artisian_shop"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//else {
   // echo "Database connected successfully!";
//}
?>