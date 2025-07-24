<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page</title>
    <link href="../styles.css" rel="stylesheet"/>
    <script src="script.js"></script>
    <script src="../scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <link href="../styles.css" rel="stylesheet">
</head>
<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>
    <div class="container" id="productDetails">
        <img class="product-image" id="productImage">
        <div class="rating">
            <span>⭐⭐⭐⭐⭐</span>
            <span>(2224)</span>
        </div>
        <h2 id="productName"></h2>
        <div>
            <div id="productMrp"></div>
            <div id="productPrice"></div>
            <div id="productSize"></div>
        </div>

        <div class="addProduct"></div>
        <div class="product-description">
            <div class="productDescriptionTitle"><h3>About the Product</h3></div>
            <div class="section-content" id="productDescription">
                <p></p>
            </div>
        </div>
    </div>
    <h3>Similar products</h3>
    <div class="similar-products" id="similarProductsList">

    </div>
    <div id="page_footer"><?php include '../components/footer.html'; ?></div>
</body>
</html>
