<!DOCTYPE html>
<html lang="en">

<?php
$title = "About Us | Pawsome | Premium Pet Suppliess";
require 'partials/header.php';

?>

<body class="font-nunito bg-gray-50 text-gray-800">
    <?php require 'partials/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1415369629372-26f2fe60c467?auto=format&fit=crop&q=80"
                alt="Pet background" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center font-chewy">
            <h1 class="text-6xl md:text-7xl font-normal text-white mb-6 ">Our Story</h1>
            <p class="text-2xl font-extralight   text-white/90 max-w-2xl mx-auto">
                Dedicated to bringing joy and health to pets everywhere since 2020
            </p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-light mb-6 font-chewy">Our Mission</h2>
                <p class="text-lg text-gray-600">
                    At Pawsome, we believe every pet deserves the best. Our mission is to provide high-quality,
                    carefully selected pet supplies that enhance the lives of both pets and their owners. We're more
                    than just a pet store - we're your partner in pet parenthood.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-light font-chewy mb-2">Quality First</h3>
                    <p class="text-gray-600">We carefully select each product to ensure the highest quality for your
                        beloved pets.</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-light font-chewy mb-2">Pet Happiness</h3>
                    <p class="text-gray-600">Every product is chosen with your pet's happiness and well-being in mind.
                    </p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-[#FF9800] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-light font-chewy mb-2">Fair Pricing</h3>
                    <p class="text-gray-600">We believe quality pet care should be accessible to everyone.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-chewy mb-6">Have Questions?</h2>
            <p class="text-xl text-gray-600 mb-8">We'd love to hear from you and help you find the perfect products for
                your pets.</p>
            <a href="./contact"
                class="inline-block bg-[#FF9800] text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300">Contact
                Us</a>
        </div>
    </section>
    <?php require 'partials/footer.php'; ?>
</body>

</html>