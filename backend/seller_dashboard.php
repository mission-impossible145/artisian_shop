<?php
session_start();

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
   header("Location: login.php");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../assets/css/seller_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Artisan Shop</h2>
            <ul>
                <li><a href="list_products.php">🛒 List Your Products</a></li>
                <li><a href="manage_orders.php">📦 Manage Orders</a></li>
                <li><a href="monthly_sales.php">💰 Monthly Sales</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <h1>Welcome to Your Seller Dashboard</h1>
            <div class="dashboard-actions">
                <div class="dashboard-card product-card">
                    <h3>List Your Products</h3>
                    <p>Add, edit, and manage all your products in one place.</p>
                    <a href="list_products.php" class="btn">Go to Products</a>
                </div>

                <div class="dashboard-card orders-card">
                    <h3>Manage Your Orders</h3>
                    <p>View, process, and track all your orders easily.</p>
                    <a href="manage_orders.php" class="btn">Go to Orders</a>
                </div>

                <div class="dashboard-card sales-card">
                    <h3>Monthly Sales</h3>
                    <p>View your total sales for the current month.</p>
                    <a href="monthly_sales.php" class="btn">Go to Sales</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
