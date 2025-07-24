<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>My Cart</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../styles.css">
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="script.js"></script>
    <script src="../scripts.js"></script>
    <link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>
<div class="cart-container">
    <div class="cart-header">My Cart</div>
    <div class="delivery-info-box"></div>
    <div id="cart_items_container"></div>
    <div class="bill-section-wrapper full-width-bill-box"></div>
    <div class="policy-box">
        <div class="address-title">Cancellation Policy</div>
        Orders cannot be cancelled once packed for delivery. In case of unexpected delays, a refund will be provided, if applicable.
    </div>
    <?php if ($isLoggedIn) { ?>
        <div class="pay-summary-box summary-combined-box">
            <div class="half-box grand-total">Grand Total: ₹</div>
            <button class="pay-btn modern-btn half-box" onclick="window.location.href='../checkout/'">Proceed to Checkout</button>
        </div>
    <?php } else { ?>
        <div class="pay-summary-box summary-combined-box">
            <div class="half-box grand-total"></div>
            <a href="../login/index.php?redirect=cart" class="half-box login-btn modern-btn-link">Login to Proceed</a>
        </div>
    <?php } ?>
</div>
<div id="page_footer"><?php include '../components/footer.html'; ?></div>
</body>
</html>
