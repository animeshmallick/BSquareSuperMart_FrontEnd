<!-- header.php -->
<!-- Tailwind & Alpine -->
<?php
    $userLoggedIn = $_GET['isLoggedIn'] ?? false;
?>
<script src="../components/headerScript.js"></script>
<script src="../Config.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<header class="sticky top-0 z-50 shadow-md">
    <!-- Top Header -->
    <div class="bg-gradient-to-r from-lime-500 to-emerald-500 text-white">
        <div class="flex items-center justify-between px-2 md:px-8 py-2">
            <!-- Logo + Brand -->
            <div onclick="window.location.href='../home/'" class="flex items-center gap-3 text-2xl font-extrabold tracking-wide animate-fade-in">
                <img src="../components/logo.png" alt="Logo" class="w-10 h-10 rounded-full shadow-md" />
                <span class="drop-shadow-md">BSquareSuperMart</span>
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex gap-6 font-medium text-white animate-slide-in">
                <a href="../home/" class="hover:underline underline-offset-4 transition">Home</a>
                <a href="../cart/" class="hover:underline underline-offset-4 transition">Cart</a>
                <?php if($userLoggedIn) { ?>
                    <a href="../orders/" class="hover:underline underline-offset-4 transition">Orders</a>
                    <a href="../profile/" class="hover:underline underline-offset-4 transition">Profile</a>
                    <a href="../logout.php" class="hover:underline underline-offset-4 transition">Logout</a>
                <?php }else{ ?>
                    <a href="../login/" class="hover:underline underline-offset-4 transition">Login</a>
                <?php } ?>

            </nav>

            <!-- Hamburger (Mobile) -->
            <button id="hamburgerToggle" class="md:hidden flex flex-col justify-center gap-1 animate-pulse">
                <span class="w-6 h-0.5 bg-white rounded"></span>
                <span class="w-6 h-0.5 bg-white rounded"></span>
                <span class="w-6 h-0.5 bg-white rounded"></span>
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="relative px-2 py-2 bg-white shadow-inner animate-fade-in-down">
        <input
                type="text"
                placeholder="🔍 Search for products..."
                class="search-bar w-full px-2 py-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-lime-400 shadow transition-all duration-300"
        />
        <!-- Search Results -->
        <div
                id="searchResults"
                class="absolute left-4 right-4 mt-2 bg-white border rounded-xl shadow-xl z-50 hidden max-h-[300px] overflow-y-auto transition-all duration-300"
        ></div>
    </div>
</header>

<!-- Slide-in SideNav -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[998]"></div>

<div
        id="sideNav"
        class="fixed top-0 left-0 w-72 h-full bg-gradient-to-b from-white to-lime-100 shadow-2xl transform -translate-x-full transition-transform duration-300 z-[999] rounded-tr-3xl rounded-br-3xl"
>
    <div class="flex justify-between items-center px-4 py-4 border-b bg-white rounded-tr-3xl">
        <div class="text-xl font-bold text-lime-600">🍃 Menu</div>
        <button id="closeNav" class="text-2xl font-bold text-gray-500 hover:text-red-500">×</button>
    </div>
    <nav class="flex flex-col gap-4 p-6 text-gray-800 font-medium text-lg">
        <a href="../home/" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
            🏠 <span>Home</span>
        </a>
        <a href="../cart" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
            🛒 <span>Cart</span>
        </a>
        <?php if($userLoggedIn){ ?>
            <a href="../orders" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
                🎁 <span>Orders</span>
            </a>
            <a href="../profile" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
                📞 <span>Profile</span>
            </a>
            <a href="../logout.php" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
                <span>Logout</span>
            </a>
        <?php } else { ?>
            <a href="../login" class="flex items-center gap-3 hover:bg-lime-100 px-3 py-2 rounded transition duration-200">
                <span>Login</span>
            </a>
        <?php } ?>
    </nav>
</div>

<!-- Styles -->
<style>
    #overlay {
        transition: all 0.3s ease-in-out;
        display: none;
    }
    #sideNav {
        transition: transform 0.3s ease-in-out;
        transform: translateX(-100%);
    }
    #sideNav.active {
        transform: translateX(0);
    }

    #overlay.active {
        display: block;
    }

    #searchResults.show {
        display: block;
        animation: fadeIn 0.2s ease-out;
    }

    .search-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: inherit;
        transition: background 0.3s ease;
    }

    .search-dropdown-item:hover {
        background-color: #f3f4f6;
    }

    .search-dropdown-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    .item-info {
        display: flex;
        flex-direction: column;
    }

    .item-name {
        font-weight: 600;
        font-size: 1rem;
    }

    .item-brand {
        font-size: 0.875rem;
        color: #777;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-fade-in-down {
        animation: fadeIn 0.5s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }
</style>

<!-- Script to handle toggle -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sideNav = document.getElementById('sideNav');
        const overlay = document.getElementById('overlay');

        document.getElementById('hamburgerToggle')?.addEventListener('click', () => {
            sideNav.classList.add('active');
            overlay.classList.add('active');
        });

        document.getElementById('closeNav')?.addEventListener('click', () => {
            sideNav.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            console.log('Overlay clicked');
            sideNav.classList.remove('active');
            overlay.classList.remove('active');
        });
    });

</script>
