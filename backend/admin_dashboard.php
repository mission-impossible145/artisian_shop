<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMI6wbbKlA9lG2zAzFPOoN8rx/8B2t4zVfZnY" crossorigin="anonymous"> <!-- Font Awesome -->
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #f0f4c3, #81d4fa); /* Colorful gradient background */
            color: #333;
            padding: 20px;
            height: 100vh; /* Full height */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background-color: #007bff;
            padding: 20px;
            color: #fff;
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 2.5rem;
        }

        p {
            font-size: 1.2rem;
        }

        .admin-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Responsive grid layout */
            gap: 20px;
            padding: 30px;
        }

        .admin-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .admin-card i {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .admin-card a {
            display: block;
            color: #333;
            text-decoration: none;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .admin-card a:hover {
            color: #007bff;
            text-decoration: underline;
        }

        .logout-btn {
            display: block;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            max-width: 200px;
            font-size: 1.2rem;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
            padding: 20px 0;
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
        </div>

        <div class="admin-options">
            <div class="admin-card">
                <i class="fas fa-users"></i>
                <a href="manage_users.php">Manage Users</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-box-open"></i>
                <a href="manage_products.php">Manage Products</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-shopping-cart"></i>
                <a href="manage_orders.php">Manage Orders</a>
            </div>
            <div class="admin-card">
                <i class="fas fa-chart-line"></i>
                <a href="analytics.php">View Analytics</a>
            </div>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Artisan Shop. All rights reserved.
    </footer>

</body>
</html>
