<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);

    if ($order_id > 0) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            echo "Order deleted successfully!";
        } else {
            echo "Error deleting order: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid order ID.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
