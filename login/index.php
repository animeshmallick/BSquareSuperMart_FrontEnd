<?php
session_start();
$redirect_to = $_GET['redirect'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | BSquareSuperMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #ffd700, #fff8dc); /* Yellow gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            animation: fadeInUp 0.5s ease-out;
        }
        .login-container h1 {
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
            color: #f57f17; /* Deep yellow-orange for brand */
        }
        .login-container h2 {
            font-size: 22px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="tel"],
        input[type="password"] {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }
        input[type="tel"]:focus,
        input[type="password"]:focus {
            border-color: #fbc02d;
        }
        input[type="submit"] {
            background-color: #f57f17;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #ef6c00;
        }
        .extra-links {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }
        .extra-links a {
            color: #f57f17;
            text-decoration: none;
            font-weight: 500;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
        @keyframes fadeInUp {
            0% { transform: translateY(30px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>BSquareSuperMart</h1>
    <h2>Login</h2>
    <form action="loginHandler.php" method="POST">
        <label for="phone">Phone Number</label>
        <input type="tel" name="PHONE" id="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required>

        <label for="password">Password</label>
        <input type="password" name="PASSWORD" id="password" placeholder="Enter your password" required>

        <input type="text" name="redirect" value="<?= htmlspecialchars($redirect_to) ?>" hidden />

        <input type="submit" value="Sign In" />

        <div class="extra-links">
            <a href="#">Forgot Password?</a> |
            <a href="../signup/index.php">Sign Up</a>
        </div>
    </form>
</div>
</body>
</html>
