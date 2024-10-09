<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['order_status'];

    if ($order_id > 0 && !empty($new_status)) {
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("si", $new_status, $order_id);
        if ($stmt->execute()) {
            echo "Order status updated successfully!";
        } else {
            echo "Error updating order status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid order ID or status.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
