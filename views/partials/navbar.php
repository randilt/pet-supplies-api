<?php
$menuItems = [
    ['url' => '.', 'text' => 'Home'],
    ['url' => './products', 'text' => 'Products'],
    ['url' => './about', 'text' => 'About'],
    ['url' => './contact', 'text' => 'Contact'],
];
?>

<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="." class="text-2xl font-bold text-primary">Pawsome</a>

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
            <a href="#" class="text-gray-600 hover:text-primary transition" aria-label="Shopping cart">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
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
    </div>
</header>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        console.log('clicked');
        var mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>