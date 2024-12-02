<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product details
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id']; // Retrieve selected category
    $seller_id = $_SESSION['user_id'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image_url"]["name"]);

    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
        // Insert into the database with approved status as 0
        $sql = "INSERT INTO products (seller_id, product_name, price, description, image_url, category_id, approved, stock_quantity) 
                VALUES (?, ?, ?, ?, ?, ?, 0, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdsiii", $seller_id, $product_name, $price, $description, $target_file, $category_id, $stock_quantity);

        if ($stmt->execute()) {
            header("Location: list_products.php?status=submitted");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: File could not be uploaded.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}