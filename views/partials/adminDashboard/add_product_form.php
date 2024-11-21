<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4">Add New Product</h3>
    <form enctype="multipart/form-data" id="productForm">
        <!-- <input type="hidden" name="action" value="add_product"> -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product
                Name</label>
            <input type="text" id="name" name="name" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Short
                Description (10 - 255 Characters)</label>
            <textarea id="description" name="description" required maxlength="255"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"></textarea>
        </div>
        <div class="mb-4">
            <label for="long_description" class="block text-sm font-medium text-gray-700 mb-1">Long
                Description (Min 50 Characters)</label>
            <textarea id="long_description" name="long_description" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"></textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input type="number" id="price" name="price" step="0.01" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select id="category_id" name="category_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="product_image" class="block text-sm font-medium text-gray-700 mb-1">Product
                Image</label>
            <input type="file" id="product_image" name="product_image" accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
        </div>
        <button type="submit"
            class="w-full bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
            Add Product
        </button>
    </form>
</div>