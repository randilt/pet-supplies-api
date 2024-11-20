<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl text-primary font-bold">Recent Products</h2>
            <a href="./products"
                class="bg-accent text-white px-6 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                View All Products
            </a>
        </div>

        <?php
        // Fetch 4 most recent products
        require_once 'functions.php';
        $recentProducts = fetchProducts(null, null, null, null, 4);

        if (empty($recentProducts)): ?>
            <div class="text-center p-8">
                <p class="text-gray-600">No products available at the moment. Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($recentProducts as $product):
                    $imageUrl = !empty($product['image_url']) ? $product['image_url'] : './assets/images/default-placeholder.webp';
                    $name = $product['name'];
                    $description = $product['description'];
                    $price = $product['price'];
                    $productUrl = './product?id=' . $product['id'];
                    ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
                        <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($name) ?>"
                            class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <a href="<?= htmlspecialchars($productUrl) ?>" class="hover:no-underline">
                                <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($name) ?></h3>
                                <p class="text-gray-600 mb-4">
                                    <?= htmlspecialchars($description) ?>
                                </p>
                            </a>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">LKR <?= htmlspecialchars($price) ?></span>
                                <button
                                    class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-80 transition duration-300">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>