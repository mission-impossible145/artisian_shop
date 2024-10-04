<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total_price = $_POST['total_price'];
    $user_id = $_SESSION['user_id'];

    // Insert order into the database
    $sql = "INSERT INTO orders (user_id, total_price, order_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $total_price);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the ID of the newly created order

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("iii", $order_id, $product_id, $quantity);
            $stmt_item->execute();
        }

        // Clear the cart
        unset($_SESSION['cart']);
        echo "Order placed successfully! Your order ID is: " . $order_id;
        // Optionally redirect to an order confirmation page
    } else {
        echo "Error placing order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

