<?php
// Include the database connection file
include 'db_connection.php';

// Simple query to test connection
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check if the query returns rows
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["user_id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>