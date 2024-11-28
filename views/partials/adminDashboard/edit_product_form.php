<?php
require_once 'functions.php';

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID");
}

$product_id = (int) $_GET['id'];

// Fetch product details and categories
$product_result = fetchProductsById($product_id);

if (!$product_result) {
    die("Product not found");
} else {
    $decoded_result = json_decode($product_result, true);
    if (!isset($decoded_result['product'])) {
        echo "<div class='text-center mt-4'>
            <p>Product not found</p>
            <a href='./dashboard?tab=products' class='inline-block bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300'>Go back</a>
              </div>";
        exit;
    }
    $product = $decoded_result['product'];
}
$categories = fetchCategories();

// echo $product;
?>


<body class="bg-gray-100 p-6">
    <div class="container mx-auto max-w-7xl">
        <div class="bg-white p-6 rounded-lg shadow-md">

            <h2 class="text-2xl font-semibold mb-6">Editing Product - <?= htmlspecialchars($product['name']) ?></h2>


            <img class="h-56 w-56 mb-8 border border-primary rounded-xl shadow-xl"
                src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">

            <form id="editProductForm">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Short
                        Description</label>
                    <textarea id="description" name="description" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="long_description" class="block text-sm font-medium text-gray-700 mb-1">Long
                        Description</label>
                    <textarea id="long_description" name="long_description" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"><?= htmlspecialchars($product['long_description']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= $product['price'] ?>" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                </div>

                <div class="mb-4">
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock
                        Quantity</label>
                    <input type="number" id="stock_quantity" name="stock_quantity"
                        value="<?= $product['stock_quantity'] ?>" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                    <input type="url" id="image_url" name="image_url"
                        value="<?= htmlspecialchars($product['image_url']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                </div>

                <button type="submit"
                    class="w-full bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
                    Update Product
                </button>
            </form>
        </div>
    </div>


</body>

</html>