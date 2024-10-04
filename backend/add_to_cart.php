<?php
session_start();

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // Add the product to the cart
    $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + 1 : 1;
    
   // header("Location: browse_products.php"); // Redirect back to products page
   header("Location: view_cart.php");
    exit();
} else {
    echo "Invalid product ID.";
}
?>