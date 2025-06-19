<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>My Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="../Config.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="cart-container">
    <div class="cart-scrollable">
        <div class="cart-header">My Cart</div>
            <div class="delivery-info-box"></div>
            <div id="cart_items_container"></div>

            <div class="bill-section-wrapper full-width-bill-box">

            </div>

            <div class="policy-box">
                <div class="address-title">Cancellation Policy</div>
                Orders cannot be cancelled once packed for delivery. In case of unexpected delays, a refund will be provided, if applicable.
            </div>

            <?php if ($isLoggedIn) { ?>
                <div class="pay-summary-box summary-combined-box">
                    <div class="half-box grand-total">Grand Total: ₹</div>
                    <button class="pay-btn modern-btn half-box">Proceed to Checkout</button>
                </div>
            <?php } else { ?>
                <div class="pay-summary-box summary-combined-box">
                    <div class="half-box grand-total"></div>
                    <a href="../login/index.php?redirect=cart" class="half-box login-btn modern-btn-link">Login to Proceed</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
