<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin or seller
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    header("Location: buyer_dashboard.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Query to join products and categories table
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        INNER JOIN categories c ON p.category_id = c.category_id 
        WHERE p.seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Products</title>
    <link rel="stylesheet" href="../assets/css/list_products.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Your Products</h1>
        <a href="add_product.php" class="btn">Add New Product</a>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image" width="50">
                    </td>
                    <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn edit">Edit</a>
                        <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
