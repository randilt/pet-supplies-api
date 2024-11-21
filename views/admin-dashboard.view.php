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