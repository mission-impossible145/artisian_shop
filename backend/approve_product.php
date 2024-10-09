<?php
session_start();
include 'db_connection.php'; // Ensure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Update the product to set approved = 1
    $sql = "UPDATE products SET approved = 1 WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: manage_products.php?status=approved");
        exit();
    } else {
        die("SQL Error: " . $stmt->error);
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
