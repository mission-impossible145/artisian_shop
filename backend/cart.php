<?php
session_start();
include 'db_connection.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

if (empty($cart)) {
    echo "Your cart is empty.";
    exit();
}

// Fetch product details for items in cart
$product_ids = implode(',', $cart);
$sql = "SELECT * FROM products WHERE product_id IN ($product_ids)";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Cart</h1>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td>1</td> <!-- For simplicity, the quantity is hardcoded -->
                    <td><?= $product['price'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>