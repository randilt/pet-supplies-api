<?php if (empty($products)): ?>
    <div class="text-center p-8">
        <p class="text-gray-600">Sorry, no products available. Please check back later or reset your filters.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($products as $product): ?>
            <?php
            // Default placeholder image if image_url is missing or empty
            $imageUrl = !empty($product['image_url']) ? $product['image_url'] : './assets/images/default-placeholder.webp';
            $name = $product['name'];
            $description = $product['description'];
            $price = $product['price'];
            $productUrl = './product?id=' . $product['id'];
            $stockStatus = $product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock';
            ?>

            <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($name) ?>"
                    class="w-full h-48 object-cover" />
                <div
                    class="absolute top-2 right-2 <?= $product['stock_quantity'] > 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' ?> text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    <?= htmlspecialchars($stockStatus) ?>
                </div>
                <div class="p-4">
                    <a href="<?= htmlspecialchars($productUrl) ?>" class="hover:no-underline">
                        <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($name) ?></h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            <?= htmlspecialchars($description) ?>
                        </p>
                    </a>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-primary">LKR <?= htmlspecialchars($price) ?></span>
                        <a href="<?= htmlspecialchars($productUrl) ?>"
                            class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>