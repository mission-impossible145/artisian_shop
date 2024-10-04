<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h1>Order Confirmed</h1>";
echo "<p>Your order has been placed successfully.</p>";
echo "<a href='order_history.php'>View your orders</a>";
?>