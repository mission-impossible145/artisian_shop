<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the email already exists
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered. Please use a different email.";
    } else {
        // Insert the user into the users table
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        
        // Prepare the statement to prevent SQL injection
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters (s: string)
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful!";
            // Redirect to a success or login page
            header("Location: login.php"); // Redirect to login page after registration
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
