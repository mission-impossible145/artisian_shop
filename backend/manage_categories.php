<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle category insertion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO categories (category_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_name);
    if ($stmt->execute()) {
        echo "Category added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    if ($stmt->execute()) {
        echo "Category deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle category update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $sql = "UPDATE categories SET category_name = ? WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category_name, $category_id);
    if ($stmt->execute()) {
        echo "Category updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch categories from the database
$sql = "SELECT category_id, category_name FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .category-form {
            max-width: 400px;
            margin: 0 auto 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .category-form input[type="text"],
        .category-form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .category-list {
            max-width: 600px;
            margin: 0 auto;
        }

        .category-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .category-list table th, .category-list table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .edit-btn, .delete-btn {
            padding: 5px 10px;
            margin-right: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .delete-btn {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

    <h1>Manage Categories</h1>

    <!-- Add Category Form -->
    <form class="category-form" method="POST" action="">
        <h3>Add New Category</h3>
        <input type="text" name="category_name" placeholder="Category Name" required>
        <button type="submit" name="add_category">Add Category</button>
    </form>

    <!-- Display Categories -->
    <div class="category-list">
        <h3>Existing Categories</h3>
        <table>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($category = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($category['category_id']) ?></td>
                <td><?= htmlspecialchars($category['category_name']) ?></td>
                <td>
                    <!-- Edit form inside table row -->
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                        <input type="text" name="category_name" value="<?= htmlspecialchars($category['category_name']) ?>" required>
                        <button type="submit" name="edit_category">Edit</button>
                    </form>

                    <!-- Delete category -->
                    <a href="manage_categories.php?delete=<?= $category['category_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
