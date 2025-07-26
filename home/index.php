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
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="../scripts.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .category-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #222;
            border-left: 5px solid #32CD32;
            padding-left: 10px;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.08);
        }

        .category-img {
            width: 100%;
            max-width: 120px;
            height: auto;
            margin: 0 auto 10px;
            border-radius: 12px;
            object-fit: cover;
        }

        .category-name {
            font-weight: 600;
            font-size: 1rem;
            color: #444;
            margin-top: 0.5rem;
        }

        .animated-inline-banner {
            overflow: hidden;
            margin-top: 10px;
            border-radius: 16px;
        }

        .animated-inline-banner img {
            width: 100%;
            border-radius: 16px;
            animation: pulse infinite 6s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }
    </style>
</head>

<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>

<!-- Banner -->
<div class="container animated-inline-banner my-4" data-aos="fade-in">
    <img src="../images/animated_grocery_banner.gif" alt="Animated Grocery and Kitchen Banner" />
</div>

<!-- Category Sections -->
<?php foreach ($all_categories as $category => $products) { ?>
    <div class="category container my-5">
        <h5 class="category-title" data-aos="fade-right"><?= htmlspecialchars($category) ?></h5>
        <div class="row g-4">
            <?php foreach ($products as $product) { ?>
                <div class="col-6 col-md-4 col-lg-3" data-aos="zoom-in">
                    <div class="category-card text-center" onclick="window.location.href='../category/index.php?category=<?= urlencode($product->category) ?>'">
                        <img src="https://via.placeholder.com/150" class="category-img" alt="<?= htmlspecialchars($product->category) ?>" />
                        <div class="category-name"><?= htmlspecialchars($product->category) ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<div id="page_footer"><?php include '../components/footer.html'; ?></div>

<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
</body>
</html>
