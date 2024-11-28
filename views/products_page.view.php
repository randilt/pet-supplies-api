<?php
require_once 'functions.php';
$searchQuery = isset($_GET['search']) ? strval($_GET['search']) : null;
$categoryId = isset($_GET['category_id']) ? strval($_GET['category_id']) : null;
$minPrice = isset($_GET['min_price']) ? strval($_GET['min_price']) : null;
$maxPrice = isset($_GET['max_price']) ? strval($_GET['max_price']) : null;
$products = fetchProducts(
  $minPrice,
  $maxPrice,
  $categoryId,
  $searchQuery,
  isset($_GET['limit']) ? intval($_GET['limit']) : 12,
  false,
  isset($_GET['page']) ? intval($_GET['page']) : null
);

$categories = fetchCategories();

?>


<!DOCTYPE html>
<html lang="en">

<?php
$title = "Our Products | Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-100 text-gray-900">
  <?php require 'partials/navbar.php'; ?>
  <main class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-extralight font-chewy mb-4 text-accent">Our Products</h1>

    <div class="flex flex-col md:flex-row gap-8">
      <!-- Filters Column -->
      <?php require 'partials/products_filter_form.php'; ?>
      <!-- Products Column -->
      <div class="md:w-3/4">
        <!-- Sort and Limit Options -->
        <?php require 'partials/products_sort_limit.php'; ?>
        <!-- Products Grid -->
        <?php require_once 'partials/product_card_grid.php'; ?>
        <!-- Pagination -->
        <?php require 'partials/pagination.php'; ?>
      </div>
    </div>
  </main>

  <?php require 'partials/footer.php'; ?>

  <script src="assets/js/product-filtering.js"></script>
</body>

</html>