<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $seller_id = $_SESSION['user_id'];

    // Update the product details
    $sql = "UPDATE products SET product_name = ?, price = ?, description = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $product_name, $price, $description, $product_id);

    // Check if a new image has been uploaded
    if (!empty($_FILES['image_url']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . uniqid() . '_' . basename($_FILES["image_url"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file and move it to the target directory
        if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
            // Update image URL in the database
            $sql = "UPDATE products SET image_url = ? WHERE product_id = ?";
            $stmt_image = $conn->prepare($sql);
            $stmt_image->bind_param("si", $target_file, $product_id);
            $stmt_image->execute();
            $stmt_image->close();
        }
    }

    if ($stmt->execute()) {
        header("Location: list_products.php?status=updated");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
