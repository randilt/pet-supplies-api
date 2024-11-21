<!DOCTYPE html>
<html lang="en">

<?php
$title = "Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-50 text-gray-800">

  <?php require 'partials/navbar.php'; ?>
  <main>
    <!-- Hero Section with Subscription Box Promotion -->
    <section class="bg-primary text-white py-8 relative">
      <!-- Background image with overlay -->
      <div class="absolute inset-0 z-0">
        <img
          src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1586&q=80"
          alt="Happy pets background" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/40"></div>
      </div>

      <!-- Content -->
      <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-12 items-center">
          <!-- Main Hero Content -->
          <div class="text-center md:text-left space-y-3 font-chewy">
            <h1 class="text-4xl md:text-6xl font-extralight leading-tight">
              Elevate Your Pet's Lifestyle
            </h1>
            <p class="text-2xl text-white/90">
              Discover premium pet supplies tailored for your furry friends
            </p>
            <div class="pt-4 font-nunito">
              <a href="./products"
                class="bg-accent text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300 inline-block">Shop
                Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Recent Products -->
    <?php require 'partials/recent_products.php'; ?>

    <!-- About Us Section -->
    <section class="bg-gray-100 py-16">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-4">
          <div class="md:w-1/2">
            <img
              src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1586&q=80"
              alt="Happy pets" class="rounded-lg shadow-lg" />
          </div>
          <div class="md:w-1/2 mb-8 md:mb-0 md:pl-8">
            <h2 class="text-3xl md:text-5xl font-normal mb-4 font-chewy">About Pawsome</h2>
            <p class="text-xl mb-6 text-gray-600">
              We're passionate about providing the best for your pets. Our
              curated selection of premium products ensures that your furry
              friends receive the care they deserve.
            </p>
            <a href="./about" class="text-accent font-semibold hover:underline">Learn More About Us</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Subscription Box Section -->
    <section id="subscription" class="bg-white py-16">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
            <h2 class="text-4xl md:text-5xl font-light mb-4 font-chewy">Pawsome Box Subscription</h2>
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
            <a href="./subscription"
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



    <!-- Testimonials -->
    <section class="py-16 bg-gray-100">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-5xl font-light mb-12 text-center font-chewy">
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
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-5xl font-extralight font-chewy mb-6">Have Questions?</h2>
        <p class="text-xl md:text-3xl text-gray-600 mb-8 font-chewy">We'd love to hear from you and help you find the
          perfect
          products for
          your pets.</p>
        <a href="./contact"
          class="inline-block bg-[#FF9800] text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300">Contact
          Us</a>
      </div>
    </section>
  </main>

  <?php require 'partials/footer.php'; ?>
  <script src="assets/js/product-detail.js">


  </script>
</body>

</html>