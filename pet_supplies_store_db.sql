-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 07:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `advertiser_name` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `click_url` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','pending','expired') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_spaces`
--

CREATE TABLE `advertisement_spaces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Dog Food', 'High-quality nutrition for dogs', '2024-11-19 07:34:06'),
(2, 'Cat Food', 'Nutritious meals for cats', '2024-11-19 07:34:06'),
(3, 'Pet Toys', 'Fun and engaging toys for pets', '2024-11-19 07:34:06'),
(19, 'Dog Toys', 'High Quality Toys for your lovely dog', '2024-12-02 09:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `customer_subscriptions`
--

CREATE TABLE `customer_subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','cancelled','expired') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `shipping_address`, `created_at`) VALUES
(1, 1, 3452.00, 'pending', '123 Main St, Anytown, USA', '2024-12-02 11:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_time` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_time`, `created_at`) VALUES
(1, 1, 56, 2, 1500.00, '2024-12-02 11:49:56'),
(2, 1, 59, 1, 452.00, '2024-12-02 11:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variants`)),
  `long_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`, `updated_at`, `variants`, `long_description`) VALUES
(55, 2, 'Meow Mix', 'Chewy and tasty treats for training and rewarding dogs', 1500.52, 1, 'https://i5.walmartimages.com/seo/Meow-Mix-Original-Choice-Dry-Cat-Food-3-15-Pound-Bag_90e53992-78bf-4e3e-b302-b673690cdb78.3f81121ebc52fbb5b1aaec7bed516d70.jpeg', '2024-11-19 16:01:45', '2024-12-03 16:01:28', NULL, 'Chewy and tasty treats for training and rewarding dogs Chewy and tasty treats for training and rewarding dogs Chewy and tasty treats for training and rewarding dogs'),
(56, 1, 'Deluxe Dog Treats 1', 'Tasty dog treats for training and rewarding.', 1500.00, 148, 'https://www.acozykitchen.com/wp-content/uploads/2024/02/dog_treats_12-500x500.jpg', '2024-11-19 16:59:59', '2024-12-02 11:49:56', NULL, 'asdTasty dog treats for training and rewarding.Tasty dog treats for training and rewarding.Tasty dog treats for training and rewarding.'),
(57, 2, 'Premium Cat Food 1', 'High-quality cat food for your feline friends.', 800.00, 5, 'https://m.media-amazon.com/images/I/71pjz7sTLrL._AC_SL1500_.jpg', '2024-11-19 17:03:36', '2024-11-20 04:09:01', NULL, 'Deluxe Dog Treats 3 are crafted with care to ensure your furry friend enjoys a nutritious and delicious snack. These premium dog treats are made with high-quality, all-natural ingredients to promote health and happiness in dogs of all breeds and sizes.'),
(58, 1, 'Chewy Dog Bones 2', 'Long-lasting dog bones for hours of chewing fun.', 650.00, 120, 'https://cobbydog.com/cdn/shop/products/CD_Products900__0005s_0005_Final_CHW5084Revised-02.jpg?v=1683211132', '2024-11-19 17:04:11', '2024-11-19 17:04:11', NULL, NULL),
(59, 2, 'Catnip Cat Toys for your lovely cat 2', 'Engaging catnip toys that your cat will love. asdasda', 452.00, 11, 'https://m.media-amazon.com/images/I/715EiqpJ6XL.jpg', '2024-11-19 17:04:45', '2024-12-02 11:49:56', NULL, 'Engaging catnip toys that your cat will love.Engaging catnip toys that your cat will love.Engaging catnip toys that your cat will love. asdad'),
(76, 3, 'Pet Toy | Interactive Dog Toy | Durable Play Toy', 'Durable interactive pet toy designed to keep your dog engaged, promoting healthy play and reducing boredom.', 1200.00, 3, 'https://image.chewy.com/is/image/catalog/68074_MAIN._AC_SS1800_V1628101907_.jpg', '2024-11-28 16:20:42', '2024-12-02 11:39:38', NULL, 'Pet Toy | Interactive Dog Toy | Durable Play Toy\n\nKeep your dog entertained and active with this high-quality, interactive pet toy. Designed to withstand even the most enthusiastic chewers, this durable toy is perfect for games of fetch, tug-of-war, and solo playtime. Its robust construction ensures long-lasting fun, making it ideal for dogs of all sizes and breeds.\n\nNot only does it provide hours of entertainment, but it also helps reduce boredom and anxiety in pets, promoting a happier, healthier lifestyle. The interactive design encourages your dog to use their problem-solving skills, providing mental stimulation and enhancing their cognitive abilities.\n\nMade from non-toxic materials, this toy is safe for your pet and is easy to clean. Whether you\'re indoors or outdoors, it\'s the perfect companion for bonding moments with your furry friend.\n\nPrice: රු1,200.00');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, '', 'test@example.com', '$2y$10$J7vGo5ugphfSGbV486acyOlnRVpDvZ2yRU2DIsnIXCcLOpUJ8uhji', '2024-11-19 07:26:44'),
(2, '', 'test2@example.com', '$2y$10$lZ919sqYO3sSaq/QPkCJ/OhuCiqmhLIHxZGpAdg6GfEbdHW35mYTC', '2024-11-19 10:28:15'),
(3, '', 'randil@test.com', '$2y$10$d8xRoOAJTQZyBOlCuH7S3.1P72VW8yobfS7CI4YISI02MeaegClzi', '2024-12-29 08:04:22'),
(4, '', 'randil2@test.com', '$2y$10$WEWRB9JCdHMnZzoVgdXrheM2kFoN2U02Yxth3Qy.BgZkLJcSSZ6ku', '2024-12-29 08:24:54');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisement_spaces`
--
ALTER TABLE `advertisement_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
