<?php
session_start();
include 'db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product details
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $seller_id = $_SESSION['user_id'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload
    $target_dir = "../uploads/"; // Directory for uploaded images
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
    }

    $image_name = basename($_FILES["image_url"]["name"]);
    $target_file = $target_dir . $image_name; // Full server path
    $web_path = "uploads/" . $image_name; // Path to store in the database

    // Check for upload errors
    if ($_FILES["image_url"]["error"] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code: " . $_FILES["image_url"]["error"]);
    }

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
        // Insert into the database
        $sql = "INSERT INTO products (seller_id, product_name, price, description, image_url, category_id, approved, stock_quantity) 
                VALUES (?, ?, ?, ?, ?, ?, 0, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL error: " . $conn->error);
        }

        $stmt->bind_param("isdsiii", $seller_id, $product_name, $price, $description, $web_path, $category_id, $stock_quantity);

        if ($stmt->execute()) {
            header("Location: list_products.php?status=submitted");
            exit();
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: File could not be uploaded.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
