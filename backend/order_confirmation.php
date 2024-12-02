<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    // Optionally, you can fetch more data from the database using the product_id, like product details, price, etc.
    // Example:
    
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stock=htmlspecialchars($product['stock_quantity']);
    $stock=$stock-$quantity;
    $sqll="UPDATE `products` SET `stock_quantity`='$stock' WHERE `product_id`='$product_id'";
    $data=mysqli_query($conn,$sqll);
    
    
    
} else {
    echo "Product ID or Quantity not provided.";
}
echo "<h1>Order Confirmed</h1>";
echo "<p>Your order has been placed successfully.</p>";
echo "<a href='order_history.php'>View your orders</a>";
?>