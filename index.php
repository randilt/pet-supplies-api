<?php
define('BASE_URL', '/pawsome');
$routes = [
    "/" => "views/home.php",
    "/products" => "views/products_page.php",
    "/product" => "views/product_details.php",
    "/about" => "views/about.php",
    "/contact" => "views/contact.view.php",
    "/subscription" => "views/subscription.view.php",

];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace(BASE_URL, "", $uri);

// Check for dynamic product routes
if (preg_match('/^\/product\/([a-zA-Z0-9-]+)$/', $uri, $matches)) {
    // $matches[1] contains the slug or ID
    $productIdentifier = $matches[1];

    // Set this as a variable that can be used in your product view
    $_GET['product_identifier'] = $productIdentifier;

    // Load the product detail page
    require "views/single_product.php";
    exit;
}

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];

} else {
    http_response_code(404);
    require "views/404.php";
    die();
}