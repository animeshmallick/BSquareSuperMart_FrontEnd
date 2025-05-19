<?php
    session_start();
    $redirect_to = $_GET['redirect'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link href="../styles.css" rel="stylesheet"/>
    <script src="../Config.js"></script>
    <script src="../scripts.js"></script>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="loginHandler.php" method="POST">
        <label for="phone">PhoneNumber</label>
        <input type="tel" name="PHONE" id="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required>
        <label for="password">Password</label>
        <input type="password" name="PASSWORD" id="password" placeholder="Password" />
        <input type="text" name="redirect" hidden="hidden" />
        <input type="submit" value="Login" />
    </form>
</div>
</body>
</html>