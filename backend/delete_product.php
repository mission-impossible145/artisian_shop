<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin or seller
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    header("Location: login.php");
    exit();
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    // Prepare the SQL statement to delete the product
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        echo "Product deleted successfully.";
        // Optionally redirect to the product listing page
        header("Location: list_products.php"); // Replace with your actual product listing page
        exit();
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No product ID provided.";
}

$conn->close();
?>