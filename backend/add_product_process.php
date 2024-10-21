<?php
session_start();
include 'db_connection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product details
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Get the selected category
    $seller_id = $_SESSION['user_id'];

    // Handle image upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
    
    // Check if the upload was successful
    if ($_FILES["image_url"]["error"] !== UPLOAD_ERR_OK) {
        echo "Error uploading file: " . $_FILES['image_url']['error'];
        exit();
    }

    // Check file type
    $allowed_types = ['image/jpeg', 'image/png'];
    if (!in_array($_FILES['image_url']['type'], $allowed_types)) {
        echo "Error: Invalid file type.";
        exit();
    }

    // Move uploaded file
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
        // Insert into the database with approved status as 0
        $sql = "INSERT INTO products (seller_id, product_name, price, description, category, image_url, approved) 
                VALUES (?, ?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        
        // Ensure parameters are correct types
        $stmt->bind_param("isdsss", $seller_id, $product_name, $price, $description, $category, $target_file);

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
?>
