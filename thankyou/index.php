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
$response = $api->getResponse();

if(!isset($response->purchase_id) || $response->purchase_id != $pid) {
    echo "Invalid Purchase ID";
    exit;
}

// Theming based on status
function getStatusThemeData($status): array {
    $themes = [
        "PLACED" => [
            "emoji" => "📦",
            "color" => "yellow-500",
            "text" => "Your order has been placed!",
            "bg" => "from-yellow-50 via-white to-yellow-100"
        ],
        "CONFIRMED" => [
            "emoji" => "✅",
            "color" => "blue-500",
            "text" => "Order confirmed!",
            "bg" => "from-blue-50 via-white to-blue-100"
        ],
        "PACKAGING_IN_PROGRESS" => [
            "emoji" => "📦",
            "color" => "indigo-500",
            "text" => "Your items are being packed!",
            "bg" => "from-indigo-50 via-white to-indigo-100"
        ],
        "OUT_FOR_DELIVERY" => [
            "emoji" => "🚚",
            "color" => "teal-500",
            "text" => "Your order is on the way!",
            "bg" => "from-teal-50 via-white to-teal-100"
        ],
        "DELIVERED_WITH_PAYMENT_SUCCESS" => [
            "emoji" => "🎉",
            "color" => "green-600",
            "text" => "Delivered successfully!",
            "bg" => "from-green-50 via-white to-green-100"
        ],
        "DELIVERED_WITH_PAYMENT_PENDING" => [
            "emoji" => "⚠️",
            "color" => "orange-500",
            "text" => "Delivered — Payment Pending!",
            "bg" => "from-orange-50 via-white to-orange-100"
        ],
        "CANCELLED" => [
            "emoji" => "❌",
            "color" => "red-500",
            "text" => "Order Cancelled",
            "bg" => "from-red-50 via-white to-red-100"
        ]
    ];
    return $themes[$status] ?? [
        "emoji" => "📄",
        "color" => "gray-500",
        "text" => "Purchase Summary",
        "bg" => "from-gray-50 via-white to-gray-100"
    ];
}
$theme = getStatusThemeData($response->status);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order Summary - Thank You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <link href="../styles.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br <?= $theme['bg'] ?> min-h-screen font-sans text-gray-900">
<div id="page_header"><?php include '../components/header.php'; ?></div>
<div class="max-w-6xl mx-auto px-6 py-10 space-y-10">
    <!-- Header Section -->
    <div class="text-center" data-aos="fade-down">
        <div class="text-6xl mb-2 text-<?= $theme['color'] ?>"><?= $theme['emoji'] ?></div>
        <h1 class="text-4xl font-extrabold text-<?= $theme['color'] ?>"><?= $theme['text'] ?></h1>
        <p class="mt-2 text-lg">Purchase ID:
            <span class="font-mono bg-<?= $theme['color'] ?>/10 text-<?= $theme['color'] ?> px-2 py-1 rounded">
          <?= htmlspecialchars($response->purchase_id) ?>
        </span>
        </p>
        <p class="mt-1 text-sm text-gray-600">Placed on: <?= date("d M Y, h:i A", strtotime($response->purchased_at)) ?></p>
        <p class="mt-2 font-semibold text-<?= $theme['color'] ?>">Status: <?= htmlspecialchars(str_replace('_', ' ', $response->status)) ?></p>
    </div>

    <!-- Address & Payment Info -->
    <div class="grid md:grid-cols-2 gap-6" data-aos="fade-up">
        <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-blue-500">
            <h2 class="text-xl font-semibold text-blue-700 mb-2">📍 Delivery Address</h2>
            <p><?= htmlspecialchars($response->address->address_line_1) ?><br><?= htmlspecialchars($response->address->address_line_2) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-purple-500">
            <h2 class="text-xl font-semibold text-purple-700 mb-2">💳 Payment Method</h2>
            <p><?= htmlspecialchars($response->payment->payment) ?></p>
        </div>
    </div>

    <!-- Products -->
    <div>
        <h3 class="text-2xl font-bold text-blue-700 mb-4" data-aos="fade-right">🛍 Items Ordered</h3>
        <div class="grid md:grid-cols-3 gap-6" data-aos="zoom-in-up">
            <?php foreach ($response->orders as $order):
                $product = $order->product; ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-transform transform hover:scale-105">
                    <div style="display: flex">
                        <div>
                            <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="w-full object-contain bg-gray-100 p-2">
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-lg"><?= htmlspecialchars($product->name) ?></h4>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($product->brand) ?> • <?= htmlspecialchars($product->size) ?></p>
                            <div class="mt-2 text-blue-600 font-bold text-xl">
                                ₹<?= htmlspecialchars($product->selling_price) ?>
                                <span class="text-sm text-gray-400 line-through ml-2">₹<?= htmlspecialchars($product->mrp) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    AOS.init();
</script>
<div id="page_footer"><?php include '../components/footer.html'; ?></div>
</body>
</html>
