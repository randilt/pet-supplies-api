<?php
require_once dirname(__DIR__) . '/utils/Response.php';
require_once dirname(__DIR__) . '/utils/Database.php';
require_once dirname(__DIR__) . '/utils/Auth.php';
require_once dirname(__DIR__) . '/config/database.php';


$db = new Database();
$auth = new Auth($db); // Note: isApi is false by default

// If admin is already logged in, redirect to dashboard
$auth->requireAdminGuest();

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->loginAdmin($email, $password)) {
        header('Location: ./dashboard');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1615789591457-74a63395c990?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96 max-w-full">
        <div class="text-center mb-8">
            <img src="/placeholder.svg?height=80&width=80" alt="Pawsome Logo" class="mx-auto mb-4 w-20 h-20">
            <h1 class="text-3xl font-bold text-[#FF9800]">Pawsome Admin</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
            </div>
            <button type="submit"
                class="w-full bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="#" class="text-sm text-[#FF9800] hover:underline">Forgot password?</a>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Pawsome Pet Supplies &copy; <?php echo date('Y'); ?></p>
        </div>
    </div>
</body>

</html>