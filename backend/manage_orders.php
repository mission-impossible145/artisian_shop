<?php
session_start();
include 'db_connection.php';

// Fetch all orders from the database
$sql = "SELECT o.order_id, o.user_id, o.product_id, o.quantity, o.status, o.created_at, u.username, p.product_name
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        JOIN products p ON o.product_id = p.product_id
        ORDER BY o.created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Manage Orders</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['order_id']; ?></td>
                        <td><?= $order['username']; ?></td>
                        <td><?= $order['product_name']; ?></td>
                        <td><?= $order['quantity']; ?></td>
                        <td>
                            <form action="update_order_status.php" method="POST">
                                <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                <select name="status">
                                    <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="Canceled" <?= $order['status'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                                <input type="submit" value="Update">
                            </form>
                        </td>
                        <td><?= $order['created_at']; ?></td>
                        <td>
                            <a href="delete_order.php?id=<?= $order['order_id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this order?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

    <a href="add_product.php">Back to Add Product</a> <!-- Link to go back to another page -->
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>