<div class="md:w-1/4">
    <div class="bg-white p-6 rounded-lg shadow-md sticky top-20">
        <form action="" method="GET" id="filter-form">
            <h2 class="text-xl font-semibold mb-4">Filters</h2>
            <!-- Hidden elements for JavaScript -->
            <div id="filter-parameters" data-search="<?php echo htmlspecialchars($searchQuery ?? ''); ?>"
                data-category="<?php echo htmlspecialchars($categoryId ?? ''); ?>"
                data-min-price="<?php echo htmlspecialchars($minPrice ?? ''); ?>"
                data-max-price="<?php echo htmlspecialchars($maxPrice ?? ''); ?>" class="hidden">
            </div>

            <!-- Search -->
            <div class="mb-6">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="search" name="search"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" />
            </div>

            <!-- Category -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Category</h3>
                <select name="category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                    <option value="">Select Product Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo (isset($categoryId) && $categoryId == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Price Range -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Price Range</h3>
                <div class="flex items-center">
                    <input type="number" id="min-price" name="min-price" placeholder="Min"
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" />
                    <span class="mx-2">-</span>
                    <input type="number" id="max-price" name="max-price" placeholder="Max"
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" />
                </div>
            </div>

            <!-- Apply Filters Button -->

            <button type="submit"
                class="w-full bg-accent text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition duration-300">
                Apply Filters
            </button>
            <!-- Reset Filters Button -->
            <button id="reset-filters" href="./products"
                class="w-full bg-gray-200 mt-2 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-300 transition duration-300"
                id="reset-filters">
                Reset Filters
            </button>
        </form>
    </div>
</div>