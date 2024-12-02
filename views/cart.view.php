<?php

$action = isset($_GET['action']) ? strval($_GET['action']) : '';
$title = "My Cart | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-100 text-gray-900">
    <?php require 'partials/navbar.php'; ?>
    <?php if ($action === '') { ?>
        <main class="container mx-auto px-4 py-8">
            <h1 class="text-3xl md:text-5xl font-extralight font-chewy mb-8">My Cart</h1>
            <div id="cart-container">
                <!-- cat items will be dynamically inserted here -->
            </div>
            <div id="cart-summary" class="mt-8">
                <!-- cart summary will be  inserted here -->
            </div>
        </main>
    <?php } elseif ($action === 'checkout') { ?>
        <main class="container mx-auto px-4 py-8">
            <h1 class="text-3xl md:text-5xl font-extralight font-chewy mb-8">Checkout</h1>
            <div id="checkout-container" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>
                    <div id="checkout-items"></div>
                    <div id="checkout-total" class="mt-4 text-xl font-bold"></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Shipping Information</h2>
                    <form id="checkout-form" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" id="city" name="city" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="tel" id="phone" name="phone" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="paymentMethod" value="cashOnDelivery"
                                        checked>
                                    <span class="ml-2">Cash on Delivery</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300">Place
                            Order</button>
                    </form>
                </div>
            </div>
        </main>
    <?php } ?>


    <?php require 'partials/footer.php'; ?>

    <script src="assets/js/cart.js"></script>
</body>