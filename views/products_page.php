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
  20
);

$categories = fetchCategories();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pawsome - Products</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body class="font-sans bg-gray-100 text-gray-900">
  <?php require 'partials/navbar.php'; ?>
  <main class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Our Products</h1>

    <div class="flex flex-col md:flex-row gap-8">
      <!-- Filters Column -->
      <?php require 'partials/products_filter_form.php'; ?>
      <!-- Products Column -->
      <div class="md:w-3/4">
        <!-- Sort and Limit Options -->
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

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Product Cars -->
          <?php require_once 'partials/product_card_grid.php'; ?>

        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
          <nav class="inline-flex rounded-md shadow">
            <a href="#"
              class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
              Previous
            </a>
            <a href="#"
              class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
              1
            </a>
            <a href="#"
              class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
              2
            </a>
            <a href="#"
              class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
              3
            </a>
            <a href="#"
              class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
              Next
            </a>
          </nav>
        </div>
      </div>
    </div>
  </main>

  <?php require 'partials/footer.php'; ?>

  <script src="assets/js/product-filtering.js"></script>
</body>

</html>