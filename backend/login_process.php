<?php
// Start the session
session_start();

// Include the database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    // Get the result of the query
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found
        $user = $result->fetch_assoc();

        // Verify the password (plain text comparison)
        if ($password == $user['password']) { 
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'seller') {
                header("Location: seller_dashboard.php");
            } elseif ($user['role'] == 'buyer') {
                header("Location: buyer_dashboard.php");
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>