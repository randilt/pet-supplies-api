<!DOCTYPE html>
<html lang="en">

<?php
$title = "Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-100 text-gray-900">
    <?php require 'partials/navbar.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl md:text-5xl font-extralight font-chewy mb-8">My Cart</h1>
        <div id="cart-container">
            <!-- Cart items will be dynamically inserted here -->
        </div>
        <div id="cart-summary" class="mt-8">
            <!-- Cart summary will be dynamically inserted here -->
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4 font-chewy">Pawsome</h3>
                    <p class="text-gray-400">Providing premium pet supplies for your furry friends</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Shop</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Shipping & Returns</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-pinterest"></i></a>
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
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Cart functionality
        function loadCart() {
            const cartContainer = document.getElementById('cart-container');
            const cartSummary = document.getElementById('cart-summary');
            const cartItems = JSON.parse(localStorage.getItem('userCart')) || [];

            if (cartItems.length === 0) {
                cartContainer.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-xl mb-4">Your cart is empty</p>
                        <a href="#" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition duration-300">Start Shopping</a>
                    </div>
                `;
                cartSummary.innerHTML = '';
            } else {
                let cartHTML = '';
                let totalPrice = 0;

                cartItems.forEach(item => {
                    const itemTotal = parseFloat(item.price) * item.quantity;
                    totalPrice += itemTotal;

                    cartHTML += `
                        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-lg shadow-md mb-4">
                            <div class="flex flex-col md:flex-row items-center mb-4 md:mb-0">
                                <img src="${item.imageUrl}" alt="${item.name}" class="w-24 h-24 object-cover rounded-md mr-4 mb-4 md:mb-0">
                                <div>
                                    <h2 class="text-lg font-semibold">${item.name}</h2>
                                    <p class="text-gray-600">${item.description}</p>
                                    <p class="text-primary font-semibold">LKR ${item.price} x ${item.quantity}</p>
                                </div>
                            </div>
                            <button onclick="removeFromCart('${item.id}')" class="bg-accent text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition duration-300">Remove</button>
                        </div>
                    `;
                });

                cartContainer.innerHTML = cartHTML;
                cartSummary.innerHTML = `
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold mb-4">Cart Summary</h2>
                        <p class="text-xl">Total: <span class="font-bold text-primary">LKR ${totalPrice.toFixed(2)}</span></p>
                        <button class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300 mt-4">Proceed to Checkout</button>
                    </div>
                `;
            }
        }

        function removeFromCart(itemId) {
            let cartItems = JSON.parse(localStorage.getItem('userCart')) || [];
            cartItems = cartItems.filter(item => item.id !== itemId);
            localStorage.setItem('userCart', JSON.stringify(cartItems));
            loadCart();
        }

        // Load cart on page load
        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>

</html>