<?php
session_start();
include "../Common.php";
$common = new Common();

if(!$common->is_user_logged_in($_SESSION['authToken'] ?? null) || !isset($_GET['PID'])) {
    header("Location: ../login/index.php");
    exit();
}
$pid = $_GET['PID'];
$api = (new ApiBuilder())->init()
    ->setMethod("GET")
    ->setPath("/getPurchaseDoc/".$pid)
    ->setHeaders(["x-authorization" => "Bearer " . $_SESSION['authToken']])
    ->execute();
if(!isset($api->getResponse()->purchase_id) || $api->getResponse()->purchase_id != $pid) {
    echo "Invalid Purchase ID";
}
$response = $api->getResponse();
function getStatusThemeClass($status): string
{
    $themes = [
        "PLACED" => "status-placed",
        "CONFIRMED" => "status-confirmed",
        "PACKAGING_IN_PROGRESS" => "status-packaging",
        "PACKAGING_COMPLETED" => "status-packaging-complete",
        "OUT_FOR_DELIVERY" => "status-out-for-delivery",
        "CANCELLED" => "status-cancelled",
        "DELIVERED_WITH_PAYMENT_PENDING" => "status-payment-pending",
        "DELIVERED_WITH_PAYMENT_SUCCESS" => "status-payment-success"
    ];
    return $themes[$status] ?? "status-default";
}

$statusClass = getStatusThemeClass($response->status);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="purchase-container <?= $statusClass ?>">
    <div class="header">
        <h2>Purchase ID: </h2><h4><?= htmlspecialchars($response->purchase_id) ?></h4>
        <div class="details">
            Status: <span class="status-badge"><?= htmlspecialchars($response->status) ?></span>
        </div>
        <div class="details">Purchased On: <?= date("d M Y, h:i A", strtotime($response->purchased_at)) ?></div>
    </div>

    <div class="address">
        <strong>Delivery Address:</strong><br>
        <?= htmlspecialchars($response->address->address_line_1) ?><br>
        <?= htmlspecialchars($response->address->address_line_2) ?>
    </div>

    <div class="payment">
        <strong>Payment Method:</strong> <?= htmlspecialchars($response->payment->payment) ?>
    </div>

    <h3 style="margin-top:30px; margin-bottom:15px;">Items Ordered</h3>
    <div class="products-grid">
        <?php foreach ($response->orders as $order):
            $product = $order->product; ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->name) ?>">
                <div class="product-content">
                    <h4><?= htmlspecialchars($product->name) ?></h4>
                    <p><?= htmlspecialchars($product->brand) ?> • <?= htmlspecialchars($product->size) ?></p>
                    <div class="price">₹<?= htmlspecialchars($product->selling_price) ?>
                        <span class="mrp">₹<?= htmlspecialchars($product->mrp) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
