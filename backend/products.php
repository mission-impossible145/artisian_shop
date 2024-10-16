<?php
session_start();
include 'db_connection.php';

// Fetch all products

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM products WHERE product_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $search_query . '%';
    $stmt->bind_param("s", $search_term);
} else {
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../assets/css/products.css"> <!-- Link to external CSS file -->
</head>
<body>

    <section class="product-hero">
        <div class="hero-content">
            <h2>Browse Our Collection</h2>
            <p>Handcrafted items made by talented artisans.</p>
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for products" value="<?= htmlspecialchars($search_query) ?>">
                <input type="submit" value="Search" class="search-button">
            </form>
        </div>
    </section>

    <!-- Products Section -->
    <section class="product-listing">
        <h3>Our Products</h3>
        <div class="products-container">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="product-image">
                    <p><?= htmlspecialchars($product['product_name']) ?></p>
                    <p>$<?= number_format($product['price'], 2) ?></p>
                    <a href="product_detail.php?id=<?= $product['product_id'] ?>" class="btn add-to-cart-btn">View Product</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

  

</body>
</html>