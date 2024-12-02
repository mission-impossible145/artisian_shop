<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin or seller
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    header("Location: login.php");
    exit();
}

// Fetch categories from the database
$sql = "SELECT category_id, category_name FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form action="add_product_process.php" method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required step="0.01">

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="category">Category:</label>
        <select id="category" name="category_id" required>
            <option value="">Select a Category</option>
            <?php while ($category = $result->fetch_assoc()): ?>
                <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="image_url">Image:</label>
        <input type="file" id="image_url" name="image_url" required>

        <label for="stock">Stock Quantity:</label>
        <input type="number" name="stock_quantity" min="0" required><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>