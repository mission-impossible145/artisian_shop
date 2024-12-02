<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

// Initialize total price
$total_price = 0;

// Handle quantity updates
if (isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $new_quantity = intval($_POST['quantity']);

    // Fetch product from database to check stock
    $sql = "SELECT stock_quantity FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $available_stock = $product['stock_quantity'];

        // Check if requested quantity is more than available stock
        if ($new_quantity > $available_stock) {
            $_SESSION['error'] = "Requested quantity for " . $product_id . " exceeds available stock.";
        } else {
            // Update the session cart
            $_SESSION['cart'][$product_id] = $new_quantity;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMI6wbbKlA9lG2zAzFPOoN8rx/8B2t4zVfZnY" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #e0e0e0, #ffffff);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #2c3e50;
        }

        .cart-table {
            width: 100%;
            max-width: 900px; /* Increased the max-width */
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 30px; /* Increased padding for larger size */
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #009688; /* Changed to muted teal */
            color: #ffffff;
        }

      

        a {
            color: #009688; /* Changed to muted teal */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .total-row {
            font-weight: bold;
            background-color: #00796b; /* Darker muted teal */
            color: #ffffff;
        }

        .checkout-btn {
            display: inline-block;
            background-color: #e67e22;
            color: white;
            padding: 15px 30px; /* Increased padding for larger button */
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: #d35400;
        }

        .empty-cart {
            text-align: center;
            padding: 20px;
            color: #333;
            font-size: 1.2em;
        }

        
        .quantity-btn {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #009688;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .quantity-btn:hover {
            background-color: #00796b;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .continue-shopping {
            display: inline-block;
            margin-top: 20px;
            background-color: #009688; /* Changed to muted teal */
            color: white;
            padding: 15px 30px; /* Increased padding for larger button */
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .continue-shopping:hover {
            background-color: #00796b; /* Darker muted teal */
        }


        footer {
            margin-top: 20px;
            text-align: center;
            color: #333;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div>
        <h1>Your Shopping Cart</h1>

         <!-- Display any error messages -->
         <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="cart-table">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
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
                                <td>
                                <form action="" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" max="<?php echo $product['stock_quantity']; ?>">
                                        <button type="submit" name="update_quantity" class="quantity-btn">Update</button>
                                    </form>
                                </td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td><a href="remove_from_cart.php?id=<?php echo $product_id; ?>">Remove</a></td>
                            </tr>
                        <?php } 
                    } ?>
                    <tr class="total-row">
                        <td colspan="3">Total</td>
                        <td>$<?php echo number_format($total_price, 2); ?></td>
                        <td><a href="checkout.php" class="checkout-btn">Proceed to Checkout</a></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-cart">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <a href="products.php" class="continue-shopping">Continue Shopping</a>

        <footer>
            &copy; <?php echo date("Y"); ?> Artisan Shop. All rights reserved.
        </footer>
    </div>
</body>
</html>

