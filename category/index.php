<?php
include "../Common.php";
include "../ApiBuilder.php";
$category_param = $_GET['category'] ?? null;
$path = "/category/".$category_param;
$api = (new ApiBuilder())->init()
    ->setMethod("GET")
    ->setPath($path)
    ->execute();
$category_products = $api->getResponse();
$subcategories = array_keys(get_object_vars($category_products));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Category</title>
    <link href="style.css" rel="stylesheet"/>
    <link href="../styles.css" rel="stylesheet"/>
    <script src="../Config.js"></script>
    <script src="../scripts.js"></script>
    <script src="script.js"></script>
</head>
<body>

<div class="page-container">
    <div class="category-header" id="categoryHeader" style="flex-direction: row">
        <button class="back-button" onclick="handleBackButton()">←</button>
        <h2><?= $category_param ?></h2>
    </div>
     <div class="wrapper">
        <div class="sidebar" id="sidebarList">
            <?php foreach($subcategories as $subcategory){ ?>
                <div class="sidebar-subcategory-item" id="<?= $subcategory ?>" onclick="displayProductsForSubcategory('<?= $subcategory ?>')">
                    <img src="https://via.placeholder.com/30" alt="<?= $subcategory ?>"> <h6><?= $subcategory ?></h6>
                </div>
            <?php }?>
        </div>
        <div class="content" id="content">
            <div class="row" id="productList">
                <?php foreach($category_products as $subcategory_products => $products){ ?>
                    <?php foreach($products as $product){ ?>
                        <div class="product-outer-container" style="display: none" subcategory="<?= $subcategory_products ?>">
                            <div class="image-quantity">
                            <img src="<?= $product->productImg ?>" class="square-image" alt="<?= $product->productName ?>">
                                <div>
                                    <div><?= $product->productSize ?> </div>
                                    <div><strong>MRP ₹<?= $product->productPrice ?></strong> <s>₹<?= $product->productMrp ?></s></div>
                                </div>
                                <div id="addProduct_<?= $product->productId ?>">
                                    <script>addProductQuantityContainer(<?= $product->productId ?>);</script>
                                </div>
                            </div>
                            <div>
                                <h5 class="productDescription"><?= $product->productName ?></h5>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
         <script>
             displayProductsForSubcategory('<?= $subcategories[0] ?>')
         </script>
     </div>
</div>
<div class="cart-bar">
    <div><span id="cartItemsCount"></span><span> items in cart</div>
    <a href="../cart" class="btn btn-primary">Go to Cart</a>
</div>

</body>
</html>
