<?php
session_start();
if(!isset($_SESSION['purchase_doc'])) {
    $_SESSION['purchase_doc'] = new stdClass();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['address']) || isset($_POST['payment']))) {
    if(isset($_POST['address'])){
        echo $_POST['address'];
        $purchaseDoc = $_SESSION['purchase_doc'];
        $purchaseDoc->selectedAddress = json_decode($_POST['address']);
        $_SESSION['purchase_doc'] = $purchaseDoc;
    }else{
        $purchaseDoc = $_SESSION['purchase_doc'];
        $purchaseDoc->selectedPayment = json_decode($_POST['payment']);
        $_SESSION['purchase_doc'] = $purchaseDoc;
    }
    // Redirect back to this page with GET to avoid form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
$authToken = $_SESSION['authToken'] ?? null;
$purchaseDoc = $_SESSION['purchase_doc'] ?? null;
$address = $purchaseDoc->selectedAddress ?? null;
$payment = $purchaseDoc->selectedPayment ?? null;

if($isLoggedIn){
    if(!$address){
        $api = (new ApiBuilder())
            ->init()
            ->setMethod('GET')
            ->setPath("/getUserAddresses")
            ->setHeaders([
                "x-authorization" => "Bearer " . $authToken
            ])
            ->execute();
        $userAddresses = $api->getResponse();?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Checkout</title>
        </head>
        <body>
        <!-- Step 1: Address Selection -->
        <div class="step" id="step1">
            <h2>Step 1: Delivery Address</h2>
            <form method="POST" action="../checkout/index.php">
            <?php foreach ($userAddresses->userAddress as $index => $address): ?>
                <div>
                    <label><input type="radio" name="address" value="<?= json_encode($address) ?>">
                        <?= htmlspecialchars($address->addr_line1) ?>,
                        <?= htmlspecialchars($address->addr_line2) ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <button type="submit">Proceed to Payment</button>
            </form>
        </div>

        </body>
        </html>
    <?php }elseif(!$payment){
        $api = (new ApiBuilder())
            ->init()
            ->setMethod('GET')
            ->setPath("/getPaymentMethod")
            ->setHeaders([
                "x-authorization" => "Bearer " . $authToken
            ])
            ->execute();
        $paymentMethods = $api->getResponse(); ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Checkout</title>
        </head>
        <body>
        <form method="POST" action="../checkout/index.php">
            <!-- Step 2: Select Payment Method -->
            <div class="step" id="step2">
                <h2>Step 2: Payment</h2>
                <?php foreach ($paymentMethods as $paymentMethod): ?>
                    <label><input type="radio" name="payment" value="<?= json_encode($paymentMethod) ?>" required> <?=htmlspecialchars($paymentMethod->name) ?>
                    </label>
                <?php endforeach; ?>
                <button type="submit">Order Summary</button>
            </div>
        </form>
        </body>
        </html>
    <?php }else {?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Order Summary</title>
            <link rel="stylesheet" href="../cart/style.css">
            <script src="script.js" defer></script>
            <script src="../Config.js"></script>
            <script src="../scripts.js"></script>
        </head>
        <body>
        <div id="cart_items_container"></div>
        <div class="bill-section-wrapper full-width-bill-box"></div>
        <div class="address" id="address"></div>

        <div class="payment" id="payment"></div>
        <div class="half-box grand-total"></div>
        <a href="" class="half-box">Place Order</a>
        </body>
        </html>
    <?php } ?>
<?php }else{
    header("Location: ../cart/");
    exit;
} ?>

