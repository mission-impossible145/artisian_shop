<?php
session_start();

// Check if the user is logged in and is a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/buyer_dashboard.css"> <!-- Link to external CSS file -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Icons -->
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome to Your Buyer Dashboard</h1>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>! Explore and manage your shopping experience.</p>
        </div>
        
        <div class="dashboard-actions">
            <a href="products.php" class="dashboard-link">
                <span class="material-icons">shopping_bag</span>
                <div>Browse Products</div>
            </a>
            <a href="order_history.php" class="dashboard-link">
                <span class="material-icons">history</span>
                <div>Order History</div>
            </a>
            <a href="logout.php" class="dashboard-link logout">
                <span class="material-icons">logout</span>
                <div>Logout</div>
            </a>
        </div>
    </div>
</body>
</html>