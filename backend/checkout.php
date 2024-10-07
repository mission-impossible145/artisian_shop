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

        .payment-details {
            flex: 1; /* Take up remaining space */
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px; /* Padding for payment section */
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

        .payment-details h2 {
            margin-bottom: 15px;
        }

        input[type="text"], input[type="number"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            </div>

            <div class="payment-details">
                <form action="place_order.php" method="POST">
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

                    <h2>Payment Details</h2>

                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="">Select a payment method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="upi">UPI</option> <!-- Added UPI option -->
                        <option value="cash_on_delivery">Cash on Delivery</option> <!-- Added Cash on Delivery option -->
                    </select>

                    <div id="credit_card_details" style="display:none;">
                        <h3>Credit Card Information</h3>
                        <label for="card_number">Card Number:</label>
                        <input type="text" name="card_number" id="card_number" placeholder="Enter your card number" required>

                        <label for="card_expiry">Expiry Date:</label>
                        <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/YY" required>

                        <label for="card_cvc">CVC:</label>
                        <input type="number" name="card_cvc" id="card_cvc" placeholder="CVC" required>

                     
                    
                    </div>

                    <div id="paypal_details" style="display:none;">
                        <h3>PayPal Information</h3>
                        <label for="paypal_email">PayPal Email:</label>
                        <input type="email" name="paypal_email" id="paypal_email" placeholder="Enter your PayPal email" required>
                    </div>

                    

                    <div id="upi_details" style="display:none;">
                        <h3>UPI Information</h3>
                        <label for="upi_id">UPI ID:</label>
                        <input type="text" name="upi_id" id="upi_id" placeholder="Enter your UPI ID" required>
                    </div>

                    

                    <div id="cod_details" style="display:none;">
                        <h3>Cash on Delivery</h3>
                        <p>Please make sure you have the correct cash amount ready for delivery.</p>
                    </div>

                    <a href="payment_gateway.php" class="order-btn">place order</a>
                   
                </form>
            </div>
        </div>
        <a href="view_cart.php">Go Back to Cart</a>
    </div>
    <footer>
        &copy; <?php echo date("Y"); ?> Artisan Shop. All rights reserved.
    </footer>

    <script>
        const paymentMethod = document.getElementById('payment_method');
        const creditCardDetails = document.getElementById('credit_card_details');
        const paypalDetails = document.getElementById('paypal_details');
        const upiDetails = document.getElementById('upi_details');
        const codDetails = document.getElementById('cod_details');

        paymentMethod.addEventListener('change', function () {
            // Hide all payment details initially
            creditCardDetails.style.display = 'none';
            paypalDetails.style.display = 'none';
            upiDetails.style.display = 'none';
            codDetails.style.display = 'none';

            // Show relevant payment details based on the selected payment method
            if (this.value === 'credit_card') {
                creditCardDetails.style.display = 'block';
            } else if (this.value === 'paypal') {
                paypalDetails.style.display = 'block';
            } else if (this.value === 'upi') {
                upiDetails.style.display = 'block';
            } else if (this.value === 'cash_on_delivery') {
                codDetails.style.display = 'block';
            }
        });
    </script>
</body>
</html>

