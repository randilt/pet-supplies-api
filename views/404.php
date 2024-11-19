<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>404</title>
</head>

<body>
    <?php require 'partials/navbar.php'; ?>

    <div class="text-center py-16">
        <h1 class="text-4xl font-bold mb-4">404 - Page Not Found</h1>
        <p class="text-xl text-gray-600 mb-8">We're sorry, but the page you're looking for doesn't exist or has
            been removed.</p>
        <a href="./"
            class="bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition duration-300">Return to
            Home</a>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>

</html>