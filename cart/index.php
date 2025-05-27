<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>My Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="../Config.js"></script>
    <script src="script.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f9f9f9;
        }
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
        }
        .cart-header {
            font-size: 24px;
            font-weight: 600;
            padding: 16px;
            background: linear-gradient(to right, #ffd700, #fff8dc);
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        .close-icon {
            text-align: right;
            font-size: 20px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .delivery-section {
            display: flex;
            gap: 10px;
            font-size: 14px;
            margin: 10px 0;
        }
        .item-box {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .item-box img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        .item-details {
            flex: 1;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-control button {
            padding: 4px 10px;
        }
        .bill-section-wrapper {
            background-color: #fffbea;
            padding: 16px;
            margin: 20px 0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .bill-section-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 12px;
            color: #333;
        }
        .bill-line, .total-bill-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .total-bill-line {
            font-weight: 600;
            font-size: 16px;
        }
        .seperator {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
        .policy-section {
            font-size: 13px;
            margin-top: 10px;
            color: #666;
        }
        .checkout-summary {
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        .address-section, .payment-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .change-btn {
            color: #28a745;
            font-weight: 600;
            cursor: pointer;
        }
        .pay-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        .pay-btn, .login-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        .empty-cart {
            text-align: center;
            padding: 20px;
            font-size: 16px;
        }
    </style>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] === "GET") { ?>
    <body onload="redirectCartWithPostCall()"></body>
<?php } else {
if (!isset($_POST['cart'])) {
    echo "No cart data received";
    exit;
}

include "../ApiBuilder.php";
include "../Common.php";
$common = new Common();

$firstDecode = json_decode($_POST['cart']);
$cart = is_string($firstDecode) ? json_decode($firstDecode) : $firstDecode;

$api = (new ApiBuilder())
    ->init()
    ->setMethod('POST')
    ->setPath("/cart")
    ->setRequestBody($cart ?: [])
    ->execute();
$cart = $api->getResponse();
?>
<body>
<div class="cart-container">
    <div class="close-icon">×</div>
    <div class="cart-header">My Cart</div>

    <div id="cart_items_container">
        <?php if (isset($cart->error) && $cart->error === "Empty Cart") { ?>
            <div class="item-box">
                <div class="empty-cart">Empty Cart.</div>
            </div>
        <?php } else { ?>
        <div class="delivery-section">
            <p>Delivery in 13 minutes</p>
            <p>|</p>
            <p>Shipment of <?= count($cart->products) ?> item</p>
        </div>

        <?php foreach ($cart->products as $product) { ?>
            <div class="item-box">
                <img src="<?= $product->img ?>" alt="Product Image">
                <div class="item-details">
                    <div><?= $product->name ?></div>
                    <div><strong><?= $product->size ?></strong></div>
                    <div><strong>₹<?= $product->selling_price ?></strong></div>
                </div>
                <div class="quantity-control">
                    <button>-</button>
                    <span><?= $product->quantity ?></span>
                    <button>+</button>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="bill-section-wrapper">
        <div class="bill-section-title">Bill Details</div>
        <div class="bill-line"><span>Items total</span><span>₹<?= $cart->bill->cart_items_total ?></span></div><hr>
        <div class="bill-line"><span>Delivery charge</span><span>₹<?= $cart->bill->delivery_fee ?></span></div><hr>
        <div class="bill-line"><span>Packaging charge</span><span>₹<?= $cart->bill->packaging_fee ?></span></div><hr>
        <div class="bill-line"><span>Platform charge</span><span>₹<?= $cart->bill->platform_fee ?></span></div><hr>
        <?php if (isset($cart->bill->small_cart_fee)) { ?>
            <div class="bill-line"><span>Small cart charge</span><span>₹<?= $cart->bill->small_cart_fee ?></span></div>
        <?php } ?>
        <?php if (isset($cart->bill->restricted_cart_fee)) { ?>
            <div class="bill-line"><span>Restricted cart charges</span><span>₹<?= $cart->bill->restricted_cart_fee ?></span></div>
        <?php } ?>
        <div class="seperator"></div>
        <div class="total-bill-line"><span>Grand total</span><span>₹<?= $cart->bill->total_bill ?></span></div>
        <div class="seperator"></div>
    </div>

    <div class="policy-section">
        Orders cannot be cancelled once packed for delivery. In case of unexpected delays, a refund will be provided, if applicable.
    </div>

    <?php if (isset($_SESSION['authToken']) && $common->is_user_logged_in($_SESSION['authToken'])) { ?>
        <div class="checkout-summary">
            <div class="address-section">
                <div>
                    <strong>Delivering to Home</strong>
                    <div>Flat No 2A 009 Shilphitha Splendour</div>
                </div>
                <div class="change-btn">Change</div>
            </div>

            <div class="payment-section">
                <div><strong>Pay Using UPI upon delivery</strong></div>
                <div class="change-btn">Change</div>
            </div>

            <div class="pay-section">
                <div><span class="cart-total" id="cart_total">₹<?= $cart->bill->total_bill ?></span>&nbsp;&nbsp;TOTAL</div>
                <button class="pay-btn">Place Order</button>
            </div>
        </div>
    <?php } else { ?>
        <div class="checkout-summary">
            <div class="pay-section">
                <div><span class="cart-total" id="cart_total">₹<?= $cart->bill->total_bill ?></span>&nbsp;&nbsp;TOTAL</div>
                <a href="../login/index.php?redirect=cart"><button class="login-btn">Login To Proceed</button></a>
            </div>
        </div>
    <?php } ?>
</div>
</body>
<?php }
}
?>
</html>
