<?php
session_start();
include "../ApiBuilder.php";
$loginDetails = [
    'phone' => $_POST['PHONE'],      // Extract 'phone' input from POST form
    'password'    => $_POST['PASSWORD']    // Extract 'password' input from POST form
];
$redirect = $_POST['redirect'] ?? null;
$api = (new ApiBuilder())->init()
    ->setMethod("POST")
    ->setPath("/login")
    ->setRequestBody($loginDetails)
    ->execute();
$response = $api->getResponse();
$_SESSION['authToken'] = $response->authToken;
if ($redirect == null)
    header("Location: /Bsquaresupermart/home/");
else
    header("Location: /Bsquaresupermart/" . $redirect . "/");
?>


