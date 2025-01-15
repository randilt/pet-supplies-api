<?php
require_once dirname(__DIR__) . '/utils/Response.php';
require_once dirname(__DIR__) . '/utils/Database.php';
require_once dirname(__DIR__) . '/utils/Auth.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/functions.php';

$db = new Database();
$auth = new Auth($db);

$userId = $_SESSION['user_id'] ?? null;
if ($userId === null) {
    header('Location: /login');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    handleLogout();
}

$title = 'My Profile - Pawsome';
require_once 'partials/header.php';
?>

<body class="font-nunito bg-gray-100">
    <?php require_once 'partials/navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <div id="userId" data-user-id="<?php echo htmlspecialchars($userId); ?>" style="display: none;"></div>
        <div class="flex items-center justify-center flex-col mb-8">
            <h1 class="text-4xl font-chewy text-[#FF9800] mb-8 text-center">My Pawsome Profile</h1>
            <form method="POST" action="">
                <button type="submit" name="logout"
                    class="bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">Logout
                </button>
            </form>
        </div>

        <?php if (isset($successMessage)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($successMessage); ?></span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 gap-8">
            <div class="profile-section">
                <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
                <form method="POST" action="" id="userInformationForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your name"
                                value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" disabled name="email"
                                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
                                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="Enter your address"
                                class=" w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none
                                focus:ring-[#FF9800]
                                focus:border-[#FF9800]"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="update_profile"
                        class="w-full md:w-auto bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
                        Update Profile
                    </button>
                </form>
            </div>

            <div class="profile-section" id="orders">
                <h2 class="text-2xl font-bold mb-4">Recent Orders</h2>
                <div id="ordersContainer" class="space-y-4">
                    <p class="text-gray-600">Loading orders...</p>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'partials/footer.php'; ?>
    <script src="assets/js/orders.js"></script>
    <script src="assets/js/user.js"></script>
</body>

</html>