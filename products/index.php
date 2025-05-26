<?php
include "../Common.php";
include "../ApiBuilder.php";
$productId_param = $_GET['productId'] ?? null;
$product_path = "/product/".$productId_param;
$product_api = (new ApiBuilder())->init()
    ->setMethod("GET")
    ->setPath($product_path)
    ->execute();
$product = $product_api->getResponse();
$similarProduct_path = "/similarProducts/".$product->productId;
$similarProduct_api = (new ApiBuilder())->init()
    ->setMethod("GET")
    ->setPath($similarProduct_path)
    ->execute();
$similarProducts = $similarProduct_api->getResponse();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page</title>
    <link href="../styles.css" rel="stylesheet"/>
    <script src="../Config.js"></script>
    <script src="script.js"></script>
    <script src="../scripts.js"></script>
</head>
<body>

    <div class="container" id="productDetails">

        <img src="<?= $product->productImg ?>" alt="<?= $product->productName ?>" class="product-image">
        <div class="rating">
            <span>⭐⭐⭐⭐⭐</span>
            <span>(2224)</span>
        </div>
        <h2><?= $product->productName ?></h2>
        <div>
            <div><s>₹<?= $product->productMrp ?></s></div>
            <div>₹<?= $product->productPrice ?></div>
            <div><?= $product->productSize ?></div>
        </div>

        <div id="addProduct_<?= $product->productId ?>">
            <script>addProductQuantityContainer(<?= $product->productId ?>);</script>
        </div>

        <div class="product-description">
            <div class="productDescriptionTitle"><h3>About the Product</h3></div>
            <div class="section-content">
                <p><?= $product->productDescription ?></p>
            </div>
        </div>
    </div>
    <h3>Similar products</h3>
    <div class="similar-products" id="similarProductsList">
        <?php foreach ($similarProducts as $similarProduct){ ?>
            <div class="productTile">
                <img src="<?= $similarProduct->productImg ?>" alt="<?= $similarProduct->productName ?>">
                <div><b><?= $similarProduct->productName ?></b></div>
                <div><?= $similarProduct->productSize ?></div>
                <div style="display: flex; justify-content: space-between">
                    <div>₹ <?= $similarProduct->productPrice ?></div>
                    <div id="addProduct_<?= $similarProduct->productId ?>">
                        <script>addProductQuantityContainer(<?= $similarProduct->productId ?>);</script>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="cart-bar" id="cartBar" style="display: none;">
        <div><span id="cartItemsCount"></span><span> items in cart</div>
        <a href="../cart" class="btn btn-primary">Go to Cart</a>
        <script>updateItemsCountInFooter()</script>
    </div>

</body>
</html>
