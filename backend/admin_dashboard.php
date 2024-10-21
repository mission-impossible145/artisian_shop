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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212; /* Dark background */
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .sidebar {
            width: 250px;
            background-color: #1F1F1F; /* Darker gray */
            padding: 20px;
            color: #00BFAE; /* Vibrant teal */
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #00BFAE; /* Vibrant teal */
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #2A2A2A; /* Slightly lighter gray */
        }

        .content {
            margin-left: 270px; /* Space for the sidebar */
            padding: 20px;
            flex: 1;
            color: #fff; /* White text for content */
        }

        .header {
            background-color: #1F1F1F; /* Darker gray */
            padding: 20px;
            color: #00BFAE; /* Vibrant teal */
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 2.5rem;
        }

       
       
        .logout-btn {
            display: block;
            background-color: ; /* Vibrant teal */
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
            background-color: #009B8B; /* Darker teal */
        }

     
    </style>
</head>
<body>


    <div class="sidebar">
        <h2>Admin Menu</h2>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_products.php">Manage Products</a>
        
        <a href="manage_categories.php">Manage Categories</a>
        <a href="analytics.php">View Analytics</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
        </div>

    </div>
    
    

</body>
</html>
