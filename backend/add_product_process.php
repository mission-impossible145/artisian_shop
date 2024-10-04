<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $seller_id = $_SESSION['user_id'];

    // Handle image upload
    $target_dir = "../uploads/";  // Ensure this folder exists
    $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
    
    // Check if the file is uploaded successfully
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
        // Insert into the database
        $sql = "INSERT INTO products (seller_id, product_name, price, description, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdss", $seller_id, $product_name, $price, $description, $target_file);
        
        if ($stmt->execute()) {
            header("Location: list_products.php?status=success");
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