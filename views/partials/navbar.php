<?php
$menuItems = [
    ['url' => '.', 'text' => 'Home'],
    ['url' => './products', 'text' => 'Products'],
    ['url' => './subscription', 'text' => 'Pawsome Box'],
    ['url' => './about', 'text' => 'About'],
    ['url' => './contact', 'text' => 'Contact'],
];
?>

<header class="bg-white shadow-sm sticky top-0 z-50 font-nunito">
    <nav class="container mx-auto px-4 py-2 flex justify-between items-center">
        <a href="." class="text-4xl font-chewy font-bold text-gray-800">Pawsome</a>

        <div class="hidden md:flex space-x-6">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?= htmlspecialchars($item['url']) ?>" class="text-gray-600 hover:text-primary transition">
                    <?= htmlspecialchars($item['text']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="hidden md:flex items-center space-x-4">
            <a href="#" class="text-gray-600 hover:text-primary transition" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </a>
            <a href="./cart" class="text-gray-600 hover:text-primary transition relative" aria-label="Shopping cart">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-count"
                    class="absolute -top-2 -right-2 bg-primary text-white w-5 h-5 flex items-center justify-center rounded-full text-xs">0</span>

            </a>
            <a href="./profile" class="text-gray-600 hover:text-primary transition" aria-label="Profile">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </a>
        </div>

        <button id="mobile-menu-button" class="md:hidden focus:outline-none" aria-label="Toggle mobile menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    <div id="mobile-menu" class="hidden md:hidden bg-white">
        <?php foreach ($menuItems as $item): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>" class="block py-2 px-4 text-sm hover:bg-gray-100">
                <?= htmlspecialchars($item['text']) ?>
            </a>
        <?php endforeach; ?>

        <a href="./cart">
            <div class="flex items-center justify-between py-2 px-4 text-sm hover:bg-gray-100">
                <span>Cart</span>
                <span id="cart-count"
                    class="bg-primary text-white w-5 h-5 flex items-center justify-center rounded-full text-xs">0</span>
            </div>
        </a>

        <a href="./profile" class="block py-2 px-4 text-sm hover:bg-gray-100">Profile</a>

    </div>
</header>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        console.log('clicked');
        var mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
    var userCart = JSON.parse(localStorage.getItem('userCart')) || [];
    document.getElementById('cart-count').textContent = userCart.length;
</script>