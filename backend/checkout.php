<?php
session_start();
include 'db_connection.php';

if (empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='products.php'>Go back to shopping</a>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $cart = $_SESSION['cart'];

    foreach ($cart as $product_id) {
        $sql = "INSERT INTO orders (user_id, product_id, quantity, status) VALUES (?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $user_id, $product_id, $quantity = 1);
        $stmt->execute();
    }

    // Clear the cart after successful checkout
    unset($_SESSION['cart']);

    echo "Order placed successfully!";
    header("Location: order_history.php");
    exit();
}
?>

<?php


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize total price
$total_price = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMI6wbbKlA9lG2zAzFPOoN8rx/8B2t4zVfZnY" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc; /* Light gray background */
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 0px;
        }

        h1 {
            margin-bottom: 50px;
            font-size: 2.5em;
            color: #2c3e50;
        }

        .checkout-table {
            width: 100%;
            max-width: 2000px; /* Increased width */
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin: 30px 10px;
            padding: 50px; /* Padding for table */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 30px; /* Increased padding */
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #007BFF; /* Blue header */
            color: #ffffff;
        }

      

        .total-row {
            font-weight: bold;
            background-color: #0056b3; /* Darker blue for total */
            color: #ffffff;
        }

        button {
            background-color: #28a745; /* Green for order button */
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1.2em; /* Larger button font */
        }

        button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF; /* Blue for links */
            font-size: 1.2em; /* Larger link font */
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            color: #333;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div>
        <h1>Checkout</h1>
        <div class="checkout-table">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php
                    include 'db_connection.php';
                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        $sql = "SELECT * FROM products WHERE product_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $product = $result->fetch_assoc();

                        if ($product) {
                            $subtotal = $product['price'] * $quantity;
                            $total_price += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                        <?php } 
                    } ?>
                    <tr class="total-row">
                        <td colspan="3">Total</td>
                        <td>$<?php echo number_format($total_price, 2); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <form action="checkout.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <button type="submit">Place Order</button>
        </form>
        <a href="view_cart.php">Go Back to Cart</a>
    </div>
    <footer>
        &copy; <?php echo date("Y"); ?> Artisan Shop. All rights reserved.
    </footer>
</body>
</html>
