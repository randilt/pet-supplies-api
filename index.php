<?php
define('BASE_URL', '/pawsome');
$routes = [
    "/" => "views/home.view.php",
    "/products" => "views/products_page.view.php",
    "/product" => "views/product_details.view.php",
    "/about" => "views/about.view.php",
    "/contact" => "views/contact.view.php",
    "/subscription" => "views/subscription.view.php",
    "/cart" => "views/cart.view.php",
    "/login" => "views/user-login.view.php",
    "/register" => "views/user-register.view.php",
    "/profile" => "views/user-profile.view.php",
    "/admin/login" => "views/admin-login.view.php",
    "/admin/dashboard" => "views/admin-dashboard.view.php",
    "/admin/dashboard/edit" => "views/admin-edit-product.view.php",

];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace(BASE_URL, "", $uri);

// check for dynamic product routes
if (preg_match('/^\/product\/([a-zA-Z0-9-]+)$/', $uri, $matches)) {
    // $matches[1] contains the slug or ID
    $productIdentifier = $matches[1];

    $_GET['product_identifier'] = $productIdentifier;

    // Load the product detail page
    require "views/single_product.php";
    exit;
}
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require "views/404.view.php";
    die();
}