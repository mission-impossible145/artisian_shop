<?php
session_start();

// Debugging: Check what is in the POST array
var_dump($_POST); // This will output the contents of the POST request

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Add the product to the cart
    $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + 1 : 1;
    
    // Redirect back to the product detail page or to the cart
    header("Location: view_cart.php"); // You can also redirect to the product detail page if desired
    exit();
} else {
    echo "Invalid product ID.";
}
?>
