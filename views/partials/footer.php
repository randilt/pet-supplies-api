<?php
$currentYear = date('Y');

$quickLinks = [
    ['url' => '.', 'text' => 'Home'],
    ['url' => './products', 'text' => 'All Products'],
    ['url' => './about', 'text' => 'About Us'],
    ['url' => './contact', 'text' => 'Contact'],
];

$customerService = [
    ['url' => './faq', 'text' => 'FAQ'],
    ['url' => './shipping-returns', 'text' => 'Shipping & Returns'],
    ['url' => './terms', 'text' => 'Terms & Conditions'],
    ['url' => './privacy', 'text' => 'Privacy Policy'],
];

$socialMedia = [
    ['url' => '#', 'name' => 'Facebook', 'icon' => 'M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z'],
    ['url' => '#', 'name' => 'Twitter', 'icon' => 'M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z'],
    ['url' => '#', 'name' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
];

function renderLinks($links)
{
    foreach ($links as $link) {
        echo '<li>';
        echo '<a href="' . htmlspecialchars($link['url']) . '" class="text-gray-200 hover:text-white transition">';
        echo htmlspecialchars($link['text']);
        echo '</a>';
        echo '</li>';
    }
}

function renderSocialIcons($socialMedia)
{
    foreach ($socialMedia as $social) {
        echo '<a href="' . htmlspecialchars($social['url']) . '" class="text-gray-200 hover:text-white transition" aria-label="' . htmlspecialchars($social['name']) . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">';
        echo '<path d="' . $social['icon'] . '" />';
        echo '</svg>';
        echo '</a>';
    }
}
?>

<footer class="bg-secondary text-white py-12 font-nunito">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h2 class="text-3xl font-semibold mb-4 font-chewy ">Pawsome</h2>
                <p class="text-gray-200">
                    Elevating pet care with premium supplies
                </p>
            </div>
            <nav aria-labelledby="quick-links-heading">
                <h3 id="quick-links-heading" class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <?php renderLinks($quickLinks); ?>
                </ul>
            </nav>
            <nav aria-labelledby="customer-service-heading">
                <h3 id="customer-service-heading" class="text-lg font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-2">
                    <?php renderLinks($customerService); ?>
                </ul>
            </nav>
            <div>
                <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                <div class="flex space-x-4">
                    <?php renderSocialIcons($socialMedia); ?>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-200">
            <p>&copy; <?php echo $currentYear; ?> Pawsome. All rights reserved.</p>
        </div>
    </div>
</footer>