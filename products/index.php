<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/> <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <script src="script.js" defer></script> <script src="../scripts.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
</head>
<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>

<div class="container py-4" id="productDetails" data-aos="fade-up">
    <div class="row g-4 align-items-start">
        <div class="col-md-5">
            <img class="product-image img-fluid rounded shadow-sm" id="productImage" alt="Product Image">
        </div>
        <div class="col-md-7">
            <div class="rating mb-2">
                <span>⭐⭐⭐⭐⭐</span> <span class="text-muted">(2224)</span>
            </div>
            <h2 id="productName" class="fw-bold mb-3"></h2>
            <div class="product-pricing mb-3">
                <div id="productMrp" class="text-muted"></div>
                <div id="productPrice" class="fs-4 fw-semibold text-success"></div>
                <div id="productSize" class="text-secondary"></div>
            </div>
            <div class="addProduct mt-4"></div>
        </div>
    </div>

    <div class="product-description mt-5">
        <h4 class="mb-3">About the Product</h4>
        <div class="section-content" id="productDescription"><p></p></div>
    </div>
</div>

<div class="container mt-5" data-aos="fade-up">
    <h4 class="mb-3">Similar Products</h4>
    <div class="row g-4" id="similarProductsList"></div>
</div>

<div id="page_footer"><?php include '../components/footer.html'; ?></div>

<script>
    AOS.init({ duration: 800, once: true });
</script>
</body>
</html>