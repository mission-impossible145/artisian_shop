<?php
session_start();

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]); // Remove product from cart
    }
    header("Location: view_cart.php"); // Redirect back to the cart
    exit();
} else {
    echo "Invalid product ID.";
}
?>