<?php
session_start();
include "../Common.php";
$common = new Common();

if(!$common->is_user_logged_in($_SESSION['authToken'] ?? null)){

    header("Location: ../login/index.php?redirect=MyPurchases");
    exit();
}
$api = (new ApiBuilder())
    ->init()
    ->setMethod("GET")
    ->setPath("/getUserPurchases")
    ->setHeaders([
        "x-authorization" => "Bearer ".$_SESSION['authToken']
    ])
    ->execute();
$orders = $api->getResponse();

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
if($orders){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="purchases-container">
    <?php foreach ($orders as $order) {
        $statusClass = getStatusThemeClass($order->status);?>
        <div class="purchase-card <?= $statusClass ?>" onclick="window.location.href='../thankyou/index.php?PID=<?=htmlspecialchars($order->purchase_id) ?>'" style="cursor: pointer">
            <div class="purchase-header">
                <h2>Purchase ID: </h2><h4><?= htmlspecialchars($order->purchase_id) ?></h4>
                <div class="details">Status: <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($order->status) ?></span></div>
                <div class="details">Purchased On: <?= date("d M Y, h:i A", strtotime($order->placed_on)) ?></div>
            </div>
            <div class="purchase-details">
            <div class="total-items">
                <strong>Total Items in Order:</strong> <?= htmlspecialchars($order->total_quantity) ?>
            </div>
            <div class="address-payment">
                <div class="address">
                    <strong>Delivery Address:</strong><br>
                    <?= htmlspecialchars($order->address) ?>
                </div>
                <div class="payment">
                    <strong>Payment Method:</strong><br> <?= htmlspecialchars($order->payment) ?>
                </div>
            </div>
            </div>

<!--            <div class="purchase-info">-->
<!--                <div>--><?php //= htmlspecialchars($order->purchase_id) ?><!--</div>-->
<!--                <div>--><?php //= htmlspecialchars($order->status) ?><!--</div>-->
<!--                <div>--><?php //= htmlspecialchars($order->address_id) ?><!--</div>-->
<!--                <div>--><?php //= htmlspecialchars($order->payment_id) ?><!--</div>-->
<!--                <div>--><?php //=htmlspecialchars($order->total_quantity) ?><!--</div>-->
<!--            </div>-->
        </div>
    <?php }?>
</div>
</body>
</html>
<?php }else{
    echo "Something went wrong";}?>

