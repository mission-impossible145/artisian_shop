<?php
session_start();
include 'db_connection.php'; // Ensure this connects to your database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Check if user ID is provided
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    
    // Fetch the user details from the database
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists
    if (!$user) {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin" <?php echo ($user['role'] == 'admin' ? 'selected' : ''); ?>>Admin</option>
            <option value="seller" <?php echo ($user['role'] == 'seller' ? 'selected' : ''); ?>>Seller</option>
            <option value="buyer" <?php echo ($user['role'] == 'buyer' ? 'selected' : ''); ?>>Buyer</option>
        </select>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
