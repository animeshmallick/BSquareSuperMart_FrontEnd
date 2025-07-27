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

        /* Modern Square Popup Banner */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            position: relative;
            width: 400px;
            height: 400px;
            overflow: hidden;
            transform: scale(0.8) rotate(-10deg);
            opacity: 0;
            transition: transform 0.5s ease, opacity 0.5s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: popupBounce 0.6s ease forwards;
        }

        .popup-overlay.active .popup-content {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }

        @keyframes popupBounce {
            0% {
                transform: scale(0.8) rotate(-10deg);
                opacity: 0;
            }
            60% {
                transform: scale(1.05) rotate(2deg);
                opacity: 1;
            }
            100% {
                transform: scale(1) rotate(0);
            }
        }

        .popup-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            z-index: 1010;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .popup-close:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .animated-banner-img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 12px;
            object-fit: contain;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @media (max-width: 500px) {
            .popup-content {
                width: 300px;
                height: 300px;
            }
        }
    </style>
</head>

<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>

<!-- Pop-up Banner -->
<div id="animatedBannerPopup" class="popup-overlay">
    <div class="popup-content">
        <span class="popup-close" onclick="closeBannerPopup()">&times;</span>
        <img src="../images/animated_grocery_banner.gif" class="animated-banner-img" alt="Animated Grocery and Kitchen Banner" />
    </div>
</div>

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

    // Show the pop-up when the page loads
    window.onload = function () {
        document.getElementById('animatedBannerPopup').classList.add('active');
    };

    function closeBannerPopup() {
        document.getElementById('animatedBannerPopup').classList.remove('active');
    }
</script>
</body>
</html>
