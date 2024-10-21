<?php
session_start();

// Check if the user is logged in and is an admin or seller
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'seller'])) {
    header("Location: login.php");
    exit();




}
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
        <select id="category" name="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image_url">Image:</label>
        <input type="file" id="image_url" name="image_url" required>

    

        <button type="submit">Add Product</button>
    </form>
</body>
</html>