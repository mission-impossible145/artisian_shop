<?php
session_start();
include 'db_connection.php';

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // Prepare SQL delete statement
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        header("Location: manage_orders.php?status=deleted");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No order ID specified.";
}

$conn->close();
?>