<?php
session_start();
include "../Common.php";
$loginDetails = [
    'phone' => $_POST['PHONE'],      // Extract 'phone' input from POST form
    'password'    => $_POST['PASSWORD']    // Extract 'password' input from POST form
];
$api = (new ApiBuilder())->init()
    ->setMethod("POST")
    ->setPath("/login")
    ->setRequestBody($loginDetails)
    ->execute();
$response = $api->getResponse();
$_SESSION['authToken'] = $response->authToken;
?>


