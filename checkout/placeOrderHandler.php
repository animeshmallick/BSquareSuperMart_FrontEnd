<?php
session_start();
include '../Common.php';
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
if($isLoggedIn) {
    if (isset($_SESSION["purchase_doc"]->selectedAddress) && isset($_SESSION["purchase_doc"]->selectedPayment) && isset($_SESSION["purchase_doc"]->PID) && isset($_POST["cart"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $cart = json_decode($_POST["cart"], true);
        $purchaseID = $_SESSION['purchase_doc']->PID;
        $address = $_SESSION['purchase_doc']->selectedAddress;
        $payment = $_SESSION['purchase_doc']->selectedPayment;
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
    }else{
        echo json_encode(['error' => 'Invalid params to place order']);
    }
}else{
    echo json_encode(['error' => 'Not Authorized to Place Order']);
}
exit();
?>
