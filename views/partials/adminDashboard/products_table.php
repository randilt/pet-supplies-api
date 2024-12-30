<?php
// File: admin_product_table.php

require_once 'functions.php';

// Fetch all products without pagination for admin view
$products = fetchProducts(null, null, null, null, 5000, true)['products'];
// Fetch categories for filteringp

$categories = fetchCategories();
?>

<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-4">Product Management</h2>
    <!-- Products Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Image</th>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Category</th>
                    <th class="py-2 px-4 border-b text-left">Price</th>
                    <th class="py-2 px-4 border-b text-left">Stock</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="py-4 px-4 border-b text-center text-gray-500">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= $product['id'] ?></td>
                            <td class="py-2 px-4 border-b">
                                <img src="<?= htmlspecialchars($product['image_url'] ?? './assets/images/default-placeholder.webp') ?>"
                                    alt="<?= htmlspecialchars($product['name'] ?? 'Product Image') ?>"
                                    class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b">LKR <?= number_format($product['price'], 2) ?></td>
                            <td class="py-2 px-4 border-b"><?= $product['stock_quantity'] ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="./dashboard?action=edit&tab=editing&id=<?= $product['id'] ?>"
                                    class="text-blue-500 hover:underline mr-2">Edit</a>
                                <button onclick="deleteProduct(<?= $product['id'] ?>)"
                                    class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>

    let apiUrl1
    const fetchConfig1 = async () => {
        const response = await fetch('../config.json ')
        const config = await response.json()
        return config
    }
    fetchConfig1()
        .then((config) => {
            apiUrl1 = config.env === 'development' ? 'http://localhost/pawsome/api' : '/api'
        })
        .catch((error) => {
            console.error('Failed to load configuration:', error)
        })
    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            // Send AJAX request to delete the product
            fetch(`${apiUrl}/products/delete_product.php?id=${productId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.message === 'Product deleted successfully') {
                        // Refresh the page after successful deletion to reflect the changes
                        location.reload();

                    } else {
                        alert('Failed to delete the product. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the product.');
                });
        }
    }
</script>