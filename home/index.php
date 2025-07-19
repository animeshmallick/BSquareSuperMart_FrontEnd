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
    <link rel="stylesheet" href="../styles.css">
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <script src="../Config.js"></script>
    <script src="../components/headerScript.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
</head>
<body>

<div id="page_header"></div>
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
            <div class="col-6 col-md-4 col-lg-3" data-aos="zoom-in" onclick="window.location.href='../category/index.php?category=<?= $product->category ?>'">
                <div class="category-card text-center">
                    <img src="https://via.placeholder.com/150" class="category-img" alt="Grocery">
                    <div class="category-name"><?= $product->category ?></div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<div id="page_footer"></div>
</body>
</html>