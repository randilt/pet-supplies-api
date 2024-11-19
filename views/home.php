<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pawsome - Modern Pet Supplies</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link href="assets/css/styles.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="output.css" rel="stylesheet" />
</head>

<body class="font-sans bg-gray-50 text-gray-800">

  <?php require 'partials/navbar.php'; ?>
  <main>
    <!-- Hero Section with Subscription Box Promotion -->
    <section class="bg-primary text-white py-24 relative">
      <!-- Background image with overlay -->
      <div class="absolute inset-0 z-0">
        <img
          src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1586&q=80"
          alt="Happy pets background" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-primary/70"></div>
      </div>

      <!-- Content -->
      <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <!-- Main Hero Content -->
          <div class="text-center md:text-left space-y-6">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
              Elevate Your Pet's Lifestyle
            </h1>
            <p class="text-xl text-white/90">
              Discover premium pet supplies tailored for your furry friends
            </p>
            <div class="pt-4">
              <a href="#"
                class="bg-accent text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300 inline-block">Shop
                Now</a>
            </div>
          </div>

          <!-- Subscription Promo Card -->
          <div class="bg-white/30 backdrop-blur-lg rounded-2xl p-8 text-center space-y-4">
            <span class="text-white font-semibold text-sm uppercase tracking-wider">
              Special Offer
            </span>
            <h2 class="text-3xl font-bold text-gray-800">
              Pawsome Box Subscription
            </h2>
            <p class="text-lg text-black/90">
              Premium pet essentials delivered monthly
            </p>
            <div class="pt-4">
              <a href="#subscription"
                class="bg-accent text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-accent/80 transition duration-300 inline-block">Learn
                More</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Trending Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Product Card 1 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
            <img
              src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Dog food" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-xl font-semibold mb-2">Organic Dog Food</h3>
              <p class="text-gray-600 mb-4">
                Nutritious meals for your canine companion
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$24.99</span>
                <button class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-80 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
          <!-- Product Card 2 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
            <img
              src="https://images.unsplash.com/photo-1545249390-6bdfa286032f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Cat toy" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-xl font-semibold mb-2">Interactive Cat Toy</h3>
              <p class="text-gray-600 mb-4">
                Engaging playtime for feline friends
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$12.99</span>
                <button class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-80 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
          <!-- Product Card 3 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
            <img
              src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Dog leash" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-xl font-semibold mb-2">Eco-Friendly Leash</h3>
              <p class="text-gray-600 mb-4">
                Sustainable and durable for daily walks
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$19.99</span>
                <button class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-80 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
          <!-- Product Card 4 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
            <img
              src="https://images.unsplash.com/photo-1585499583264-091a8a122461?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Pet bed" class="w-full h-48 object-cover" />
            <div class="p-4">
              <h3 class="text-xl font-semibold mb-2">Orthopedic Pet Bed</h3>
              <p class="text-gray-600 mb-4">
                Comfort and support for restful sleep
              </p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-primary">$34.99</span>
                <button class="bg-accent text-white px-4 py-2 rounded-full hover:bg-opacity-80 transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Subscription Box Section -->
    <section id="subscription" class="bg-gray-100 py-16">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
            <h2 class="text-3xl font-bold mb-4">Pawsome Box Subscription</h2>
            <p class="text-xl mb-6 text-gray-600">
              Get a curated box of premium pet essentials delivered to your
              doorstep every month.
            </p>
            <ul class="mb-6 space-y-2">
              <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                High-quality pet food samples
              </li>
              <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Durable toys for endless fun
              </li>
              <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Grooming supplies and accessories
              </li>
            </ul>
            <a href="#"
              class="bg-accent text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300">Subscribe
              Now</a>
          </div>
          <div class="md:w-1/2">
            <img
              src="https://images.unsplash.com/photo-1601758124510-52d02ddb7cbd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
              alt="Subscription box" class="rounded-lg shadow-lg" />
          </div>
        </div>
      </div>
    </section>

    <!-- About Us Section -->
    <section class="bg-white py-16">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-4">
          <div class="md:w-1/2">
            <img
              src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1586&q=80"
              alt="Happy pets" class="rounded-lg shadow-lg" />
          </div>
          <div class="md:w-1/2 mb-8 md:mb-0 md:pl-8">
            <h2 class="text-3xl font-bold mb-4">About Pawsome</h2>
            <p class="text-xl mb-6 text-gray-600">
              We're passionate about providing the best for your pets. Our
              curated selection of premium products ensures that your furry
              friends receive the care they deserve.
            </p>
            <a href="#" class="text-accent font-semibold hover:underline">Learn More About Us</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-100">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">
          What Our Customers Say
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 mb-4">
              "Pawsome has been a game-changer for me and my furry family. The
              quality of their products is unmatched!"
            </p>
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Customer"
                class="w-12 h-12 rounded-full mr-4" />
              <div>
                <h4 class="font-semibold">Sarah Johnson</h4>
                <div class="text-yellow-400">★★★★★</div>
              </div>
            </div>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 mb-4">
              "I love the variety of products available at Pawsome. My cats
              are always excited when their new toys arrive!"
            </p>
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Customer"
                class="w-12 h-12 rounded-full mr-4" />
              <div>
                <h4 class="font-semibold">Michael Lee</h4>
                <div class="text-yellow-400">★★★★★</div>
              </div>
            </div>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 mb-4">
              "The customer service at Pawsome is outstanding. They really
              care about pets and their owners!"
            </p>
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Customer"
                class="w-12 h-12 rounded-full mr-4" />
              <div>
                <h4 class="font-semibold">Emily Rodriguez</h4>
                <div class="text-yellow-400">★★★★★</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="bg-primary text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8">
          Subscribe to our newsletter for exclusive offers and pet care tips
        </p>
        <form class="max-w-md mx-auto flex">
          <input type="email" placeholder="Enter your email"
            class="flex-grow px-4 py-2 rounded-l-full focus:outline-none text-gray-900" />
          <button type="submit"
            class="bg-accent text-white px-6 py-2 rounded-r-full hover:bg-opacity-90 transition duration-300">
            Subscribe
          </button>
        </form>
      </div>
    </section>
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