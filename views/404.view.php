<!DOCTYPE html>
<html lang="en">



<?php $title = "404 | Pawsome | Premium Pet Supplies";
require 'partials/header.php'; ?>

<body class="font-nunito">
    <?php require 'partials/navbar.php'; ?>

    <div class="text-center py-16 min-h-screen flex items-center justify-center flex-col">
        <h1 class="text-5xl md:text-7xl  mb-4 font-chewy">404 - Uh-oh! <br>The Page is Playing Hide and Seek!
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Sorry to inform,
            but it seems this page has run away with a pack of mischievous puppies!
        </p>
        <a href="./"
            class="inline-block bg-accent text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition duration-300">Back
            To Home</a>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>

</html>