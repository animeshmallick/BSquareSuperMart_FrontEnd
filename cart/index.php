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
    <link rel="stylesheet" href="style.css">
    <script src="../Config.js"></script>
    <script src="script.js"></script>
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

    $isLoggedIn = isset($_SESSION['authToken']) && $common->is_user_logged_in($_SESSION['authToken']);
    $userAddress = $isLoggedIn ? ($_SESSION['user_address'] ?? "Flat No 2A 009, Shilphitha Splendour") : "Your Location";
    ?>
    <body>
    <div class="cart-container">
        <div class="cart-scrollable">
            <div class="cart-header">My Cart</div>

            <?php if (isset($cart->error) && $cart->error === "Empty Cart") { ?>
                <div class="item-box">
                    <div class="empty-cart">Empty Cart.</div>
                </div>
            <?php } else { ?>

                <div class="delivery-info-box">
                    Delivery in 13 minutes | Shipment of <?= count($cart->products) ?> item<?= count($cart->products) > 1 ? 's' : '' ?>
                </div>

                <div id="cart_items_container">
                    <?php foreach ($cart->products as $product) { ?>
                        <div class="item-box">
                            <img src="<?= $product->img ?>" alt="Product Image">
                            <div class="item-details">
                                <div><?= $product->name ?></div>
                                <div><strong><?= $product->size ?></strong></div>
                                <div><strong>₹<?= $product->selling_price ?></strong></div>
                            </div>
                            <div class="quantity-control">
                                <button class="qty-btn">-</button>
                                <span><?= $product->quantity ?></span>
                                <button class="qty-btn">+</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="bill-section-wrapper full-width-bill-box">
                    <div class="bill-section-title">Bill Details</div>
                    <div class="bill-line"><span>🛒 Items total</span><span>₹<?= $cart->bill->cart_items_total ?></span></div><hr>
                    <div class="bill-line"><span>🚚 Delivery charge</span><span>₹<?= $cart->bill->delivery_fee ?></span></div>
                    <div class="bill-line"><span>📦 Packaging charge</span><span>₹<?= $cart->bill->packaging_fee ?></span></div>
                    <div class="bill-line"><span>🖥️ Platform charge</span><span>₹<?= $cart->bill->platform_fee ?></span></div>
                    <?php if (isset($cart->bill->small_cart_fee)) { ?>
                        <div class="bill-line"><span>🧺 Small cart charge</span><span>₹<?= $cart->bill->small_cart_fee ?></span></div>
                    <?php } ?>
                    <?php if (isset($cart->bill->restricted_cart_fee)) { ?>
                        <div class="bill-line"><span>🔒 Restricted cart charge</span><span>₹<?= $cart->bill->restricted_cart_fee ?></span></div><hr>
                    <?php } ?>
                    <div class="total-bill-line total-bill-box">
                        <span>Total</span><span><strong>₹<?= $cart->bill->total_bill ?></strong></span>
                    </div>
                </div>

                <div class="policy-box">
                    <div class="address-title">Cancellation Policy</div>
                    Orders cannot be cancelled once packed for delivery. In case of unexpected delays, a refund will be provided, if applicable.
                </div>

                <div class="address-info-box">
                    <div class="address-line">
                        <strong>Delivery Address:</strong> <?= $userAddress ?>
                    </div>
                    <button class="change-address-btn"><?= $isLoggedIn ? "Change / Add Address" : "Add Address" ?></button>
                </div>

                <?php if ($isLoggedIn) { ?>
                    <div class="pay-summary-box summary-combined-box">
                        <div class="half-box grand-total">Grand Total: ₹<?= $cart->bill->total_bill ?></div>
                        <button class="pay-btn modern-btn half-box">Proceed to Pay</button>
                    </div>
                <?php } else { ?>
                    <div class="pay-summary-box summary-combined-box">
                        <div class="half-box grand-total">Grand Total: ₹<?= $cart->bill->total_bill ?></div>
                        <a href="../login/index.php?redirect=cart" class="half-box login-btn modern-btn-link">Login to Proceed</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    </body>
<?php } ?>
</html>
