<?php
require_once dirname(__DIR__) . '/utils/Response.php';
require_once dirname(__DIR__) . '/utils/Database.php';
require_once dirname(__DIR__) . '/utils/Auth.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/functions.php';

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
$productsFrom2000 = fetchProducts(2000, null, null, null, 20, true);


$productsFrom0to200 = $productsFrom0to200['pagination']['total'];
$productsFrom201to400 = $productsFrom201to400['pagination']['total'];
$productsFrom401to600 = $productsFrom401to600['pagination']['total'];
$productsFrom601to800 = $productsFrom601to800['pagination']['total'];
$productsFrom2000 = $productsFrom2000['pagination']['total'];




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'partials/adminDashboard/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">
            <!-- a hidden element to pass the data attributes for the chart -->
            <div id="priceChartStats" data-from0to200="<?php echo $productsFrom0to200; ?>"
                data-from201to400="<?php echo $productsFrom201to400; ?>"
                data-from401to600="<?php echo $productsFrom401to600; ?>"
                data-from601to800="<?php echo $productsFrom601to800; ?>"
                data-from2000="<?php echo $productsFrom2000; ?>"></div>

            <h1 class="text-3xl font-bold mb-8">Welcome to Admin Dashboard</h1>

            <!-- Statistics -->
            <?php include 'partials/adminDashboard/dashboard_stats.php'; ?>

            <!-- Chart -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h3 class="text-xl font-semibold mb-4">Price Distribution</h3>
                <canvas id="priceChart"></canvas>
            </div>

            <!-- Forms -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Add Product Form -->
                <?php include 'partials/adminDashboard/add_product_form.php'; ?>

                <!-- Add Category Form -->
                <?php include 'partials/adminDashboard/add_category_form.php'; ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin.js">

    </script>
</body>

</html>