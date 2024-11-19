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
                <p class="text-gray-600 mb-4">Our Premium Dog Food is crafted with care to provide your furry friend with
                    the best nutrition possible. Made with high-quality ingredients, this food is designed to support your
                    dog's overall health and well-being.</p>
                <ul class="list-disc list-inside text-gray-600 mb-4">
                    <li>Made with real meat as the first ingredient</li>
                    <li>Contains a blend of fruits and vegetables for essential vitamins and minerals</li>
                    <li>No artificial preservatives, colors, or flavors</li>
                    <li>Supports healthy digestion with added probiotics</li>
                    <li>Promotes a shiny coat and healthy skin with Omega-3 and Omega-6 fatty acids</li>
                </ul>
                <p class="text-gray-600">Suitable for adult dogs of all breeds and sizes, this premium dog food will keep
                    your canine companion happy, healthy, and full of energy.</p>
            </div>
            <!-- Related Products -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1545249390-6bdfa286032f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Interactive Cat Toy" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">Interactive Cat Toy</h3>
                            <p class="text-gray-600 mb-4">Keep your feline friend entertained for hours</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">$12.99</span>
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">Add
                                    to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Durable Dog Leash" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">Durable Dog Leash</h3>
                            <p class="text-gray-600 mb-4">Strong and comfortable for daily walks</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">$19.99</span>
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">Add
                                    to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1535294435445-d7249524ef2e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Pet Grooming Kit" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">Pet Grooming Kit</h3>
                            <p class="text-gray-600 mb-4">Complete set for home grooming needs</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">$34.99</span>
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">Add
                                    to Cart</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Pet Bed" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">Luxury Pet Bed</h3>
                            <p class="text-gray-600 mb-4">Comfortable and stylish rest for pets</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">$49.99</span>
                                <button
                                    class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">Add
                                    to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-16">
                <h1 class="text-4xl font-bold mb-4">404 - Product Not Found</h1>
                <p class="text-xl text-gray-600 mb-8">We're sorry, but the product you're looking for doesn't exist or has
                    been removed.</p>
                <a href="./products"
                    class="bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300">Return to
                    All Products</a>
            </div>
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