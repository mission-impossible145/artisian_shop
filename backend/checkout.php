<?php
session_start();
include 'db_connection.php';

if (empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='products.php'>Go back to shopping</a>";
    exit();
}

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
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #2c3e50;
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 30px 10px;
        }

        .checkout-table {
            flex: 1; /* Take up remaining space */
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px; /* Padding for table */
            margin-right: 20px; /* Spacing between frames */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px; /* Adjusted padding */
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

        .order-btn {
            background-color: #04AA6D; /* Green */
            border: none;
            color: white;
            padding: 10px 20px; /* Reduced padding */
            text-align: center;
            text-decoration: none;
            font-size: 14px; /* Reduced font size */
            margin-top: 20px; /* Space above the button */
            display: inline-block; /* Make it inline-block */
        }

        .order-btn:hover {
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
            text-decoration: none;
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
        <div class="container">
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
                <a href="order_confirmation.php" class="order-btn">Place Order</a>
                <a href="order_confirmation.php?product_id=<?php echo $product['product_id']; ?>&quantity=<?php echo $quantity; ?>" class="order-btn">Place Order</a>

            </div>
        </div>
        <a href="view_cart.php">Go Back to Cart</a>
    </div>
    <footer>
        &copy; <?php echo date("Y"); ?> Artisan Shop. All rights reserved.
    </footer>
</body>
</html>
