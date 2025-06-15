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

    </div>
     <div class="wrapper">
        <div class="sidebar" id="sidebarList">

        </div>
        <div class="content" id="content">
            <div class="row" id="productList">

            </div>
        </div>

     </div>
</div>
<div class="cart-bar" id="cartBar" style="display: none;">
    <div><span id="cartItemsCount"></span><span> items in cart</div>
    <a href="../cart" class="btn btn-primary">Go to Cart</a>
</div>
<div id="productModal" class="modal" style="display: none;">
    <div class="modal-content">
        <button class="close-icon"><b>×</b></button>
        <iframe id="modal-iframe" src="" width="100%" height="500" style="border: none;"></iframe>
    </div>
</div>
</body>
</html>
