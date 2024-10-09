<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Internal CSS for styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4c3; /* Light green background */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px; /* Maximum width for the registration form */
            margin: 50px auto; /* Center the form */
            padding: 20px; /* Padding around the form */
            background-color: #ffffff; /* White background for form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        h1 {
            text-align: center; /* Center align the heading */
            color: #4CAF50; /* Green color for heading */
        }

        label {
            display: block; /* Block display for labels */
            margin-bottom: 5px; /* Space below labels */
            color: #333; /* Dark color for labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding for inputs */
            margin: 10px 0; /* Space above and below inputs */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px; /* Rounded corners */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green background for submit button */
            color: white; /* White text for button */
            border: none; /* No border */
            padding: 10px; /* Padding for button */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            font-size: 1.1em; /* Larger font for button */
            transition: background-color 0.3s; /* Smooth background change */
        }

        input[type="submit"]:hover {
            background-color: #45A049; /* Darker green on hover */
        }

        .footer {
            text-align: center; /* Center align footer text */
            margin-top: 20px; /* Space above footer */
        }

        .footer a {
            text-decoration: none; /* No underline */
            color: #4CAF50; /* Green color for link */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Registration</h1>
        <form action="register_process.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>

            <input type="submit" value="Register">
        </form>
        <div class="footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
