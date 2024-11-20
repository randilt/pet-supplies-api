<div class="flex flex-col sm:flex-row justify-between items-center mb-6">
    <div class="flex items-center mb-4 sm:mb-0">
        <label for="sort" class="mr-2">Sort by:</label>
        <select id="sort" name="sort"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            <option value="popular">Most Popular</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="newest">Newest</option>
        </select>
    </div>
    <div class="flex items-center">
        <label for="limit" class="mr-2">Show:</label>
        <select id="limit" name="limit"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            <option value="12">12</option>
            <option value="24">24</option>
            <option value="36">36</option>
            <option value="48">48</option>
        </select>
    </div>
</div>