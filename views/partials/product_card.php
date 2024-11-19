<?php
$image = $product['image'];
$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
?>
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>" class="w-full h-48 object-cover" />
    <div class="p-4">
        <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($name) ?></h3>
        <p class="text-gray-600 mb-4">
            <?= htmlspecialchars($description) ?>
        </p>
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-primary">$<?= htmlspecialchars($price) ?></span>
            <button class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                Add to Cart
            </button>
        </div>
    </div>
</div>