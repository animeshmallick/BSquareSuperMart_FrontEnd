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
    <script src="../components/headerScript.js"></script>
</head>
<body>
<div id="page_header"></div>
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
<div id="page_footer"></div>
<script>
    //AOS.init()
    fetch('../components/header.php')
        .then(res => res.text())
        .then(data => {
            document.getElementById('page_header').innerHTML = data
            document.getElementById('hamburgerToggle').addEventListener('click', () => {
                document.getElementById('sideNav').classList.add('active');
            });
            document.getElementById('closeNav').addEventListener('click', () => {
                document.getElementById('sideNav').classList.remove('active');
            });
        })
        .catch(err => console.log(err));

    fetch('../components/footer.html')
        .then(res => res.text())
        .then(data => document.getElementById('page_footer').innerHTML = data)
        .catch(err => console.log(err));
</script>
<script src="../Config.js"></script>
<script src="script.js"></script>
<script src="../scripts.js"></script>
</body>
</html>