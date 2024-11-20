<!DOCTYPE html>
<html lang="en">

<?php
$title = "Pawsome Subscription | Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-50 text-gray-800">
    <?php require 'partials/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&q=80"
                alt="Happy dog with box" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-chewy text-white mb-6">Pawsome Box Subscription</h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-8">
                Treat your furry friend to a monthly box of joy, filled with premium toys, treats, and accessories!
            </p>
            <a href="#subscription-tiers"
                class="bg-[#FF9800] text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300 inline-block">
                Choose Your Plan
            </a>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-5xl text-center mb-12 font-chewy">How It Works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">1. Choose Your Plan</h3>
                    <p class="text-gray-600">Select the perfect subscription tier for your pet's needs and your budget.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">2. We Curate & Ship</h3>
                    <p class="text-gray-600">Our experts handpick the best items and ship them directly to your door.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">3. Enjoy & Repeat</h3>
                    <p class="text-gray-600">Watch your pet's excitement as they unbox their goodies every month!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Subscription Tiers -->
    <section id="subscription-tiers" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-5xl font-chewy text-center mb-12">Choose Your Pawsome Box</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Basic Tier -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-4 text-center">Basic Paw</h3>
                        <p class="text-4xl font-bold text-center mb-6">$29.99<span
                                class="text-lg font-normal">/month</span></p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                2-3 Toys
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                1-2 Bags of Treats
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                1 Chew Item
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <button
                            class="w-full bg-[#FF9800] text-white px-4 py-2 rounded-md font-semibold hover:bg-opacity-90 transition duration-300">
                            Subscribe Now
                        </button>
                    </div>
                </div>

                <!-- Premium Tier -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-4 border-[#FF9800]">
                    <div class="bg-[#FF9800] text-white text-center py-2 font-semibold">
                        Most Popular
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-4 text-center">Premium Paw</h3>
                        <p class="text-4xl font-bold text-center mb-6">$49.99<span
                                class="text-lg font-normal">/month</span></p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                4-5 Toys
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                2-3 Bags of Premium Treats
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                2 Chew Items
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                1 Accessory (collar, bandana, etc.)
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <button
                            class="w-full bg-[#FF9800] text-white px-4 py-2 rounded-md font-semibold hover:bg-opacity-90 transition duration-300">
                            Subscribe Now
                        </button>
                    </div>
                </div>

                <!-- Deluxe Tier -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-4 text-center">Deluxe Paw</h3>
                        <p class="text-4xl font-bold text-center mb-6">$79.99<span
                                class="text-lg font-normal">/month</span></p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                6-7 Premium Toys
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                3-4 Bags of Gourmet Treats
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                3 Long-lasting Chews
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                2 Accessories
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                1 Surprise Luxury Item
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <button
                            class="w-full bg-[#FF9800] text-white px-4 py-2 rounded-md font-semibold hover:bg-opacity-90 transition duration-300">
                            Subscribe Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customization Options -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-5xl font-chewy text-center mb-12">Customize Your Box</h2>
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Pet Type</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="pet-type" class="form-radio text-[#FF9800]" checked>
                                <span class="ml-2">Dog</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="pet-type" class="form-radio text-[#FF9800]">
                                <span class="ml-2">Cat</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Size</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="size" class="form-radio text-[#FF9800]">
                                <span class="ml-2">Small (0-20 lbs)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="size" class="form-radio text-[#FF9800]" checked>
                                <span class="ml-2">Medium (20-50 lbs)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="size" class="form-radio text-[#FF9800]">
                                <span class="ml-2">Large (50+ lbs)</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Allergies or Preferences</h3>
                    <textarea
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"
                        rows="4"
                        placeholder="Let us know if your pet has any allergies or specific preferences"></textarea>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="py-16 bg-[#FF9800] text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-chewy mb-4">Ready to Make Your Pet's Day?</h2>
            <p class="text-xl mb-8">Join thousands of happy pets and their owners in the Pawsome Box family!</p>
            <a href="#subscription-tiers"
                class="bg-white text-[#FF9800] px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300 inline-block">
                Get Started Now
            </a>
        </div>
    </section>
    <?php require 'partials/footer.php'; ?>
</body>

</html>