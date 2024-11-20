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
                <div class="space-y-3">
                    <?php foreach ($categories as $category): ?>
                        <label
                            class="flex items-center cursor-pointer group hover:text-primary transition-colors duration-200">
                            <input type="radio" name="category" value="<?php echo htmlspecialchars($category['id']); ?>"
                                class="form-checkbox h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-2 text-sm"><?php echo htmlspecialchars($category['name']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
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
        </form>
    </div>
</div>