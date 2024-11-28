<?php
// Keep the PHP logic section unchanged
$products = fetchProducts(
    $minPrice,
    $maxPrice,
    $categoryId,
    $searchQuery,
    isset($_GET['limit']) ? intval($_GET['limit']) : 12,
    true,
    isset($_GET['page']) ? intval($_GET['page']) : null
);

$pagination = $products['pagination'] ?? null;
$currentPage = $pagination['page'];
$totalPages = $pagination['total_pages'];
$currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryParams = $_GET;
?>

<div class="mt-8 flex justify-center">
    <nav class="inline-flex space-x-2">
        <?php if ($currentPage > 1): ?>
            <?php
            $queryParams['page'] = $currentPage - 1;
            $prevLink = $currentUrl . '?' . http_build_query($queryParams);
            ?>
            <a href="<?= htmlspecialchars($prevLink) ?>"
                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">
                <span>&larr;</span>
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php
            $queryParams['page'] = $i;
            $pageLink = $currentUrl . '?' . http_build_query($queryParams);
            $activeClass = $i === $currentPage ? 'bg-accent text-white hover:bg-pink-600' : 'bg-white text-gray-700 hover:bg-pink-50 hover:text-pink-600';
            ?>
            <a href="<?= htmlspecialchars($pageLink) ?>"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 <?= $activeClass ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <?php
            $queryParams['page'] = $currentPage + 1;
            $nextLink = $currentUrl . '?' . http_build_query($queryParams);
            ?>
            <a href="<?= htmlspecialchars($nextLink) ?>"
                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">
                <span>&rarr;</span>
            </a>
        <?php endif; ?>
    </nav>
</div>