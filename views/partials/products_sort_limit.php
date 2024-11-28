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
        <select id="limit" name="limit" onchange="updateLimit(this.value)"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary">
            <option value="12" <?= (isset($_GET['limit']) && $_GET['limit'] == '12') ? 'selected' : '' ?>>12</option>
            <option value="24" <?= (isset($_GET['limit']) && $_GET['limit'] == '24') ? 'selected' : '' ?>>24</option>
            <option value="36" <?= (isset($_GET['limit']) && $_GET['limit'] == '36') ? 'selected' : '' ?>>36</option>
            <option value="48" <?= (isset($_GET['limit']) && $_GET['limit'] == '48') ? 'selected' : '' ?>>48</option>
        </select>
    </div>
</div>

<script>
    function updateLimit(limit) {
        var url = new URL(window.location.href);
        url.searchParams.set('limit', limit);
        window.location.href = url.toString();
    }
</script>