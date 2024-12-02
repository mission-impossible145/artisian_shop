<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin or seller
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    header("Location: login.php");
    exit();
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Check if product exists
    if (!$product) {
        echo "Product not found.";
        exit();
    }

    // Fetch categories for the dropdown
    $sql_categories = "SELECT category_id, category_name FROM categories";
    $stmt_categories = $conn->prepare($sql_categories);
    $stmt_categories->execute();
    $result_categories = $stmt_categories->get_result();
} else {
    echo "No product ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>

    <form action="edit_product_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required step="0.01">

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="category">Category:</label>
        <select id="category" name="category_id" required>
            <?php while ($category = $result_categories->fetch_assoc()) { ?>
                <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $product['category_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="image_url">Image :</label>
        <input type="file" id="image_url" name="image_url">
        <p>Current Image: <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" width="100"></p>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required min="0">
        
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
