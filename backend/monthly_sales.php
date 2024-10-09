<?php
session_start();

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

// Connect to the database
require '../backend/db_connection.php'; // Add your DB connection here

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Fetch total sales for the current month from the database (assuming a table 'sales')
$seller_id = $_SESSION['user_id'];
$query = "SELECT SUM(total_amount) AS monthly_sales FROM sales 
          WHERE seller_id = '$seller_id' AND MONTH(sale_date) = '$currentMonth' AND YEAR(sale_date) = '$currentYear'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$monthly_sales = $row['monthly_sales'] ? $row['monthly_sales'] : 0; // If no sales, set to 0
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Sales</title>
    <link rel="stylesheet" href="../assets/css/monthly_sales.css">
</head>
<body>
    <div class="container">
        <h1>Monthly Sales Report</h1>
        <p>Your total sales for <?php echo date('F Y'); ?>:</p>
        <h2><?php echo '₹ ' . number_format($monthly_sales, 2); ?></h2>
        <a href="seller_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
