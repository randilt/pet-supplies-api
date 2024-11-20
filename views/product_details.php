<?php
require_once 'functions.php';

// Get the product ID from URL parameters
$productId = isset($_GET['id']) ? intval($_GET['id']) : null;
$productFound = false;

if ($productId) {
    // Fetch the product using the ID from URL
    $productJson = fetchProductsById($productId);

    // Decode the JSON into an array
    $productData = json_decode($productJson, true);

    // Check if decoding was successful and product exists
    if (isset($productData['product'])) {
        $product = $productData['product']; // Extract the 'product' key
        $title = htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8');
        $description = $product['description'];
        $price = htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8');
        $img_url = $product['image_url'];
        $long_description = htmlspecialchars($product['long_description'], ENT_QUOTES, 'UTF-8');
        $stock_qty = $product['stock_quantity'];
        $category_id = $product['category_id'];
        $category_name = $product['category_name'];
        $variants = $product['variants'];

        $in_stock = $stock_qty > 0;

        // $stock_qty < 20 ? $stock_status = 'bg-red-500' : $stock_status = 'bg-green-500';

        $productFound = true;
    }
}

// If product is not found, set 404 status code
if (!$productFound) {
    http_response_code(404);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productFound ? $title : 'Product Not Found'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100 text-gray-900">
    <?php require 'partials/navbar.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <?php if ($productFound): ?>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Product Images -->
                <div class="md:w-1/2">
                    <div class="mb-4">
                        <img id="main-image" src="<?= htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Premium Dog Food" class="w-full h-96 object-cover rounded-lg">
                    </div>
                    <!-- <div class="flex space-x-4">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Premium Dog Food" class="w-24 h-24 object-cover rounded-lg cursor-pointer thumbnail">
                        <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc119?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Premium Dog Food Ingredients"
                            class="w-24 h-24 object-cover rounded-lg cursor-pointer thumbnail">
                        <img src="https://images.unsplash.com/photo-1602584386319-fa8eb4361939?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80"
                            alt="Dog enjoying food" class="w-24 h-24 object-cover rounded-lg cursor-pointer thumbnail">
                    </div> -->
                </div>
                <!-- Product Details -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold mb-4"><?php echo $title; ?></h1>
                    <p class="text-2xl font-bold text-primary mb-4">
                        LKR <?php echo $price; ?>
                    </p>
                    <p class="text-gray-600 mb-6"><?php echo $description; ?></p>

                    <p>
                        <span
                            class="inline-block px-3 py-1 mb-4 text-sm font-semibold rounded-full <?php echo $in_stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                            <?php echo $in_stock ? 'In Stock' : 'Out of Stock'; ?>
                        </span>
                    </p>
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Size</h2>
                        <div class="flex space-x-4">
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-md hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary">5
                                lbs</button>
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-md hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary">10
                                lbs</button>
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-md hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary">20
                                lbs</button>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Quantity</h2>
                        <div class="flex items-center space-x-4">
                            <button id="decrease-quantity"
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary">-</button>
                            <span id="quantity" class="text-xl font-semibold">1</span>
                            <button id="increase-quantity"
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary">+</button>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300">Add
                        to Cart</button>
                </div>
            </div>
            <!-- Product Description -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-4">Product Description</h2>
                <p class="text-gray-600 mb-4"><?php echo $long_description; ?></p>
            </div>
            <!-- Related Products -->
            <?php require 'partials/related_products.php'; ?>
        <?php else: ?>
            <?php require 'partials/product_not_found.php'; ?>
        <?php endif; ?>
    </main>
    <?php require 'partials/footer.php'; ?>
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        // Quantity controls
        const decreaseButton = document.getElementById('decrease-quantity');
        const increaseButton = document.getElementById('increase-quantity');
        const quantityElement = document.getElementById('quantity');
        let quantity = 1;
        decreaseButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityElement.textContent = quantity;
            }
        });
        increaseButton.addEventListener('click', () => {
            quantity++;
            quantityElement.textContent = quantity;
        });
        // Thumbnail image click handlers
        const mainImage = document.getElementById('main-image');
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                mainImage.src = thumbnail.src;
            });
        });
    </script>
</body>

</html>