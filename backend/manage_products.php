<?php
session_start();
include 'db_connection.php'; // Ensure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all products awaiting approval
$sql = "SELECT p.product_id, p.product_name, p.price, p.description, p.image_url, p.seller_id, u.name 
        FROM products p
        JOIN users u ON p.seller_id = u.user_id
        WHERE p.approved = 0
        ORDER BY p.product_id DESC";

$result = $conn->query($sql);

// Check for errors in the SQL execution
if (!$result) {
    die("SQL Error: " . $conn->error); // Display error message
}

// Check if there are any products awaiting approval
if ($result->num_rows > 0) {
    echo "<h1>Manage Product Approvals</h1>";
    echo "<table border='1'>
            <tr>
                <th>Product ID</th>
                <th>Seller Name</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['product_id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['product_name']) . "</td>
                <td>$" . htmlspecialchars($row['price']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>
                    <form action='approve_product.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                        <button type='submit'>Approve</button>
                    </form>
                    <form action='reject_product.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                        <button type='submit' onclick='return confirm(\"Are you sure you want to reject this product?\");'>Reject</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No products awaiting approval.</p>";
}

$conn->close();
?>
