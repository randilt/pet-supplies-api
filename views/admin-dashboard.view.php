<?php
require_once dirname(__DIR__) . '/utils/Response.php';
require_once dirname(__DIR__) . '/utils/Database.php';
require_once dirname(__DIR__) . '/utils/Auth.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/functions.php';

$currTab = isset($_GET['tab']) ? strval($_GET['tab']) : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;



$db = new Database();
$auth = new Auth($db);

// This will redirect to /admin/login if not authenticated as admin
$auth->requireAdmin();

// Handle logout if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    handleLogout();
}

$products = fetchProducts(null, null, null, null, 20, true);
// Fetch statistics
$stats = $products['stats'];

// Fetch categories for the product form
$categories = fetchCategories();

$productsFrom0to200 = fetchProducts(0, 200, null, null, 20, true);
$productsFrom201to400 = fetchProducts(201, 500, null, null, 20, true);
$productsFrom401to600 = fetchProducts(501, 1000, null, null, 20, true);
$productsFrom601to800 = fetchProducts(1001, 2000, null, null, 20, true);
$productsFrom2000to5000 = fetchProducts(2000, 5000, null, null, 20, true);
$productsFrom5000 = fetchProducts(5000, null, null, null, 20, true);


$productsFrom0to200 = $productsFrom0to200['pagination']['total'];
$productsFrom201to400 = $productsFrom201to400['pagination']['total'];
$productsFrom401to600 = $productsFrom401to600['pagination']['total'];
$productsFrom601to800 = $productsFrom601to800['pagination']['total'];
$productsFrom2000to5000 = $productsFrom2000to5000['pagination']['total'];
$productsFrom5000 = $productsFrom5000['pagination']['total'];




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Chewy&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 font-nunito">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'partials/adminDashboard/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- a hidden element to pass the data attributes for the chart -->
            <div id="priceChartStats" data-from0to200="<?php echo $productsFrom0to200; ?>"
                data-from201to400="<?php echo $productsFrom201to400; ?>"
                data-from401to600="<?php echo $productsFrom401to600; ?>"
                data-from601to800="<?php echo $productsFrom601to800; ?>" data-from2000to5000="<?php echo $productsFrom2000to5000; ?>
                " data-from5000="<?php echo $productsFrom5000; ?>
                "></div>
            <div class="flex justify-between items-center mb-8">

                <h1 class="text-3xl font-bold">Welcome to Admin Dashboard</h1>
                <a href="../" class="underline">Back to home</a>
            </div>
            <?php

            if ($currTab === 'editing' && $action === "edit" && $id !== null) {
                include 'partials/adminDashboard/edit_product_form.php';
            } else {
                switch ($currTab) {
                    case 'statistics':
                    case '':
                        ?>
                        <!-- Home Content -->

                        <!-- Statistics -->
                        <?php include 'partials/adminDashboard/dashboard_stats.php'; ?>
                        <!-- Chart -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-xl font-semibold mb-4">Price Distribution</h3>
                            <canvas id="priceChart"></canvas>
                        </div>
                        <?php
                        break;
                    case 'products':
                        ?>
                        <!-- Products table -->
                        <?php include 'partials/adminDashboard/products_table.php'; ?>
                        <!-- Add Product Form -->
                        <?php include 'partials/adminDashboard/add_product_form.php'; ?>
                        <?php
                        break;

                    case 'categories':
                        ?>
                        <!-- Categories table -->
                        <?php include 'partials/adminDashboard/categories_table.php'; ?>
                        <!-- Add Category Form -->
                        <?php include 'partials/adminDashboard/add_category_form.php'; ?>
                        <?php
                        break;

                    case 'orders':
                        ?>
                        <!-- Orders table -->
                        <?php include 'partials/adminDashboard/orders_table.php'; ?>
                        <?php
                        break;

                    default:
                        ?>
                        <!-- Default Content -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-xl font-semibold mb-4">Under Development</h3>
                            <p>This is the default content.</p>
                        </div>
                        <?php
                        break;
                }
            }
            ?>


        </div>
    </div>

    <script src="../assets/js/admin.js">

    </script>
</body>

</html>