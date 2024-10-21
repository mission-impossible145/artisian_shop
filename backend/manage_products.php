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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Product Approvals</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212; /* Dark background */
            color: #ffffff; /* White text */
            padding: 20px;
        }

        h1 {
            color: #00BFAE; /* Vibrant teal */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #1F1F1F; /* Darker gray for the table */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #2A2A2A; /* Lighter gray for the border */
        }

        th {
            background-color: #00BFAE; /* Vibrant teal for header */
            color: #ffffff; /* White text for header */
        }

        tr:hover {
            background-color: #2A2A2A; /* Slightly lighter gray on hover */
        }

        button {
            background-color: #dc3545; /* Red for reject button */
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .approve-button {
            background-color: #007bff; /* Blue for approve button */
        }

        .approve-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<h1>Manage Product Approvals</h1>";
    echo "<table>
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
                        <button type='submit' class='approve-button'>Approve</button>
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
</body>
</html>
