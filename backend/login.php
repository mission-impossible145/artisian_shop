<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        /* General styles for the body */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b); /* Gradient background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            color: #333; /* Dark text for contrast */
        }

        /* Container for the login form */
        .container {
            background-color: white; /* White background for the form */
            padding: 30px 20px; /* More padding for a spacious look */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Deeper shadow for depth */
            width: 350px; /* Fixed width */
            text-align: center; /* Centered text */
        }

        /* Heading styles */
        h2 {
            margin-bottom: 20px; /* Space below heading */
            font-size: 1.8rem; /* Increased font size */
            color: #ff6b6b; /* Soft red color */
        }

        /* Input group styles */
        .input-group {
            margin-bottom: 15px; /* Space between input groups */
        }

        /* Label styles */
        label {
            display: block; /* Block display for label */
            margin-bottom: 5px; /* Space below label */
            color: #333; /* Dark gray text color */
            font-weight: bold; /* Bold labels */
        }

        /* Input field styles */
        input[type="email"],
        input[type="password"] {
            width: 100%; /* Full width */
            padding: 12px; /* Padding inside input */
            border: 2px solid #ff7e5f; /* Soft red border */
            border-radius: 5px; /* Rounded corners */
            box-sizing: border-box; /* Include padding and border in width */
            transition: border-color 0.3s; /* Transition for border color */
        }

        /* Input field focus effect */
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #feb47b; /* Change border color on focus */
            outline: none; /* Remove outline */
        }

        /* Button styles */
        .btn {
            width: 100%; /* Full width button */
            padding: 12px; /* Padding inside button */
            background: linear-gradient(to right, #ff6b6b, #ff8e53); /* Gradient background */
            color: white; /* White text */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger text */
            transition: background 0.3s, transform 0.2s; /* Smooth background transition */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        /* Button hover effect */
        .btn:hover {
            background: linear-gradient(to right, #ff8e53, #ff6b6b); /* Reverse gradient on hover */
            transform: translateY(-2px); /* Lift effect on hover */
        }

        /* Paragraph styles */
        p {
            margin-top: 15px; /* Space above paragraph */
            color: #666; /* Gray text color */
        }

        /* Link styles */
        a {
            color: #ff6b6b; /* Soft red link color */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Bold link */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
