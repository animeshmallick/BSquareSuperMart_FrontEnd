<?php
session_start();
include "../Common.php";
$common = new Common();
$isLoggedIn = $common->is_user_logged_in($_SESSION['authToken'] ?? null);
$authToken = $_SESSION['authToken'] ?? null;
$purchaseDoc = $_SESSION['purchase_doc'] ?? null;
$selectedAddress = $purchaseDoc->selectedAddress ?? null;
$selectedPayment = $purchaseDoc->selectedPayment ?? null;

if(!isset($_SESSION['purchase_doc'])) {
    $purchaseDoc = new stdClass();
    $api = (new ApiBuilder())
        ->init()
        ->setMethod('GET')
        ->setPath("/getPurchaseID")
        ->setHeaders([
            "x-authorization" => "Bearer " . $authToken
        ])
        ->execute();
    $purchaseIDObj = $api->getResponse();
    $purchaseID = $purchaseIDObj->purchaseID?? null;
    $purchaseDoc->PID = $purchaseID;
    $_SESSION['purchase_doc'] = $purchaseDoc;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['address']) || isset($_POST['payment'])) && $isLoggedIn) {
    if(isset($_POST['address'])){
        $purchaseDoc = $_SESSION['purchase_doc'];
        $purchaseDoc->selectedAddress = json_decode($_POST['address']);
        $_SESSION['purchase_doc'] = $purchaseDoc;
    }else{
        $purchaseDoc = $_SESSION['purchase_doc'];
        $purchaseDoc->selectedPayment = json_decode($_POST['payment']);
        $_SESSION['purchase_doc'] = $purchaseDoc;
    }
    // Redirect back to this page with GET to avoid form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if($isLoggedIn && $_SERVER["REQUEST_METHOD"] ==="GET"){
    if(!$selectedAddress || (isset($_GET['change']) && $_GET['change'] == "address")) {
        unset($_SESSION['purchase_doc']->selectedAddress);
        $api = (new ApiBuilder())
            ->init()
            ->setMethod('GET')
            ->setPath("/getUserAddresses")
            ->setHeaders([
                "x-authorization" => "Bearer " . $authToken
            ])
            ->execute();
        $userAddresses = $api->getResponse();?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Checkout - Animated</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
            <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
            <style>
                .radio-card input[type="radio"]:checked + .content {
                    border-color: #2563eb;
                    background: linear-gradient(to bottom right, #e0f2fe, #f0f9ff);
                    transform: scale(1.02);
                    box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
                    animation: pulse 0.4s ease-out;
                }
                .radio-card .content {
                    transition: all 0.3s ease;
                }
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.025); }
                    100% { transform: scale(1.02); }
                }
                .ripple::after {
                    content: "";
                    position: absolute;
                    border-radius: 9999px;
                    width: 120px;
                    height: 120px;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    opacity: 0;
                }
                @keyframes ripple {
                    0% { transform: scale(0); opacity: 0.7; }
                    100% { transform: scale(2.5); opacity: 0; }
                }
            </style>
        </head>
        <body class="bg-gradient-to-br from-sky-100 via-white to-blue-50 min-h-screen font-sans text-gray-900">
        <div class="max-w-4xl mx-auto px-6 py-10">
            <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-3xl shadow-2xl p-8" data-aos="fade-up" data-aos-duration="900">
                <h2 class="text-4xl font-bold text-blue-700 mb-8 tracking-tight" data-aos="fade-down">🚚 Step 1: Choose Delivery Address</h2>
                <form method="POST" action="../checkout/index.php" class="space-y-6">
                    <?php foreach ($userAddresses->userAddress as $index => $address):
                        $isSelected = ($selectedAddress && $selectedAddress->address_id == $address->address_id); ?>
                        <label class="radio-card block" data-aos="zoom-in-up" data-aos-delay="<?= $index * 100 ?>">
                            <input type="radio" name="address" value="<?= htmlspecialchars(json_encode($address)) ?>" class="hidden" <?= $isSelected ? 'checked' : '' ?>>
                            <div class="content border-2 <?= $isSelected ? 'border-blue-500' : 'border-gray-300' ?> rounded-xl p-5 bg-white shadow-md hover:shadow-blue-200 hover:border-blue-400 transition-all duration-300 hover:scale-[1.015] cursor-pointer">
                                <p class="font-semibold text-lg text-blue-900"><?= htmlspecialchars($address->addr_line1) ?></p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($address->addr_line2) ?></p>
                            </div>
                        </label>
                    <?php endforeach; ?>
                    <div class="flex flex-wrap justify-between gap-4 mt-10">
                        <button type="button" onclick="window.location.href='../addAddress/index.php?redirect=checkout'" class="relative px-6 py-2 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-semibold rounded-xl shadow transition-all duration-300 overflow-hidden ripple">
                            ➕ Add New Address
                        </button>
                        <button type="submit" class="relative px-8 py-3 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold rounded-full shadow-lg transition-transform transform hover:scale-105 overflow-hidden ripple">
                            <?= $selectedPayment ? "🧾 Order Summary" : "💳 Proceed to Payment" ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            AOS.init();

            // Ripple effect
            document.querySelectorAll('.ripple').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    ripple.style.left = `${e.clientX - this.getBoundingClientRect().left - 60}px`;
                    ripple.style.top = `${e.clientY - this.getBoundingClientRect().top - 60}px`;
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        </script>
        </body>
        </html>

    <?php }elseif(!$selectedPayment|| (isset($_GET['change']) && $_GET['change'] == "payment")){
        $api = (new ApiBuilder())
            ->init()
            ->setMethod('GET')
            ->setPath("/getPaymentMethod")
            ->setHeaders([
                "x-authorization" => "Bearer " . $authToken
            ])
            ->execute();
        $paymentMethods = $api->getResponse(); ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <title>Checkout - Payment</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
            <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
            <style>
                .radio-card input[type="radio"]:checked + .content {
                    border-color: #2563eb;
                    background: linear-gradient(to bottom right, #e0f2fe, #f0f9ff);
                    transform: scale(1.02);
                    box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
                    animation: pulse 0.4s ease-out;
                }
                .radio-card .content {
                    transition: all 0.3s ease;
                }
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.025); }
                    100% { transform: scale(1.02); }
                }
                .ripple::after {
                    content: "";
                    position: absolute;
                    border-radius: 9999px;
                    width: 120px;
                    height: 120px;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    opacity: 0;
                }
                @keyframes ripple {
                    0% { transform: scale(0); opacity: 0.7; }
                    100% { transform: scale(2.5); opacity: 0; }
                }
            </style>
        </head>
        <body class="bg-gradient-to-br from-blue-50 via-white to-sky-100 min-h-screen font-sans text-gray-900">
        <div class="max-w-4xl mx-auto px-6 py-10">
            <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-3xl shadow-2xl p-8" data-aos="fade-up" data-aos-duration="900">
                <h2 class="text-4xl font-bold text-blue-700 mb-8 tracking-tight" data-aos="fade-down">💳 Step 2: Choose Payment Method</h2>
                <form method="POST" action="../checkout/index.php" class="space-y-6">
                    <?php foreach ($paymentMethods as $index => $paymentMethod):
                        $isSelected = ($selectedPayment && $selectedPayment->id == $paymentMethod->id); ?>
                        <label class="radio-card block" data-aos="zoom-in-up" data-aos-delay="<?= $index * 100 ?>">
                            <input type="radio" name="payment" value="<?= htmlspecialchars(json_encode($paymentMethod)) ?>" class="hidden" <?= $isSelected ? 'checked' : '' ?> required>
                            <div class="content border-2 <?= $isSelected ? 'border-blue-500' : 'border-gray-300' ?> rounded-xl p-5 bg-white shadow-md hover:shadow-blue-200 hover:border-blue-400 transition-all duration-300 hover:scale-[1.015] cursor-pointer">
                                <p class="font-semibold text-lg text-blue-900"><?= htmlspecialchars($paymentMethod->name) ?></p>
                            </div>
                        </label>
                    <?php endforeach; ?>
                    <div class="flex flex-wrap justify-between gap-4 mt-10">
                        <button type="button" onclick="addPayment(event)" class="relative px-6 py-2 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-semibold rounded-xl shadow transition-all duration-300 overflow-hidden ripple">
                            ➕ Add New Payment Method
                        </button>
                        <button type="submit" class="relative px-8 py-3 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold rounded-full shadow-lg transition-transform transform hover:scale-105 overflow-hidden ripple">
                            🧾 Order Summary
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            AOS.init();
            function addPayment(event) {
                event.preventDefault();
                alert("Cannot add a new payment method as of now.");
            }

            // Ripple effect
            document.querySelectorAll('.ripple').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    ripple.style.left = `${e.clientX - this.getBoundingClientRect().left - 60}px`;
                    ripple.style.top = `${e.clientY - this.getBoundingClientRect().top - 60}px`;
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        </script>
        </body>
        </html>

    <?php }else { //SPC Page?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <title>Checkout - Order Summary</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
            <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <style>
                .ripple::after {
                    content: "";
                    position: absolute;
                    border-radius: 9999px;
                    width: 120px;
                    height: 120px;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    opacity: 0;
                }
                @keyframes ripple {
                    0% { transform: scale(0); opacity: 0.8; }
                    100% { transform: scale(2.5); opacity: 0; }
                }
            </style>
        </head>
        <body class="bg-gradient-to-br from-blue-50 via-white to-sky-100 min-h-screen text-gray-900 font-sans">
        <div class="max-w-6xl mx-auto px-6 py-10 space-y-8">
            <!-- Cart Items & Bill Section -->
            <div class="grid md:grid-cols-3 gap-6" data-aos="fade-up">
                <div class="md:col-span-2 bg-white rounded-3xl p-6 shadow-xl">
                    <h2 class="text-2xl font-bold text-blue-700 mb-4">🛒 Your Cart</h2>
                    <div id="cart_items_container" class="space-y-4">
                        <!-- JS will inject cart items here -->
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-xl">
                    <h2 class="text-2xl font-bold text-blue-700 mb-4">💰 Bill Summary</h2>
                    <div class="bill-section-wrapper space-y-2" id="bill_box">
                        <!-- JS will inject billing here -->
                    </div>
                </div>
            </div>

            <!-- Address + Payment Summary -->
            <div class="bg-white rounded-3xl p-6 shadow-xl" data-aos="zoom-in-up">
                <h2 class="text-2xl font-bold text-blue-700 mb-6">📦 Delivery & Payment Info</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded-xl relative">
                        <h3 class="text-lg font-semibold text-blue-800 mb-1">Deliver To:</h3>
                        <p class="text-gray-700"><?= htmlspecialchars($selectedAddress->addr_line1 ?? '') ?>, <?= htmlspecialchars($selectedAddress->addr_line2 ?? '') ?></p>
                        <button class="absolute top-2 right-2 text-sm text-blue-600 underline hover:text-blue-800 transition" onclick="window.location.href='index.php?change=address'">Change</button>
                    </div>
                    <div class="p-4 border-l-4 border-purple-500 bg-purple-50 rounded-xl relative">
                        <h3 class="text-lg font-semibold text-purple-800 mb-1">Payment Method:</h3>
                        <p class="text-gray-700"><?= htmlspecialchars($selectedPayment->name) ?></p>
                        <button class="absolute top-2 right-2 text-sm text-purple-600 underline hover:text-purple-800 transition" onclick="window.location.href='index.php?change=payment'">Change</button>
                    </div>
                </div>
            </div>

            <!-- Place Order Button -->
            <div class="text-center" data-aos="fade-up">
                <form method="POST" action="placeOrderHandler.php">
                    <button onclick="placeOrderHandler();" class="relative px-10 py-4 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 hover:from-blue-700 hover:to-indigo-900 text-white font-bold text-lg rounded-full shadow-xl transition-transform transform hover:scale-105 overflow-hidden ripple">
                        ✅ Place Order
                    </button>
                </form>
            </div>
        </div>

        <script src="../scripts.js"></script>
        <script src="script.js" defer></script>
        <script src="../Config.js"></script>
        <script>
            AOS.init();

            // Ripple effect
            document.querySelectorAll('.ripple').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    ripple.style.left = `${e.clientX - this.getBoundingClientRect().left - 60}px`;
                    ripple.style.top = `${e.clientY - this.getBoundingClientRect().top - 60}px`;
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        </script>
        </body>
        </html>

    <?php } ?>
<?php }else{
    header("Location: ../cart/");
    exit;
} ?>

