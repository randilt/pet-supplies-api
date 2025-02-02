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
        $long_description = isset($product['long_description']) ? htmlspecialchars($product['long_description'], ENT_QUOTES, 'UTF-8') : '';
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

<?php
// if ($productFound) {
//     $title = $title . ' | Pawsome | Premium Pet Supplies</title>';
// } else {
//     $title = 'Product Not Found | Pawsome | Premium Pet Supplies';
// }
if ($productFound) {
    echo '<title>' . $title . ' | Pawsome | Premium Pet Supplies</title>';
} else {
    echo 'Product Not Found | Pawsome | Premium Pet Supplies</title>';
}
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-100 text-gray-900">
    <?php require 'partials/navbar.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <?php if ($productFound): ?>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Product Images -->
                <div class="md:w-1/2">
                    <div class="mb-4">
                        <img id="main-image" src="<?= htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Premium Dog Food" class="w-full h-[28rem] object-cover rounded-lg">
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
                <div id="product-data" data-id="<?php echo $productId; ?>" data-price="<?php echo $price; ?>"
                    data-name="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-image-url="<?php echo htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8'); ?>"
                    data-description="<?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>"
                    style="display: none;"></div>
                <div class="md:w-1/2">
                    <h1 class="text-3xl md:text-5xl font-extralight font-chewy mb-4"><?php echo $title; ?></h1>
                    <p class="text-2xl font-bold text-primary mb-4">
                        LKR <?php echo $price; ?>
                    </p>
                    <p class="text-gray-600 mb-6"><?php echo $description; ?></p>

                    <p>
                        <span
                            class="inline-block px-3 py-1 mb-4 text-sm font-semibold rounded-full <?php echo $in_stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                            <?php echo $in_stock ? 'In Stock' : 'Out of Stock'; ?>
                        </span>
                        <?php if ($stock_qty < 20 && $in_stock): ?>
                            <span
                                class="inline-block px-3 py-1 mb-4 ml-2 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                Low Stock - Hurry Up! Only <?php echo $stock_qty; ?> left
                            </span>
                        <?php endif; ?>
                    </p>
                    <!-- <div class="mb-6">
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
                    </div> -->
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Quantity</h2>
                        <div class="flex items-center space-x-4">
                            <button id="decrease-quantity" <?php echo !$in_stock ? 'disabled' : ''; ?>
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary <?php echo !$in_stock ? 'opacity-50 cursor-not-allowed' : ''; ?>">-</button>
                            <span id="quantity" class="text-xl font-semibold"><?php echo !$in_stock ? '0' : '1'; ?></span>
                            <button id="increase-quantity" <?php echo !$in_stock ? 'disabled' : ''; ?>
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary <?php echo !$in_stock ? 'opacity-50 cursor-not-allowed' : ''; ?>">+</button>
                        </div>
                        <?php if ($in_stock): ?>
                            <input type="hidden" id="max-quantity" value="<?php echo $stock_qty; ?>">
                        <?php endif; ?>
                        <input type="hidden" id="max-quantity" value="<?php echo $in_stock ? $stock_qty : 0; ?>">
                    </div>
                    <button id="add-to-cart"
                        class="w-full bg-accent text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300">Add
                        to Cart</button>
                </div>
            </div>
            <!-- Product Description -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-4">Product Description</h2>
                <p class="text-gray-600 mb-4"><?php echo nl2br($long_description); ?></p>
            </div>
            <!-- Related Products -->
            <?php #require 'partials/related_products.php'; ?>
        <?php else: ?>
            <?php require 'partials/product_not_found.php'; ?>
        <?php endif; ?>
    </main>
    <?php require 'partials/footer.php'; ?>
    <script src="assets/js/product-detail.js"></script>

</body>

</html>