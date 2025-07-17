<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
$authToken = $_SESSION['authToken'] ?? null;
$purchaseDoc = $_SESSION['purchase_doc'] ?? null;
$selectedAddress = $purchaseDoc->selectedAddress ?? null;
$selectedPayment = $purchaseDoc->selectedPayment ?? null;

if(!isset($_SESSION['purchase_doc'])) {
    $purchaseDoc = new stdClass();
    $api = (new ApiBuilder())
        ->init()
        ->setMethod('GET')
        ->setPath("/getPurchaseID")
        ->setHeaders([
            "x-authorization" => "Bearer " . $authToken
        ])
        ->execute();
    $purchaseIDObj = $api->getResponse();
    $purchaseID = $purchaseIDObj->purchaseID?? null;
    $purchaseDoc->PID = $purchaseID;
    $_SESSION['purchase_doc'] = $purchaseDoc;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['address']) || isset($_POST['payment'])) && $isLoggedIn) {
    if(isset($_POST['address'])){
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

if($isLoggedIn && $_SERVER["REQUEST_METHOD"] ==="GET"){
    if(!$selectedAddress || (isset($_GET['change']) && $_GET['change'] == "address")) {
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
                <?php foreach ($userAddresses->userAddress as $index => $address):
                    $isSelected = ($selectedAddress &&  $selectedAddress->address_id == $address->address_id);?>
                    <div>
                        <label><input type="radio" name="address" value="<?= htmlspecialchars(json_encode($address)) ?>" <?= $isSelected ? 'checked' : '' ?>>
                            <?= htmlspecialchars($address->addr_line1) ?>,
                            <?= htmlspecialchars($address->addr_line2) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit">Proceed to Payment</button>
                </form>
                <a href="../addAddress/index.php?redirect=checkout">Add New Address</a>
            </div>
        </body>
        </html>
    <?php }elseif(!$selectedPayment|| (isset($_GET['change']) && $_GET['change'] == "payment")){
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
            <script>
                //Clicking Add New Payment Method displays an alert
                function addPayment(event){
                    event.preventDefault();
                    alert("Cannot add a new payment method as of now");
                }
            </script>
        </head>
        <body>
            <!-- Step 2: Select Payment Method -->
            <div class="step" id="step2">
                <h2>Step 2: Payment</h2>
                <form method="POST" action="../checkout/index.php">
                <?php foreach ($paymentMethods as $paymentMethod):
                    $isSelected = ($selectedPayment && $selectedPayment->id == $paymentMethod->id);?>
                    <label><input type="radio" name="payment" value="<?= htmlspecialchars(json_encode($paymentMethod)) ?>" required <?= $isSelected ? 'checked' : '' ?>> <?= htmlspecialchars($paymentMethod->name) ?>
                    </label>
                <?php endforeach; ?>
                <button type="submit">Order Summary</button>
                </form>
                <a href="#" onclick="addPayment(event)">Add New Payment Method</a>
            </div>
        </body>
        </html>
    <?php }else { //SPC Page

        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Order Summary</title>
                <link rel="stylesheet" href="../cart/style.css">
                <link rel="stylesheet" href="style.css">
                <script src="../scripts.js"></script>
                <script src="script.js" defer></script>
                <script src="../Config.js"></script>
            </head>
            <body>
            <div class="spc-container">
                <div id="cart_items_container"></div>
                <div class="bill-section-wrapper full-width-bill-box"></div>
                    <div class="half-box">
                        <div class="address" id="address">
                        <span>
                            <?= htmlspecialchars($selectedAddress->addr_line1 ?? '') ?>,
                            <?= htmlspecialchars($selectedAddress->addr_line2 ?? '') ?>
                        </span>
                        <span><a href="index.php?change=address">Change Address</a></span>
                        </div>
                    </div>
                <div class="half-box">
                    <div class="payment" id="payment">
                        <span><?= htmlspecialchars($selectedPayment->name) ?></span>
                        <span><a href="index.php?change=payment">Change Payment Method</a></span>
                    </div>
                <div class="pay-summary-box summary-combined-box">
                    <div class="half-box grand-total"></div>
                    <form method="POST" action="placeOrderHandler.php">
                        <button class="placeorder-btn" onclick="placeOrderHandler()">Place Order</button>
                    </form>
                </div>
            </div>
            </body>
            </html>
    <?php } ?>
<?php }else{
    header("Location: ../cart/");
    exit;
} ?>

