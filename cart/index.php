<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="../Config.js"></script>
    <script src="script.js"></script>
</head>
<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === "GET"){ ?>
    <body onload="redirectCartWithPostCall()"></body>
<?php }else{
    if (!isset($_POST['cart'])) {
        echo "No cart data received";
        exit;
    }
    include "../ApiBuilder.php";
    include "../Common.php";
    $common = new Common();
    if($_POST['cart'] == null){
        $cart = [];
    }else {
        $firstDecode = json_decode($_POST['cart']);
        if (is_string($firstDecode)) {
            $cart = json_decode($firstDecode);
        } else {
            $cart = $firstDecode;
        }
    }
    $api = (new ApiBuilder())
        ->init()
        ->setMethod(METHOD::POST)
        ->setPath("/cart")
        ->setRequestBody($cart)
        ->execute();
    $cart = $api->getResponse();
    ?>
    <body>
        <div class="cart-container">
            <div class="close-icon">x</div>
            <div class="cart-header">My Cart</div>

            <div id='cart_items_container' class="items-container">
                <?php
                if(isset($cart->error) && $cart->error === "Empty Cart"){ ?>
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
                            <img src="<?= $product->img ?>" alt="ProductImage" />
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

                <div class="bill-section">
                    <div class="bill-line"><span>Items total</span><span>₹<?= $cart->bill->cart_items_total ?></span></div>
                    <div class="bill-line"><span>Delivery charge</span><span>₹<?= $cart->bill->delivery_fee ?></span></div>
                    <div class="bill-line"><span>Packaging charge</span><span>₹<?= $cart->bill->packaging_fee ?></span></div>
                    <div class="bill-line"><span>Platform charge</span><span>₹<?= $cart->bill->platform_fee ?></span></div>
                    <?php if(isset($cart->bill->small_cart_fee)){ ?>
                        <div class="bill-line"><span>Small cart charge</span><span>₹<?= $cart->bill->small_cart_fee ?></span></div>
                    <?php } ?>
                    <?php if(isset($cart->bill->restricted_cart_fee)){ ?>
                        <div class="bill-line"><span>Restricted cart charges</span><span>₹<?= $cart->bill->restricted_cart_fee ?></span></div>
                    <?php } ?>
                    <div class="seperator"></div>
                    <div class="total-bill-line"><span>Grand total</span><span>₹<?= $cart->bill->total_bill ?></span></div>
                    <div class="seperator"></div>
                </div>

                <div class="policy-section">
                    Orders cannot be cancelled once packed for delivery. In case of unexpected delays, a refund will be provided, if applicable.
                </div>

                <?php if(isset($_SESSION['customer_id']) && $common->is_user_logged_in($_SESSION['customer_id'])){ ?>

                    <div class="checkout-summary">
                        <div class="address-section">
                            <div>
                                <strong>Delivering to Home</strong>
                                <div>Flat No 2A 009 Shilphitha Splendour</div>
                            </div>
                            <div style="color: #28a745; font-weight: 600; cursor: pointer;">Change</div>
                        </div>

                        <div class="payment-section">
                            <div><strong>Pay Using UPI upon delivery</strong></div>
                            <div style="color: #28a745; font-weight: 600; cursor: pointer;">Change</div>
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
                            <button class="login-btn">Login To Proceed</button>
                        </div>
                    </div>
            <?php } ?>
            </div>
        <?php } ?>
    </body>
<?php } ?>
</html>
