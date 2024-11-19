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
          <!-- Product Card 1 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Premium Dog Food" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Premium Dog Food</h3>
              <p class="text-gray-600 mb-4">
                High-quality nutrition for your canine companion
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$24.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Product Card 2 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1545249390-6bdfa286032f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Interactive Cat Toy" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Interactive Cat Toy</h3>
              <p class="text-gray-600 mb-4">
                Keep your feline friend entertained for hours
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$12.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Product Card 3 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Durable Dog Leash" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Durable Dog Leash</h3>
              <p class="text-gray-600 mb-4">
                Strong and comfortable for daily walks
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$19.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Product Card 4 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1585499583264-091a8a122461?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Cozy Pet Bed" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Cozy Pet Bed</h3>
              <p class="text-gray-600 mb-4">
                Soft and comfortable for sweet dreams
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$34.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Product Card 5 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1516734212186-65ef19cdf40e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80"
              alt="Cat Scratching Post" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Cat Scratching Post</h3>
              <p class="text-gray-600 mb-4">
                Durable post to keep your furniture safe
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$29.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>

          <!-- Product Card 6 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80"
              alt="Dog Grooming Kit" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">Dog Grooming Kit</h3>
              <p class="text-gray-600 mb-4">
                Complete set for at-home pet grooming
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$39.99</span>
                <button
                  class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
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

  <footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-semibold mb-4">Pawsome</h3>
          <p class="text-gray-400">
            Providing premium pet supplies for your furry friends
          </p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
          <ul class="space-y-2">
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Home</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Products</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">About Us</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Contact</a>
            </li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
          <ul class="space-y-2">
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">FAQ</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Shipping & Returns</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Terms & Conditions</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
            </li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
        <p>&copy; 2023 Pawsome. All rights reserved.</p>
      </div>
    </div>
  </footer>

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