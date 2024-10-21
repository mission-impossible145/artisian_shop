<?php
session_start();
include 'db_connection.php'; // Make sure this connects to your database

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Fetch the user's orders
$sql = "SELECT o.order_id, o.total_price, o.order_date, o.order_status 
        FROM orders o
        WHERE o.buyer_id = ? 
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error); // Display the SQL error
}

$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f8f9fa;
        }
        h1 {
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Your Orders</h1>
    
    <?php
    // Check if there are any orders
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Order Status</th> <!-- Updated to 'Order Status' -->
                    
                    
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['order_id'] . "</td>
                    <td>$" . number_format($row['total_price'], 2) . "</td>
                    <td>" . date('Y-m-d', strtotime($row['order_date'])) . "</td>
                    <td>" . htmlspecialchars($row['order_status']) . "</td> <!-- Updated to 'order_status' -->
                   
                   
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>You have no orders yet.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
