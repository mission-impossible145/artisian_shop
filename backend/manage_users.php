<?php
session_start();
include 'db_connection.php'; // Ensure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all active users from the database
$sql = "SELECT user_id, name, email, role, created_at FROM users WHERE deleted = 0 ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check for errors in the SQL execution
if (!$result) {
    die("SQL Error: " . $conn->error); // Display error message
}

// Check if there are any users
if ($result->num_rows > 0) {
    echo "<h1>Manage Users</h1>";
    echo "<table border='1'>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['user_id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['role']) . "</td>
                <td>" . date('Y-m-d H:i:s', strtotime($row['created_at'])) . "</td>
                <td>
                    <form action='delete_user.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                        <button type='submit' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                    </form>
                    <form action='edit_user.php' method='GET' style='display:inline;'>
                        <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                        <button type='submit'>Edit</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No users found.</p>";
}

$conn->close();
?>
