<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken']) ?? null;
$redirect = $_POST['redirect'] ?? null;
$addr_line1 = $_POST['address_line1'];
$addr_line2 = $_POST['address_line2'];
$address = new StdClass();
$address->address_line1 = $addr_line1;
$address->address_line2 = $addr_line2;

$api = (new ApiBuilder())
    ->init()
    ->setMethod('POST')
    ->setHeaders([
        "x-authorization" => "Bearer " . $_SESSION['authToken']
    ])
    ->setRequestBody($address)
    ->execute();
if ($api->getStatusCode() == 201 && isset($api->getResponse()->success)){
    if($redirect !== null) {
        header("Location: ../".$redirect."/");
    }else{
        header("Location: ../home/");
    }
}else{
    header("Location: index.php?error=" .$api->getResponse()->error);
}


