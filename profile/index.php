<?php
session_start();
include '../Common.php';
$common = new Common();
if(!$common->is_user_logged_in($_SESSION['authToken'] ?? null)){
    header("Location: ../login/index.php?redirect=profile");
    exit();
}
$api = (new ApiBuilder())
    ->init()
    ->setMethod("GET")
    ->setPath("/getUserProfile")
    ->setHeaders([
        "x-authorization" => "Bearer ".$_SESSION['authToken']
    ])
    ->execute();
$profile = $api->getResponse();
?>
<!-- index.php -->
<!DOCTYPE html>
<html lang="en" class="bg-gradient-to-br from-purple-100 via-white to-blue-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <link href="../styles.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .slide-fade {
            animation: slideFadeIn 0.8s ease-out both;
        }

        @keyframes slideFadeIn {
            0% {
                transform: translateY(40px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .hover-scale:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>
<div class="w-full max-w-md bg-white shadow-2xl rounded-3xl p-8 slide-fade ring-1 ring-gray-200 mt-6">
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-2 animate-pulse">👤 Welcome !!</h2>
        <p class="text-sm text-gray-500">Manage your profile, orders, and settings</p>
    </div>

    <div class="space-y-4 text-center">
        <div>
            <label class="block text-sm text-gray-500">Name</label>
            <div class="text-lg font-semibold text-gray-800"><?= $profile->name ?></div>
        </div>
        <div>
            <label class="block text-sm text-gray-500">Phone</label>
            <div class="text-lg font-semibold text-gray-800"><?= $profile->phone ?></div>
        </div>
    </div>

    <!-- Redirect Buttons -->
    <div class="mt-8 space-y-3">
        <a href="../addressBook/" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 hover-scale text-white font-semibold py-2 rounded-xl shadow transition duration-300">
            📚 View Address Book
        </a>
        <a href="../orders/" class="block w-full text-center bg-green-600 hover:bg-green-700 hover-scale text-white font-semibold py-2 rounded-xl shadow transition duration-300">
            📦 View Your Orders
        </a>
        <a href="/changePassword/" class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 hover-scale text-white font-semibold py-2 rounded-xl shadow transition duration-300">
            🔐 Change Password
        </a>
        <a href="../logout.php" class="block w-full text-center bg-red-500 hover:bg-red-600 hover-scale text-white font-semibold py-2 rounded-xl shadow transition duration-300">
            🚪 Logout
        </a>
    </div>
</div>
<div id="page_footer"><?php include '../components/footer.html'; ?></div>
</body>
</html>
