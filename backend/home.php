<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Fetch limited products for home page
$sql = "SELECT * FROM products LIMIT 4"; // Change the limit as needed
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Shop</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
     
    <div class="content">

    <!-- Top Header -->
    <header class="top-header">
        <div class="user-actions">
            <a href="#">Track Order</a> |
            <a href="login.php">Login</a> |
            <a href="register.php">Sign Up</a>
        </div>
    </header>

    <!-- Main Header -->
    <header class="main-header">
        <div class="logo">
            <h1>Artisan Shop</h1>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="products.php">Products</a></li> <!-- Link to products page -->
                <li><a href="about us.html">About Us</a></li>
                <li><a href="contact us.html">Contact Us</a></li>
                <li><a href="login.php">Sell</a></li>    
             
            </ul>
        </nav>
        <div class="cart-search">
            <input type="text" placeholder="Search">
            <a href="view_cart.php" class="cart">Cart</a>
        </div>
    </header>



    <!-- Products -->
    <section class="products">
        <h2>Products</h2>
        <div class="product-grid">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                    <p>$<?= number_format($product['price'], 2) ?></p>
                    <a href="product_detail.php?id=<?= $product['product_id'] ?>" class="btn">Buy Now</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

  
            </div>
    <!-- Footer -->
    <footer class="footer">
        <p>© 2024 Artisan Handicraft Center. All rights reserved.</p>
    </footer>

</body>
</html>
