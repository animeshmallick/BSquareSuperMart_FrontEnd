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
    <link href="style.css" rel="stylesheet"/>
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
        <?php if(isset($_GET['error'])){ ?>
            <div class="invalid_creds">
                <h4><?=$_GET['error'] ?></h4>
            </div>
        <?php } ?>
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
