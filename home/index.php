<?php
session_start();
include "../ApiBuilder.php";

$api = (new ApiBuilder())->init()
    ->setMethod('GET')
    ->setPath('/categories')
    ->execute();

$all_categories = $api->getResponse();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>BSquareSuperMart - Delivery in 15 Minutes</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <script src="../Config.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="top-bar d-flex justify-content-between align-items-center">
    <div class="delivery-info">
        <h3 class="animate__animated animate__fadeInDown">Welcome to <strong>BSquareSuperMart</strong>!</h3>
    </div>
    <button class="hamburger-btn" id="hamburgerToggle">
        <span></span><span></span><span></span>
    </button>
</div>

<div class="mt-4 px-3">
    <input type="text" class="form-control search-bar animate__animated animate__zoomIn" placeholder="Search for 'sugar', 'bread', etc."/>
    <div id="searchResults" class="dropdown-menu" style="width: 90%; position: absolute; z-index: 1000;"></div>
</div>

<!-- Custom Side Navigation -->
<div class="side-nav animate__animated animate__fadeInLeft" id="sideNav">
    <div class="d-flex justify-content-between align-items-center">
        <h4>📂 Menu</h4>
        <button class="btn-close btn-close-white" id="closeNav"></button>
    </div>
    <ul>
        <li><a href="index.php">🏠 Home</a></li>
        <li><a href="#">👤 Profile</a></li>
        <li><a href="#">📦 Orders</a></li>
        <li><a href="../cart">🛒 Cart</a></li>
        <li><a href="#">ℹ About Us</a></li>
        <li><a href="../logout.php" class="text-danger">🚪 Logout</a></li>
    </ul>
</div>

<!-- Banner -->
<div style="max-height: 25%" class="container animated-inline-banner">
    <img src="../images/animated_grocery_banner.gif" alt="Animated Grocery and Kitchen Banner"/>
</div>

<?php
foreach ($all_categories as $category => $value) { ?>
    <div class="container mt-5">
    <h5 class="category-title" data-aos="fade-right"><?= $category ?></h5>
    <div class="row g-3">
        <?php foreach ($value as $product) { ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="zoom-in">
                <div class="category-card text-center">
                    <img src="https://via.placeholder.com/150" class="category-img" alt="Grocery">
                    <div class="category-name">Grocery</div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<footer>
    <h5>BSquareSuperMart</h5>
    <p>&copy; 2025 All rights reserved.</p>
    <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();

    // Toggle side nav
    document.getElementById('hamburgerToggle').addEventListener('click', () => {
        document.getElementById('sideNav').classList.add('active');
    });
    document.getElementById('closeNav').addEventListener('click', () => {
        document.getElementById('sideNav').classList.remove('active');
    });

    // Handle address selection
    document.querySelectorAll('.address-item').forEach(item => {
        item.addEventListener('click', function () {
            const address = this.textContent.trim();
            document.getElementById('address').textContent = address + ' ▼';
            const modal = bootstrap.Modal.getInstance(document.getElementById('addressModal'));
            modal.hide();
        });
    });
</script>
</body>
</html>