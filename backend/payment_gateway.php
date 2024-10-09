<?php
session_start();
if (empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='products.php'>Go back to shopping</a>";
    exit();
}

echo "<h1>Simulated Payment Gateway</h1>";
echo "<p>Payment processed successfully!</p>";
echo "<a href='products.php?payment=success'>order completed continue shopping</a>";
?>