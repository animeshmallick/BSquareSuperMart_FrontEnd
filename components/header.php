<div class="top-bar justify-content-between align-items-center">
    <div class="d-flex">
        <div class="delivery-info" onclick="window.location.href='../home/index.php';">
            <h3 class="animate__animated animate__fadeInDown">Welcome to <strong>BSquareSuperMart</strong>!</h3>
        </div>
        <button class="hamburger-btn" id="hamburgerToggle">
            <span></span><span></span><span></span>
        </button>
    </div>
    <div class="mt-4 px-3">
        <input type="text" class="form-control search-bar animate__animated animate__zoomIn" placeholder="Search for 'sugar', 'bread', etc."/>
        <div id="searchResults" class="dropdown-menu" style="width: 90%; position: absolute; z-index: 1000;"></div>
    </div>
</div>

<div class="side-nav animate__animated animate__fadeInLeft" id="sideNav">
    <div class="d-flex justify-content-between align-items-center">
        <h4>📂 Menu</h4>
        <button class="btn-close btn-close-white" id="closeNav"></button>
    </div>
    <ul>
        <li><a href="../home/index.php">🏠 Home</a></li>
        <li><a href="#">👤 Profile</a></li>
        <li><a href="#">📦 Orders</a></li>
        <li><a href="../cart">🛒 Cart</a></li>
        <li><a href="#">ℹ About Us</a></li>
        <li><a href="../logout.php" class="text-danger">🚪 Logout</a></li>
    </ul>
</div>
