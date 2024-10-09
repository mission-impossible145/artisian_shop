<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $buyer_id = $_SESSION['user_id'];

    // Fetch the order details, ensuring it belongs to the logged-in buyer
    $sql = "SELECT * FROM orders WHERE order_id = ? AND buyer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $buyer_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order = $order_result->fetch_assoc();

    if ($order) {
        echo "<h1>Order #" . $order['order_id'] . "</h1>";
        echo "<p>Total Price: $" . $order['total_price'] . "</p>";
        echo "<p>Order Date: " . date('Y-m-d', strtotime($order['order_date'])) . "</p>";
        echo "<p>order Status: " . $order['order_status'] . "</p>";

        // Fetch the items in this order
        $sql_items = "SELECT oi.product_id, oi.quantity, p.product_name, p.price 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.product_id 
                      WHERE oi.order_id = ?";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();

        if ($items_result->num_rows > 0) {
            echo "<h2>Items in this order</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>";

            while ($item = $items_result->fetch_assoc()) {
                $subtotal = $item['price'] * $item['quantity'];
                echo "<tr>
                        <td>" . $item['product_name'] . "</td>
                        <td>$" . $item['price'] . "</td>
                        <td>" . $item['quantity'] . "</td>
                        <td>$" . $subtotal . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items found for this order.</p>";
        }

        $stmt_items->close();
    } else {
        echo "Order not found or you don't have permission to view this order.";
    }

    $stmt->close();
} else {
    echo "No order ID provided.";
}

$conn->close();
?>


<?php
// Assume $product contains the order data fetched from the database
echo "<h2>Order Details for Order ID: " . $order['order_id'] . "</h2>";
// Display other order details...

// Include the status update form
?>
<form action="update_order_status.php" method="POST">
    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
    
    <label for="order_status">Update Order Status:</label>
    <select name="order_status" id="order_status" required>
        <option value="Pending" <?php if($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Processing" <?php if($order['order_status'] == 'Processing') echo 'selected'; ?>>Processing</option>
        <option value="Shipped" <?php if($order['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
        <option value="Delivered" <?php if($order['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
        <option value="Cancelled" <?php if($order['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
    </select>
    
    <button type="submit">Update Status</button>
</form>
