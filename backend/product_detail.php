<?php
session_start();
include 'db_connection.php';

// Fetch product ID from URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    echo "Product not found!";
    exit;
}

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Check if product exists
if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['product_name']) ?></title>
    <link rel="stylesheet" href="../assets/css/product_detail.css"> <!-- Link to external CSS file -->
</head>
<body>

    <div class="product-detail-container">
        <!-- Product Image -->
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
        </div>

        <!-- Product Information -->
        <div class="product-info">
            <h1><?= htmlspecialchars($product['product_name']) ?></h1>
            <p class="price">$<?= number_format($product['price'], 2) ?></p>
            <p class="description"><?= htmlspecialchars($product['description']) ?></p>

            <!-- Add to Cart Form -->

            <form method="POST" action="add_to_cart.php">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
            </form>
        </div>
    </div>

   
</body>
</html>
