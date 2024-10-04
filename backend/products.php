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
    <link rel="stylesheet" href="../assets/css/products.css">
 <!-- Link to external CSS file -->
    
</head>
<body>
    <div class="container">
        <header>
            <h1>Browse Products</h1>
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for products" value="<?= htmlspecialchars($search_query) ?>">
                <input type="submit" value="Search" class="search-button">
            </form>
        </header>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td>$<?= number_format($product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><a href="add_to_cart.php?id=<?= $product['product_id'] ?>" class="add-to-cart-btn">Add to Cart</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <footer>
            <a href="cart.php" class="view-cart-btn">View Cart</a>
        </footer>
    </div>
</body>
</html>