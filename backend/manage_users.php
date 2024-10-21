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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            background-color: #dc3545; /* Red for delete button */
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

        .edit-button {
            background-color: #007bff; /* Blue for edit button */
        }

        .edit-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<h1>Manage Users</h1>";
    echo "<table>
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
                        <button type='submit' class='edit-button'>Edit</button>
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
</body>
</html>
