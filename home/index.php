<?php
session_start();
include "../ApiBuilder.php";

$api = (new ApiBuilder())->init()
    ->setMethod('GET')
    ->setPath('/categories')
    ->execute();

$all_categories = $api->getResponse();

$current_hour = (int)date('H');
$greeting = '';
if ($current_hour >= 4 && $current_hour < 12) {
    $greeting = 'Good Morning';
} elseif ($current_hour >= 12 && $current_hour < 16) {
    $greeting = 'Good Afternoon';
} else {
    $greeting = 'Good Evening';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>BSquareSuperMart - Delivery in 15 Minutes</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container-fluid top-bar">
    <div class="d-flex justify-content-between align-items-center">
        <div class="delivery-info">
            <h3 class="animate__animated animate__pulse">
                <?= htmlspecialchars($greeting) ?>, Welcome to <strong>BSquareSuperMart</strong>!
                <small>🚚 Delivery in 15 minutes</small>
            </h3>
            <p id="address" data-bs-toggle="modal" data-bs-target="#addressModal">🏠 HOME - Flat No 2A 009 ▼</p>
        </div>
        <div>
            <a id='openSidebar' href="#" class="d-block link-dark text-decoration-none" data-bs-toggle="offcanvas" data-bs-target="#userMenu" aria-controls="userMenu" aria-expanded="false" aria-label="Toggle user menu">
                <img src="../images/user-icon.png" width="35" class="rounded-circle" alt="User Icon" />
            </a>
        </div>
    </div>
    <div class="mt-3">
        <input type="text" class="form-control search-bar" placeholder="Search for 'sugar', 'bread', etc.">
    </div>
</div>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="userMenu" aria-labelledby="userMenuLabel" aria-hidden="true" inert>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="userMenuLabel">👤 User Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <a class="dropdown-item" href="../index.php">🏠 Home</a>
        <a class="dropdown-item" href="../profile/index.php">👤 My Profile</a>
        <a class="dropdown-item" href="../orders/index.php">📦 My Orders</a>
        <a class="dropdown-item" href="../categories/index.php">🗂️ Categories</a>
        <a class="dropdown-item" href="../cart/index.php">🛒 Cart</a>
        <a class="dropdown-item" href="../aboutus/index.php">ℹ️ About Us</a>
        <hr>
        <a class="dropdown-item text-danger" href="../logout.php">🚪 Logout</a>
    </div>
</div>

<!-- Banner -->
<div class="container animated-inline-banner">
    <img src="../images/animated_grocery_banner.gif" alt="Animated Grocery and Kitchen Banner">
</div>

<!-- Categories Section -->
<div class="container mt-4">
    <?php foreach ($all_categories as $categoryHeader => $categories) { ?>
        <h5 class="category-title animate__animated animate__fadeInLeft"><?= htmlspecialchars($categoryHeader) ?></h5>
        <div class="row g-3">
            <?php foreach ($categories as $category) { ?>
                <div class="col-6 col-md-4 col-lg-3 animate__animated animate__zoomIn">
                    <a href="../category/index.php?category=<?= rawurlencode($category->name) ?>" class="text-decoration-none">
                        <div class="category-card text-center">
                            <img src="<?= $category->image_url ?? 'https://via.placeholder.com/150' ?>" alt="<?= htmlspecialchars($category->name) ?>" class="category-img">
                            <div class="category-name"><?= htmlspecialchars($category->name) ?></div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<!-- Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item address-item" data-address="HOME - Flat No 2A 009">🏠 HOME - Flat No 2A 009</li>
                    <li class="list-group-item address-item" data-address="Office - Block B 302">🏢 Office - Block B 302</li>
                    <li class="list-group-item address-item" data-address="Parent's House - Street 5">🏡 Parent's House - Street 5</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
