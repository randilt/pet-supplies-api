<?php
// Use curl for more reliable API fetching
$apiUrl = 'http://localhost/pet-supplies-store-api/api/products/get_products.php'; // Relative path

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// Execute and get the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
  echo 'Curl error: ' . curl_error($ch);
  die();
}

// Close cURL resource
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Validate JSON decoding
if (json_last_error() !== JSON_ERROR_NONE) {
  die('Failed to parse JSON: ' . json_last_error_msg());
}

// // Debug: print raw response and parsed data
// echo "Raw Response:<pre>";
// print_r($response);
// echo "</pre>";

// echo "Parsed Data:<pre>";
// print_r($data);
// echo "</pre>";

// Check if products exist in the response
$products = $data['products'] ?? [];

// Display products
// if (!empty($products)) {
//   foreach ($products as $product) {
//     echo '<div>';
//     echo 'id: ' . htmlspecialchars($product['id']) . '<br>';
//     echo 'Name: ' . htmlspecialchars($product['name']) . '<br>';
//     echo 'Price: $' . htmlspecialchars($product['price']) . '<br>';
//     echo 'Category: ' . htmlspecialchars($product['category_name']) . '<br>';
//     echo 'Stock: ' . htmlspecialchars($product['stock_quantity']) . '<br>';
//     echo '</div><hr>';
//   }
// } else {
//   echo 'No products found.';
// }
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
          <?php foreach ($products as $product): ?>
            <?php
            // Default placeholder image if image_url is missing or empty
            $imageUrl = !empty($product['image_url']) ? $product['image_url'] : './assets/images/default-placeholder.webp';
            $name = $product['name'];
            $description = $product['description'];
            $price = $product['price'];
            $productUrl = './product?id=' . $product['id'];
            ?>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($name) ?>"
                class="w-full h-48 object-cover" />
              <div class="p-4">
                <a href="<?= htmlspecialchars($productUrl) ?>" class="hover:no-underline">
                  <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($name) ?></h3>
                  <p class="text-gray-600 mb-4">
                    <?= htmlspecialchars($description) ?>
                  </p>
                </a>
                <div class="flex justify-between items-center">
                  <span class="text-lg font-bold text-primary">LKR <?= htmlspecialchars($price) ?></span>
                  <button
                    class="bg-primary text-white px-4 py-2 rounded-full hover:bg-opacity-90 transition duration-300">
                    Add to Cart
                  </button>
                </div>
              </div>
            </div>

          <?php endforeach; ?>
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