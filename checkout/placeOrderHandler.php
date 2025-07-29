<?php
session_start();
header('Content-Type: application/json');
include '../Common.php';
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
if ($isLoggedIn) {
    $purchaseDoc = $_SESSION["purchase_doc"] ?? null;
    if ($purchaseDoc && isset($purchaseDoc->selectedAddress) && isset($purchaseDoc->selectedPayment) &&
        isset($purchaseDoc->PID) && isset($_POST["cart"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
        $cart = json_decode($_POST["cart"], true);
        if (!is_array($cart)) {
            echo json_encode(['error' => 'Invalid cart format']);
            exit;
        }

        $purchaseID = $purchaseDoc->PID;
        $address = $purchaseDoc->selectedAddress;
        $payment = $purchaseDoc->selectedPayment;

        $requestBody = [
            "address" => $address->address_id,
            "payment" => $payment->id,
            "cart" => $cart,
            "purchase_id" => $purchaseID
        ];

        $api = (new ApiBuilder())
            ->init()
            ->setMethod('POST')
            ->setPath("/placeOrder")
            ->setHeaders([
                "x-authorization" => "Bearer " . $_SESSION['authToken']
            ])
            ->setRequestBody($requestBody)
            ->execute();

        unset($_SESSION['purchase_doc']);

        if ($api->getStatusCode() == 201 && $api->getResponse()->signed) {
            echo json_encode(['status' => 'Order Placed Success', 'PID' => $api->getResponse()->purchase_id]);
        } else {
            echo json_encode(['error' => 'Order Placing Failed. Try Again']);
        }
    } else {
        echo json_encode([
            'error' => 'Invalid params to place order',
            'address_set' => isset($purchaseDoc->selectedAddress),
            'payment_set' => isset($purchaseDoc->selectedPayment),
            'PID_set' => isset($purchaseDoc->PID),
            'cart_set' => isset($_POST["cart"]),
            'method' => $_SERVER["REQUEST_METHOD"]
        ]);
    }
} else {
    echo json_encode(['error' => 'Not Authorized to Place Order']);
}
exit;
