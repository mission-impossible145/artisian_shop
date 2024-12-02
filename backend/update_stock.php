<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $new_stock = $_POST['new_stock'];

    // Update stock quantity in the database
    $sql = "UPDATE products SET stock_quantity = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_stock, $product_id);

    if ($stmt->execute()) {
        echo "Stock updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
