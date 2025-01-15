<?php
require_once dirname(__DIR__) . '/utils/Database.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/models/UserModel.php';
require_once dirname(__DIR__) . '/utils/Auth.php';


$db = new Database();
$userModel = new UserModel($db);
$auth = new Auth($db);

// if user is already logged in, redirect to profile
if (isset($_SESSION['user_id'])) {
    header('Location: ./profile');
    exit;
}

$error = '';
$success = '';

// process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';

    if ($userModel->registerUser($email, $password, $name)) {
        $success = 'Registration successful! Logging in...';
        if ($auth->loginUser($email, $password)) {
            header('Location: ./profile');
            exit;
        }
        $error = 'An error occurred while logging in. Please try again.';
    } else {
        $error = 'Invalid email or password';
    }
}
?>




<?php

$title = 'Register | Pawsome';

require_once 'partials/header.php'; ?>

<body class="font-nunito"
    style="background-image: url('assets/images/login-bg.png');background-size: cover;background-position: center;">
    <?php require_once 'partials/navbar.php'; ?>

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-[600px] max-w-full">
            <div class="text-center mb-8">
                <svg class="w-20 h-20 mx-auto mb-4 text-[#FF9800] paw-icon" fill="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.5 6c.828 0 1.5.672 1.5 1.5S18.328 9 17.5 9 16 8.328 16 7.5 16.672 6 17.5 6zm-11 0C7.328 6 8 6.672 8 7.5S7.328 9 6.5 9 5 8.328 5 7.5 5.672 6 6.5 6zM12 20c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm6.5-8c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5 1.5.672 1.5 1.5-.672 1.5-1.5 1.5zm-13 0c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5 1.5.672 1.5 1.5-.672 1.5-1.5 1.5z" />
                </svg>
                <h1 class="text-4xl text-gray-800 font-chewy">Welcome to Pawsome!</h1>
                <p class="text-gray-600 mt-2">Register to Pawsome!</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
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
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                </div>

                <button type="submit"
                    class="w-full bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
                    Register
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Already have an account?
                    <a href="./login" class="font-medium text-[#FF9800] hover:text-[#F57C00]">Sign in</a>
                </p>
            </div>

            <div class="mt-8 text-center">
                <a href="./" class="text-sm text-gray-600 hover:text-[#FF9800]">Back to home</a>
            </div>


        </div>
    </div>

    <?php require_once 'partials/footer.php'; ?>
</body>

</html>