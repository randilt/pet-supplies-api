<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Product Stats</h3>
        <p>Total Products: <?php echo $stats['total_products']; ?></p>
        <p>In Stock: <?php echo $stats['in_stock_count']; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Category Stats</h3>
        <p>Total Categories: <?php echo $stats['total_categories']; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Price Stats</h3>
        <p>Min Price: $<?php echo number_format($stats['min_price'], 2); ?></p>
        <p>Max Price: $<?php echo number_format($stats['max_price'], 2); ?></p>
        <p>Avg Price: $<?php echo number_format($stats['avg_price'], 2); ?></p>
    </div>
</div>