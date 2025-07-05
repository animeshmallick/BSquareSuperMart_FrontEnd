<!-- index.php (modernized layout with dynamic backend config) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSquareSuperMart Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <div id="categoryHeader" class="category-header"></div>
    <div style="display: flex" class="content">
        <div id="sidebarList" class="sidebar"></div>
        <div id="productList" style="padding: 0.25rem"></div>
    </div>
</div>
<!-- Cart Footer Bar -->
<div id="cartBar" class="cart-bar" style="display: none;">
    <div class="cart-bar-content">
        <span id="cartItemsCount" class="cart-count">0</span> items in cart
        <button class="btn view-cart-btn" onclick="goToCart()">View Cart</button>
    </div>
</div>


<!-- Modal -->
<div id="productModal" class="modal" style="display:none">
    <div class="modal-content">
        <button class="close-icon close">&times;</button>
        <iframe id="modal-iframe" width="100%" height="500px" frameborder="0"></iframe>
    </div>
</div>

<script src="../Config.js"></script>
<script src="script.js"></script>
<script src="../scripts.js"></script>
</body>
</html>