<!DOCTYPE html>
<html lang="en">

<?php
$title = "Contact Us | Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-50 text-gray-800">
    <?php require 'partials/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&q=80"
                alt="Pet background" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center font-chewy">
            <h1 class="text-4xl md:text-6xl  text-white mb-6">Contact Us</h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                We're here to help! Reach out to us with any questions or concerns.
            </p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-3xl md:text-5xl font-chewy mb-6">Get in Touch</h2>
                        <form action="#" method="POST" class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                            </div>
                            <div>
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" id="subject" name="subject" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                            </div>
                            <div>
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" name="message" rows="4" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"></textarea>
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full bg-[#FF9800] text-white px-6 py-3 rounded-md font-semibold hover:bg-opacity-90 transition duration-300">Send
                                    Message</button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-100 p-8 rounded-lg">
                        <h2 class="text-3xl font-bold mb-6">Contact Information</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-[#FF9800] mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold">Address</h3>
                                    <p class="text-gray-600">123 Pet Street, Furry City, PC 12345</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-[#FF9800] mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold">Phone</h3>
                                    <p class="text-gray-600">(123) 456-7890</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-[#FF9800] mt-1 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold">Email</h3>
                                    <p class="text-gray-600">info@pawsome.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-xl font-bold mb-4">Business Hours</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li>Monday - Friday: 9:00 AM - 6:00 PM</li>
                                <li>Saturday: 10:00 AM - 4:00 PM</li>
                                <li>Sunday: Closed</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-5xl font-chewy text-center mb-12">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">How long does shipping take?</h3>
                    <p class="text-gray-600">We typically process and ship orders within 1-2 business days. Delivery
                        times vary depending on your location, but usually take 3-5 business days.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">What is your return policy?</h3>
                    <p class="text-gray-600">We offer a 30-day return policy for most items. If you're not satisfied
                        with your purchase, you can return it for a full refund or exchange.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-2">Do you offer international shipping?</h3>
                    <p class="text-gray-600">Currently, we only ship within the Sri Lanka. We're working on
                        expanding our shipping options to serve international customers in the future.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="py-16 bg-accent text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-5xl  mb-6 font-chewy">Have More Questions To Ask?</h2>
            <p class="text-3xl text-gray-600 mb-8 font-chewy">We'd love to hear from you and help you find the perfect
                products for
                your pets.</p>
            <a href="./contact"
                class="inline-block bg-white text-accent px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300">Contact
                Us</a>
        </div>
    </section>
    <?php require 'partials/footer.php'; ?>
</body>

</html>