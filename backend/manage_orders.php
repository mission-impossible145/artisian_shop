<?php
session_start();
include 'db_connection.php'; // Make sure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

// Fetch all orders from the database
$sql = "SELECT o.order_id, o.total_price, o.order_date, o.order_status,  u.name 
        FROM orders o
        JOIN users u ON o.buyer_id = u.user_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);

// Check for errors in the SQL execution
if (!$result) {
    die("SQL Error: " . $conn->error); // Display error message
}

// Check if there are any orders
if ($result->num_rows > 0) {
    echo "<h1>Manage Orders</h1>";
    echo "<table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Buyer</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Status</th>
                
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['order_id'] . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>$" . htmlspecialchars($row['total_price']) . "</td>
                <td>" . date('Y-m-d', strtotime($row['order_date'])) . "</td>
                <td>" . htmlspecialchars($row['order_status']) . "</td>
               
                <td>
                    <form action='update_order_status.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                        <select name='order_status' required>
                            <option value='Pending' " . ($row['order_status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            <option value='Processing' " . ($row['order_status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                            <option value='Shipped' " . ($row['order_status'] == 'Shipped' ? 'selected' : '') . ">Shipped</option>
                            <option value='Delivered' " . ($row['order_status'] == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                            <option value='Cancelled' " . ($row['order_status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                        </select>
                        <button type='submit'>Update</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No orders found.</p>";
}

$conn->close();
?>
