<div class="bg-white text-gray-800 w-64 flex-shrink-0 p-4 min-h-screen sticky top-0">
    <h2 class="text-4xl font-chewy mb-6">Pawsome Admin</h2>
    <nav class="mb-4">
        <ul class="space-y-2">
            <?php
            $tabs = [
                'statistics' => 'Statistics',
                'products' => 'Products',
                'categories' => 'Categories',
                'orders' => 'Orders',
                'subscriptions' => 'Subscriptions'
            ];

            $currTab = isset($currTab) ? $currTab : 'statistics';

            foreach ($tabs as $tab => $label) {
                $activeClass = ($currTab === $tab) ? 'bg-[#F57C00] rounded-lg' : '';
                echo "<li><a href=\"./dashboard?tab=$tab\" class=\"block py-2 px-4 rounded-lg transition-colors duration-500 hover:bg-[#F57C00] $activeClass\">$label</a></li>";
            }
            ?>
    </nav>
    <form method="POST" class="mt-auto">
        <input type="hidden" name="action" value="logout">
        <button type="submit"
            class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/70  transition duration-300">Logout</button>
    </form>
</div>