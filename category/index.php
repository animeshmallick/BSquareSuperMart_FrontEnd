<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Category</title>
    <link href="style.css" rel="stylesheet"/>
    <script src="script.js"></script>
    <script src="../scripts.js"></script>
</head>
<body>

<div>
    <div class="delivery_header"><h4>Delivery in 7 minutes</h4></div>
     <div class="wrapper">
        <div class="sidebar" id="sidebarList">
            <!-- Dynamic sidebar population  -->
        </div>
        <div class="content" id="content">
            <div class="row" id="productList">
                <!-- Dynamic products will be injected here -->
            </div>
        </div>
     </div>
</div>
<div class="cart-bar">
    <div><span id="cartItemsCount"></span><span> items in cart</div>
    <a href="#" class="btn btn-primary">Go to Cart</a>
</div>

</body>
</html>
