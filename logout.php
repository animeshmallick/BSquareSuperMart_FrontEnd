<?php
session_start(); // Step 1: Start the session

// Step 2: Unset all session variables
$_SESSION = array();

// Step 3: If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Step 4: Finally, destroy the session.
session_destroy();

// Optional: Redirect to login or home page
header("Location: home/");
exit;
?>
