<?php
session_start();
include 'db_connection.php'; // Ensure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID from the form
    $user_id = $_POST['user_id'];

    // Prepare the SQL statement to mark the user as deleted
    $sql = "UPDATE users SET deleted = 1 WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Redirect back to the user management page with a success message
        header("Location: manage_users.php?status=deleted");
        exit();
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
