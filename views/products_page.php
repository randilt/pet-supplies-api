<?php
require_once 'functions.php';
$products = fetchProducts();

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
      <div class="md:w-1/4">
        <div class="bg-white p-6 rounded-lg shadow-md sticky top-20">
          <h2 class="text-xl font-semibold mb-4">Filters</h2>

          <!-- Search -->
          <div class="mb-6">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" id="search" name="search"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" />
          </div>

          <!-- Category -->
          <div class="mb-6">
            <h3 class="font-semibold mb-2">Category</h3>
            <div class="space-y-2">
              <label class="flex items-center"></label>
              <input type="checkbox" class="form-checkbox text-primary" />
              <span class="ml-2">Food</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="form-checkbox text-primary" />
                <span class="ml-2">Toys</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="form-checkbox text-primary" />
                <span class="ml-2">Accessories</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="form-checkbox text-primary" />
                <span class="ml-2">Health & Wellness</span>
              </label>
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
          <button class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition duration-300">
            Apply Filters
          </button>
        </div>
      </div>

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

  <script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    mobileMenuButton.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });

    // Close mobile menu when clicking outside
    document.addEventListener("click", (event) => {
      if (
        !mobileMenuButton.contains(event.target) &&
        !mobileMenu.contains(event.target)
      ) {
        mobileMenu.classList.add("hidden");
      }
    });
  </script>
</body>

</html>