-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 18, 2025 at 06:02 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_supplies_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `name`, `created_at`, `updated_at`) VALUES
(3, 'admin@example.com', '$2y$10$f426Krsw6eBo3FI0xGlPiO/DiUCLOW50u2EEq4U40cwZRxPTqfiBC', 'System Admin', '2024-11-19 09:56:32', '2024-11-19 09:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int NOT NULL,
  `space_id` int NOT NULL,
  `advertiser_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `click_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','pending','expired') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_spaces`
--

CREATE TABLE `advertisement_spaces` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price_per_day` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Dog Food', 'High-quality nutrition for dogs', '2024-11-19 07:34:06'),
(2, 'Cat Food', 'Nutritious meals for cats', '2024-11-19 07:34:06'),
(3, 'Pet Toys', 'Fun and engaging toys for pets', '2024-11-19 07:34:06'),
(21, 'test', 'test', '2024-12-30 09:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `customer_subscriptions`
--

CREATE TABLE `customer_subscriptions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','cancelled','expired') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_subscriptions`
--

INSERT INTO `customer_subscriptions` (`id`, `user_id`, `plan_id`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(3, 3, 1, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:07:05'),
(4, 3, 3, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:21:10'),
(5, 3, 3, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:28:38'),
(6, 3, 3, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:31:02'),
(7, 3, 3, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:31:09'),
(8, 3, 3, '2025-01-17', '2025-01-17', 'cancelled', '2025-01-17 15:34:20'),
(9, 3, 1, '2025-01-17', '2026-01-17', 'active', '2025-01-17 15:34:43'),
(10, 8, 3, '2025-01-18', '2026-01-18', 'active', '2025-01-18 04:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `shipping_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, 3452.00, 'pending', '123 Main St, Anytown, USA', '2024-12-02 11:49:56', '2025-01-02 15:56:04'),
(2, 1, 3452.00, 'shipped', '123 Main St, Anytown, USA', '2024-12-31 12:50:01', '2025-01-02 15:56:18'),
(3, 1, 1652.00, 'pending', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-01 14:20:14', '2025-01-01 14:20:14'),
(4, 1, 6152.00, 'shipped', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-01 14:24:19', '2025-01-02 15:51:40'),
(5, 3, 5400.00, 'cancelled', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-02 16:01:51', '2025-01-04 17:43:57'),
(6, 1, 3452.00, 'pending', '123 Main St, Anytown, USA', '2025-01-04 18:33:01', '2025-01-04 18:33:01'),
(7, 3, 10.99, 'pending', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-15 16:24:48', '2025-01-15 16:24:48'),
(8, 3, 10.99, 'pending', '6/8, Delgoda', '2025-01-15 16:25:24', '2025-01-15 16:25:24'),
(9, 3, 10.99, 'pending', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-15 16:33:27', '2025-01-15 16:33:27'),
(10, 7, 10.99, 'pending', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-15 16:47:45', '2025-01-15 16:47:45'),
(11, 8, 2666.99, 'pending', '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana, Delgoda', '2025-01-18 04:45:42', '2025-01-18 04:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price_at_time` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_time`, `created_at`) VALUES
(1, 1, 56, 2, 1500.00, '2024-12-02 11:49:56'),
(2, 1, 59, 1, 452.00, '2024-12-02 11:49:56'),
(3, 2, 56, 2, 1500.00, '2024-12-31 12:50:01'),
(4, 2, 59, 1, 452.00, '2024-12-31 12:50:01'),
(5, 3, 59, 1, 452.00, '2025-01-01 14:20:14'),
(6, 3, 76, 1, 1200.00, '2025-01-01 14:20:14'),
(7, 4, 76, 1, 1200.00, '2025-01-01 14:24:19'),
(8, 4, 59, 1, 452.00, '2025-01-01 14:24:19'),
(9, 4, 56, 3, 1500.00, '2025-01-01 14:24:19'),
(10, 5, 76, 1, 1200.00, '2025-01-02 16:01:51'),
(11, 5, 58, 4, 650.00, '2025-01-02 16:01:51'),
(12, 5, 57, 2, 800.00, '2025-01-02 16:01:51'),
(13, 6, 56, 2, 1500.00, '2025-01-04 18:33:01'),
(14, 6, 59, 1, 452.00, '2025-01-04 18:33:01'),
(15, 7, 78, 1, 10.99, '2025-01-15 16:24:48'),
(16, 8, 78, 1, 10.99, '2025-01-15 16:25:24'),
(17, 9, 78, 1, 10.99, '2025-01-15 16:33:27'),
(18, 10, 78, 1, 10.99, '2025-01-15 16:47:45'),
(19, 11, 78, 1, 10.99, '2025-01-18 04:45:42'),
(20, 11, 59, 3, 452.00, '2025-01-18 04:45:42'),
(21, 11, 58, 2, 650.00, '2025-01-18 04:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `long_description` text COLLATE utf8mb4_general_ci,
  `status` varchar(16) COLLATE utf8mb4_general_ci DEFAULT 'active'
) ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`, `updated_at`, `variants`, `long_description`, `status`) VALUES
(55, 2, 'Meow Mix', 'Chewy and tasty treats for training and rewarding dogs', 1500.52, 1, 'https://i5.walmartimages.com/seo/Meow-Mix-Original-Choice-Dry-Cat-Food-3-15-Pound-Bag_90e53992-78bf-4e3e-b302-b673690cdb78.3f81121ebc52fbb5b1aaec7bed516d70.jpeg', '2024-11-19 16:01:45', '2025-01-04 18:29:14', NULL, 'Chewy and tasty treats for training and rewarding dogs Chewy and tasty treats for training and rewarding dogs Chewy and tasty treats for training and rewarding dogs', 'active'),
(56, 1, 'Deluxe Dog Treats 1', 'Tasty dog treats for training and rewarding.', 1500.00, 141, 'https://www.acozykitchen.com/wp-content/uploads/2024/02/dog_treats_12-500x500.jpg', '2024-11-19 16:59:59', '2025-01-04 18:33:01', NULL, 'asdTasty dog treats for training and rewarding.Tasty dog treats for training and rewarding.Tasty dog treats for training and rewarding.', 'active'),
(57, 2, 'Premium Cat Food 1', 'High-quality cat food for your feline friends.', 800.00, 3, 'https://m.media-amazon.com/images/I/71pjz7sTLrL._AC_SL1500_.jpg', '2024-11-19 17:03:36', '2025-01-04 18:29:14', NULL, 'Deluxe Dog Treats 3 are crafted with care to ensure your furry friend enjoys a nutritious and delicious snack. These premium dog treats are made with high-quality, all-natural ingredients to promote health and happiness in dogs of all breeds and sizes.', 'active'),
(58, 1, 'Chewy Dog Bones 2', 'Long-lasting dog bones for hours of chewing fun.', 650.00, 114, 'https://cobbydog.com/cdn/shop/products/CD_Products900__0005s_0005_Final_CHW5084Revised-02.jpg?v=1683211132', '2024-11-19 17:04:11', '2025-01-18 04:45:42', NULL, NULL, 'active'),
(59, 2, 'Catnip Cat Toys for your lovely cat 2', 'Engaging catnip toys that your cat will love. asdasda', 452.00, 4, 'https://m.media-amazon.com/images/I/715EiqpJ6XL.jpg', '2024-11-19 17:04:45', '2025-01-18 04:45:42', NULL, 'Engaging catnip toys that your cat will love.Engaging catnip toys that your cat will love.Engaging catnip toys that your cat will love. asdad', 'active'),
(76, 3, 'Pet Toy | Interactive Dog Toy | Durable Play Toy', 'Durable interactive pet toy designed to keep your dog engaged, promoting healthy play and reducing boredom.', 1200.00, 14, 'https://image.chewy.com/is/image/catalog/68074_MAIN._AC_SS1800_V1628101907_.jpg', '2024-11-28 16:20:42', '2025-01-04 18:27:39', NULL, 'Deluxe Dog Treats 3 are crafted with exceptional care to ensure your furry friend enjoys a nutritious and delicious snack that they\'ll eagerly look forward to every time. These premium dog treats are made with high-quality, all-natural ingredients, specifically chosen to promote overall health and happiness in dogs of all breeds and sizes.\n\nPacked with essential nutrients, these treats are not only a tasty reward but also a boost to your dog\'s well-being. They support healthy digestion, a shiny coat, strong teeth, and an active lifestyle. Whether you\'re using them during training sessions, as a reward for good behavior, or simply as a way to show your love, these treats are perfect for every occasion.\n\nAvailable in different sizes to suit the unique needs of small, medium, and large breeds, Deluxe Dog Treats 3 are designed to cater to dogs of all shapes and sizes. Made without artificial preservatives or fillers, they offer a wholesome snack option that you can feel good about giving to your pet.\n\nMake snack time a delightful and healthy experience for your dog with Deluxe Dog Treats 3—because your four-legged companion deserves nothing but the best.', 'inactive'),
(78, 1, 'Premium Cat Litterr', 'High-absorbent and odor-neutralizing cat litter for a fresh and clean home.', 10.99, 95, 'https://example.com/images/cat-litter.jpg', '2025-01-04 18:30:19', '2025-01-18 04:45:42', '[{\"type\":\"weight\",\"values\":[\"5kg\",\"10kg\",\"15kg\"],\"price_adjustments\":[0,5,10]},{\"type\":\"scent\",\"values\":[\"lavender\",\"unscented\",\"lemon\"],\"price_adjustments\":[0,0,0]}]', 'Our premium cat litter is designed to provide maximum absorbency and superior odor control, ensuring a hygienic environment for your cat.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `duration_months` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `description`, `price`, `duration_months`, `created_at`) VALUES
(1, 'Basic Paw', '2-3 Toys\n1-2 Bags of Treats\n1 Chew Item', 3499.99, 12, '2025-01-16 17:30:30'),
(2, 'Premium Paw', '4-5 Toys\r\n2-3 Bags of Premium Treats\r\n2 Chew Items\r\n1 Accessory (collar, bandana, etc.)', 7499.99, 12, '2025-01-17 15:05:10'),
(3, 'Deluxe Paw', '6-7 Premium Toys\r\n3-4 Bags of Gourmet Treats\r\n3 Long-lasting Chews\r\n2 Accessories\r\n1 Surprise Luxury Item', 14999.99, 12, '2025-01-17 15:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `full_name`, `address`, `phone`) VALUES
(1, 'Withanage Randil Tharusha Wijesiri Withana', 'test@example.com', '$2y$10$J7vGo5ugphfSGbV486acyOlnRVpDvZ2yRU2DIsnIXCcLOpUJ8uhji', '2024-11-19 07:26:44', NULL, '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana', '0781347983'),
(2, '', 'test2@example.com', '$2y$10$lZ919sqYO3sSaq/QPkCJ/OhuCiqmhLIHxZGpAdg6GfEbdHW35mYTC', '2024-11-19 10:28:15', NULL, NULL, NULL),
(3, 'Randil Tharusha', 'randil@test.com', '$2y$10$d8xRoOAJTQZyBOlCuH7S3.1P72VW8yobfS7CI4YISI02MeaegClzi', '2024-12-29 08:04:22', NULL, '6/8\nRohitha Weerakon Mawatha, Katulanda, Dekatana', '0788683097'),
(4, 'Tharusha', 'randil2@test.com', '$2y$10$WEWRB9JCdHMnZzoVgdXrheM2kFoN2U02Yxth3Qy.BgZkLJcSSZ6ku', '2024-12-29 08:24:54', NULL, '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana', '0781347983'),
(5, 'Randika', 'test111@example.com', '$2y$10$7..MLRIugVt3gK1AqrUWsO6bdJjA4V2X6fgbVzPJsaRxdiML4GZOG', '2025-01-04 18:08:02', NULL, NULL, NULL),
(6, 'Randil Withanage', 'rane@test.com', '$2y$10$Ssi/8.jC1GD9Jv/wfL8ytOsRlCiwGHY7uxQK9wxFQIQQSU6G8geue', '2025-01-15 16:43:14', NULL, NULL, NULL),
(7, 'Withanage Randil Tharusha Wijesiri Withana', 'asd@asd.asd', '$2y$10$K9ZVySYtZPNRAnSRJCiIUu3m0rT3Xc51a0yDbhKjL9FwLAOUoyZjO', '2025-01-15 16:46:32', NULL, '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana\nRohitha Weerakon Mawatha, Katulanda, Dekatana', '0781347983'),
(8, 'Withanage Randil Tharusha Wijesiri Withana', 'randiltharusha72@gmail.com', '$2y$10$eHNyNL6QPPlYN3YgghCmTOdrtbm7bEhrhvGILxdBki3xXPmo6B/Em', '2025-01-18 04:43:25', NULL, '6/8, Rohitha Weerakoon Mawatha, Katulanda, Dekatana\nRohitha Weerakon Mawatha, Katulanda, Dekatana', '0781347983');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `space_id` (`space_id`);

--
-- Indexes for table `advertisement_spaces`
--
ALTER TABLE `advertisement_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisement_spaces`
--
ALTER TABLE `advertisement_spaces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_ibfk_1` FOREIGN KEY (`space_id`) REFERENCES `advertisement_spaces` (`id`);

--
-- Constraints for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  ADD CONSTRAINT `customer_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_subscriptions_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
