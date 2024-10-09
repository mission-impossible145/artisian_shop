<?php
session_start();
include 'db_connection.php'; // Ensure this file connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve total price, user ID, and payment details
    $total_price = $_POST['total_price'];
    $buyer_id = $_SESSION['user_id'];
  

    // Ensure that user_id and cart are set
    if (!isset($buyer_id) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("Invalid user or empty cart.");
    }

        // Execute the order insertion
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id; // Get the ID of the newly created order

            // Prepare the SQL statement to insert order items
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);

            if (!$stmt_item) {
                die("Prepare failed for order items: " . $conn->error); // Log the error
            }

            // Loop through the cart and insert each item
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt_item->bind_param("iii", $order_id, $product_id, $quantity);
                if (!$stmt_item->execute()) {
                    die("Error inserting order item: " . $stmt_item->error); // Log the error
                }
            }

            // Clear the cart
            unset($_SESSION['cart']);
            echo "Order placed successfully! Your order ID is: " . $order_id;

            // Optionally redirect to an order confirmation page
            // header("Location: order_confirmation.php?order_id=" . $order_id);
            // exit();
        } else {
            die("Error placing order: " . $stmt->error); // Log the error
        }

        // Close statements and database connection
        $stmt->close();
        $stmt_item->close(); // Close item statement
        $conn->close();
    } else {
        echo "Invalid payment method.";
    }
 else {
    echo "Invalid request.";
}


?>
