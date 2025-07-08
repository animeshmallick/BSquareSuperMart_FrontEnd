<?php
session_start();
include '../Common.php';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cart"])){
    $cart = $_POST["cart"];
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
            "x-authorization" => "Bearer ".$_SESSION['authToken']
        ])
        ->setRequestBody($requestBody)
        ->execute();
    if($api->getStatusCode() == 201 && $api->getResponse()->signed) {
        header("Location: ../thankyou/index.php?PID=".$api->getResponse()->purchase_id);
    }else{
        header("Location: placeOrderFailed.php");
    }
    exit();
}
?>
