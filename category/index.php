<!-- index.php (modernized layout with dynamic backend config) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSquareSuperMart Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../home/style.css">
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0/dist/fuse.min.js"></script>
    <link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page_header"><?php include '../components/header.php'; ?></div>
<div class="wrapper">
    <div class="category_header">Category : <span id="categoryHeader"></span></div>
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
<div id="page_footer"><?php include '../components/footer.html'; ?></div>
<script src="../Config.js"></script>
<script src="script.js"></script>
<script src="../scripts.js"></script>
</body>
</html>