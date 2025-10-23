-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 08:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `react_easy_commerce_v9_5`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_picture` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `admin_username`, `admin_password`, `admin_picture`, `role_id`, `created_at`) VALUES
(1, 'admin_39_', '$2y$10$Wmc/PdFjUZrhcCb1bNTd8OGkMI0w1HMq039p/3E7uE9cqWMKkHVMu', 'NULL', 1, '2025-08-05');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `blog_title` varchar(255) DEFAULT NULL,
  `blog_description` text DEFAULT NULL,
  `blog_img` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blog_title`, `blog_description`, `blog_img`, `created_at`) VALUES
(2, 'The Future of E-Commerce: How AI and Automation Are Changing Online Shopping', '<p><span style=\"font-size: 14pt;\">Discover the latest techniques successful e-commerce businesses are using to increase conversions and average order value. From AI-driven personalization to mobile-first checkout design, this article reveals the tools and tactics that can take your online store to the next level. </span></p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li data-start=\"564\" data-end=\"822\">E-commerce is evolving faster than ever.</li>\r\n<li data-start=\"564\" data-end=\"822\">Learn how artificial intelligence,&nbsp;chatbots, and automated marketing systems are transforming.</li>\r\n<li data-start=\"564\" data-end=\"822\">How customers browse, buy, and interact with brands.</li>\r\n<li data-start=\"564\" data-end=\"822\">How your business can stay ahead of the curve.</li>\r\n</ul>', 'blog_68e77f308ae834.41929499.jpg', '2025-10-05 12:58:47'),
(3, '5 Proven Strategies to Boost Your Online Store Sales in 2025', '<p><span style=\"font-size: 14pt;\">Discover the latest techniques successful e-commerce businesses are using to increase conversions and average order value. From AI-driven personalization to mobile-first checkout design, this article reveals the tools and tactics that can take your online store to the next level. </span></p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li data-start=\"564\" data-end=\"822\">E-commerce is evolving faster than ever.</li>\r\n<li data-start=\"564\" data-end=\"822\">Learn how artificial intelligence,&nbsp;chatbots, and automated marketing systems are transforming.</li>\r\n<li data-start=\"564\" data-end=\"822\">How customers browse, buy, and interact with brands.</li>\r\n<li data-start=\"564\" data-end=\"822\">How your business can stay ahead of the curve.</li>\r\n</ul>', 'blog_68e77f20b71a48.72131867.jpg', '2025-10-05 13:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(255) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `coupon_discount` varchar(50) NOT NULL,
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `coupon_name`, `coupon_code`, `coupon_discount`, `free_shipping`, `created_at`) VALUES
(1, 'Flat 15%', 'WGZWPAYXN4', '15', 0, '2025-08-30 11:43:37'),
(2, 'Flat 25%', 'RKKXSO50PQ', '25', 0, '2025-08-30 12:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `customized_category`
--

CREATE TABLE `customized_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customized_category`
--

INSERT INTO `customized_category` (`id`, `category_name`, `category_slug`, `created_at`) VALUES
(1, 'AR Special Kit', 'ar-special-kit', '2025-10-16 08:56:05'),
(2, 'Cricket', 'cricket', '2025-10-16 08:56:14'),
(3, 'Football', 'football', '2025-10-16 08:56:19'),
(4, 'Badminton', 'badminton', '2025-10-16 08:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `customized_orders`
--

CREATE TABLE `customized_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_address` text NOT NULL,
  `city_address` varchar(50) DEFAULT NULL,
  `jersey_name` varchar(100) DEFAULT NULL,
  `jersey_num` int(11) DEFAULT NULL,
  `jersey_type` varchar(100) DEFAULT NULL,
  `jersey_size` varchar(10) DEFAULT NULL,
  `order_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `acc_number` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `order_note` text NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_visibility` varchar(50) DEFAULT 'Show'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customized_orders`
--

INSERT INTO `customized_orders` (`id`, `user_id`, `user_full_name`, `user_phone`, `user_email`, `user_address`, `city_address`, `jersey_name`, `jersey_num`, `jersey_type`, `jersey_size`, `order_no`, `product_id`, `payment_method`, `acc_number`, `transaction_id`, `order_note`, `order_date`, `order_status`, `order_visibility`) VALUES
(1, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', NULL, NULL, '', NULL, 'ORD-1760771926278-532', 1, 'Cash On Delivery', '', '', 'No additional notes', '2025-10-18 13:12:31', 'Completed', 'Show'),
(2, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', NULL, NULL, '', NULL, 'ORD-1760772040284-464', 2, 'bKash', '01898989898', '3258XYZXYZ', 'etsryghf', '2025-10-18 13:14:25', 'Processing', 'Show'),
(3, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', NULL, NULL, '', NULL, 'ORD-1760783946378-623', 2, 'bKash', '0187423656', 'uireghf83452', 'x-50', '2025-10-18 16:39:06', 'Pending', 'Show'),
(4, 0, 'Md Jony', '01559907883', 'fardin@gmail.com', 'Dhanmondi', 'Dhaka', NULL, NULL, '', NULL, 'ORD-1760783979579-941', 1, 'Cash On Delivery', '', '', 'L-20', '2025-10-18 16:39:39', 'Cancelled', 'Show'),
(5, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', NULL, NULL, '', NULL, 'ORD-1760785316538-319', 1, 'Cash On Delivery', '', '', 'No additional notes', '2025-10-18 17:01:56', 'Processing', 'Show'),
(6, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', NULL, NULL, '', NULL, 'ORD-1760785340649-273', 1, 'Cash On Delivery', '', '', 'No additional notes', '2025-10-18 17:02:20', 'Pending', 'Show'),
(7, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', 'Fardin', 55, 'Half-Sleeve', 'M', 'ORD-1760877020929-103', 5, 'Cash On Delivery', '', '', 'X-1', '2025-10-19 18:30:20', 'Pending', 'Show'),
(8, 0, 'Fardin Ahmed', '01944667461', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', 'Tanvin', 55, 'Half-Sleeve', 'M', 'ORD-1760942307767-782', 5, 'Cash On Delivery', '', '', 'No additional notes', '2025-10-20 12:38:27', 'Pending', 'Show'),
(9, 0, 'Fardin Ahmed', '01944667441', '', 'Dhanmondi', 'Keraniganj', 'Tanvin', 55, 'Half-Sleeve', '', 'ORD-1760942341864-386', 5, 'Cash On Delivery', '', '', '1pc', '2025-10-20 12:39:01', 'Cancelled', 'Show'),
(10, 0, 'Fardin Ahmed', '01944667441', 'fardin@gmail.com', 'Dhanmondi', 'Keraniganj', 'Tanvin', 55, 'Full-Sleeve', 'XS', 'ORD-1760943101954-719', 5, 'Cash On Delivery', '', '', 'No additional notes', '2025-10-20 12:51:41', 'Pending', 'Show'),
(11, 0, 'Md Jony', '01559907883', 'fardin@gmail.com', 'Dhanmondi', 'Dhaka', 'Tanvin', 55, 'Half-Sleeve', 'L', 'ORD-1761201677106-26', 2, 'bKash', '01898989898', '3258XYZXYZ', 'No additional notes', '2025-10-23 12:41:17', 'Pending', 'Show');

-- --------------------------------------------------------

--
-- Table structure for table `customized_payments`
--

CREATE TABLE `customized_payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customized_payments`
--

INSERT INTO `customized_payments` (`id`, `order_id`, `order_amount`, `paid_amount`, `created_at`) VALUES
(2, 2, 25000, 5000, '2025-10-18 12:14:54'),
(4, 6, 26500, 0, '2025-10-18 12:31:09'),
(5, 10, 570, 300, '2025-10-20 06:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `customized_products`
--

CREATE TABLE `customized_products` (
  `id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `advance_amount` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) DEFAULT NULL,
  `product_img3` varchar(255) DEFAULT NULL,
  `product_img4` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customized_products`
--

INSERT INTO `customized_products` (`id`, `product_title`, `category_id`, `price`, `advance_amount`, `product_code`, `product_description`, `product_img`, `product_img2`, `product_img3`, `product_img4`, `product_slug`, `created_at`) VALUES
(1, 'Black Pink Football Kit', 3, 620, 0, 'FC25', '<h3>Specifications</h3>\r\n<div>\r\n<ul style=\"list-style-type: none;\">\r\n<li>✔ Fully Digital Sublimation Printed.</li>\r\n<li>✔ Regular Fit.</li>\r\n<li>✔ Drop Shoulder Sleeve.</li>\r\n<li>✔ Crew Neck.</li>\r\n<li>✔ Twin Needle Topstitch Sewing.</li>\r\n<li>✔ High-Performance Lurex Mesh Fabric.</li>\r\n<li>✔ 145-150 GSM.</li>\r\n<li>✔ Circular Hem.</li>\r\n<li>✔ With Customized Name And Number.</li>\r\n<li>✔ Knitted Elastic Collar, Bottom Rib and Cuffs.</li>\r\n</ul>\r\n</div>', 'uploads/customized_products/prod_68f0c2b0b0a800.07730302.jpeg', 'uploads/customized_products/prod_68f4cb055bbeb3.11106676.jpeg', 'uploads/customized_products/prod_68f4bf3cb7c534.13285279.jpeg', 'uploads/customized_products/prod_68f0c35d5bfcf8.19549116.jpeg', 'black-pink-football-kit', '2025-10-16 10:02:24'),
(2, 'Black White Badminton Jercy', 4, 580, 580, 'BDM7132543', '<p><b>Specifications</b></p><p></p><ul></ul><p></p><p style=\"font-size: 16px;\"></p><ul></ul><p></p><p>✔ Fully Digital Sublimation Printed.</p><p>✔ Regular Fit.</p><p>✔ Drop Shoulder Sleeve.</p><p>✔ Crew Neck.</p><p>✔ Twin Needle Topstitch Sewing.</p><p>✔ High-Performance Lurex Mesh Fabric.</p><p>✔ 145-150 GSM.</p><p>✔ Circular Hem.</p><p>✔ With Customized Name And Number.</p><p>✔ Knitted Elastic Collar, Bottom Rib and Cuffs.</p>', 'uploads/customized_products/prod_68f0c35d5bfcf8.19549116.jpeg', 'uploads/customized_products/prod_68f4bf3cb7c534.13285279.jpeg', 'uploads/customized_products/prod_68f0c35d5bfcf8.19549116.jpeg', 'uploads/customized_products/prod_68f0c2b0b0a800.07730302.jpeg', 'black-white-badminton-jercy', '2025-10-16 10:05:17'),
(4, 'Blue White Special Kit', 1, 700, 0, 'AR784', '<p style=\"list-style-type: disc;\">✔ Fully Digital Sublimation Printed.</p>\r\n<p style=\"list-style-type: disc;\">✔ Regular Fit.</p>\r\n<p style=\"list-style-type: disc;\">✔ Drop Shoulder Sleeve.</p>\r\n<p style=\"list-style-type: disc;\">✔ Crew Neck.</p>\r\n<p style=\"list-style-type: disc;\">✔ Twin Needle Topstitch Sewing.</p>\r\n<p style=\"list-style-type: disc;\">✔ High-Performance Lurex Mesh Fabric.</p>\r\n<p style=\"list-style-type: disc;\">✔ 145-150 GSM.</p>\r\n<p style=\"list-style-type: disc;\">✔ Circular Hem.</p>\r\n<p style=\"list-style-type: disc;\">✔ With Customized Name And Number.</p>\r\n<p style=\"list-style-type: disc;\">✔ Knitted Elastic Collar, Bottom Rib and Cuffs.</p>', 'uploads/customized_products/prod_68f4bf3cb7c534.13285279.jpeg', 'uploads/customized_products/prod_68f0c35d5bfcf8.19549116.jpeg', 'uploads/customized_products/prod_68f0c2b0b0a800.07730302.jpeg', 'uploads/customized_products/prod_68f4cb055bbeb3.11106676.jpeg', 'blue-white-special-kit', '2025-10-19 10:36:44'),
(5, 'AR Badminton Jersey Kit', 4, 570, 0, 'AR43645', '<p style=\"list-style-type: disc;\">✔ Fully Digital Sublimation Printed.</p>\r\n<p style=\"list-style-type: disc;\">✔ Regular Fit.</p>\r\n<p style=\"list-style-type: disc;\">✔ Drop Shoulder Sleeve.</p>\r\n<p style=\"list-style-type: disc;\">✔ Crew Neck.</p>\r\n<p style=\"list-style-type: disc;\">✔ Twin Needle Topstitch Sewing.</p>\r\n<p style=\"list-style-type: disc;\">✔ High-Performance Lurex Mesh Fabric.</p>\r\n<p style=\"list-style-type: disc;\">✔ 145-150 GSM.</p>\r\n<p style=\"list-style-type: disc;\">✔ Circular Hem.</p>\r\n<p style=\"list-style-type: disc;\">✔ With Customized Name And Number.</p>\r\n<p style=\"list-style-type: disc;\">✔ Knitted Elastic Collar, Bottom Rib and Cuffs.</p>', 'uploads/customized_products/prod_68f4cb055bbeb3.11106676.jpeg', 'uploads/customized_products/prod_68f4cb05699f85.67773444.jpeg', 'uploads/customized_products/prod_68f4cb055bbeb3.11106676.jpeg', 'uploads/customized_products/prod_68f4cb05699f85.67773444.jpeg', 'ar-badminton-jersey-kit', '2025-10-19 11:27:01');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `purchase_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` varchar(50) NOT NULL,
  `free_shipping` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `purchase_amount`, `discount_amount`, `free_shipping`, `created_at`) VALUES
(1, 500.00, '50', 0, '2025-10-01 15:52:38'),
(2, 1000.00, '150', 1, '2025-10-01 15:52:50'),
(3, 2000.00, '350', 1, '2025-10-01 15:53:05'),
(4, 5000.00, '500', 1, '2025-10-01 15:53:21'),
(5, 750.00, '75', 1, '2025-10-01 16:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`category_id`, `category_name`, `created_at`) VALUES
(1, 'Office Rent', '2025-09-10 15:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `expense_info`
--

CREATE TABLE `expense_info` (
  `expense_id` int(11) NOT NULL,
  `expense_title` varchar(255) NOT NULL,
  `expense_category` varchar(100) NOT NULL,
  `expense_amount` decimal(10,2) NOT NULL,
  `expense_description` text DEFAULT NULL,
  `expense_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature_title` varchar(255) NOT NULL,
  `feature_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `product_id`, `feature_title`, `feature_description`, `created_at`) VALUES
(1, 10, 'Innovative technology', 'It will be provide a innovation that made by us\r\n\r\n', '2025-09-14 05:18:24'),
(3, 18, 'Feature 1', 'Feature 1 Description', '2025-09-14 08:28:39'),
(4, 18, 'Feature 2', 'Feature 2 Description', '2025-09-14 08:28:39'),
(5, 18, 'Feature 3', 'Feature 3 Description', '2025-09-14 11:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `footer_info`
--

CREATE TABLE `footer_info` (
  `id` int(11) NOT NULL,
  `about_us` text NOT NULL,
  `contact_us` text NOT NULL,
  `faq` text NOT NULL,
  `terms_of_use` text NOT NULL,
  `privacy_policy` text NOT NULL,
  `shipping_delivery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_info`
--

INSERT INTO `footer_info` (`id`, `about_us`, `contact_us`, `faq`, `terms_of_use`, `privacy_policy`, `shipping_delivery`) VALUES
(1, '                                                                                                                                                                                                                                <div><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:\r\n11.0pt\">About Easy Tech</span></b></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:\r\n11.0pt\"><o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\"><br></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\">Welcome\r\nto Easy Tech Solutions</p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\">At\r\nLioo, we donâ€™t just make leather goodsâ€” we create pieces that carry meaning.\r\nEvery item is thoughtfully designed, handcrafted with skill and made to stand\r\nthe test of time. We believe in blending style, durability and tradition\r\nensuring that each piece becomes a part of your story. No shortcuts, no\r\ncompromisesâ€” just pure craftsmanship.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\">For\r\nus, itâ€™s simple: made by hand, meant for the heart.</p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\"><o:p><br></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0in;margin-bottom:.0001pt;\r\ntext-align:center;line-height:150%\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:11.0pt;line-height:150%\">Our Story</span></b></p><p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0in;margin-bottom:.0001pt;\r\ntext-align:center;line-height:150%\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:11.0pt;line-height:150%\"><o:p><br></o:p></span></b></p><p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0in;margin-bottom:.0001pt;\r\ntext-align:center;line-height:150%\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:11.0pt;line-height:150%\"><o:p><br></o:p></span></b></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">I\'m\r\nSerazees Salekin and this is how Lioo came to life.<o:p></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">Lioo\r\nwasnâ€™t built overnight. It started with a simple idea and a deep appreciation\r\nfor craftsmanship. But more than anything, it was built with the support of the\r\npeople around me. Family has always been my greatest strength and without them,\r\nnone of this would have been possible.<o:p></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">From\r\nthe very beginning, my brothers stood by me, always ready to help, no matter\r\nthe challenge. Their dedication and hard work shaped Lioo into what it is\r\ntoday. And then thereâ€™s Tilok Dadaâ€”more than just a friend, heâ€™s been like a\r\nbig brother, guiding and supporting us every step of the way.<o:p></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">Before\r\nI even thought about leather crafting, someone introduced me to it. That was\r\nthe starting pointâ€”the moment I realized this could be more than just a skill,\r\nbut a true craft worth pursuing.<o:p></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">Starting\r\nsomething new is never easy. There were struggles, setbacks and moments of\r\ndoubt. But through it all, we kept going, fueled by our love for the craft and\r\nthe desire to create something meaningful. Every product we make carries a\r\npiece of that journey. Nothing leaves our hands unless weâ€™re truly proud of it,\r\nbecause real craftsmanship isnâ€™t just about making somethingâ€”itâ€™s about making\r\nsomething that lasts.<o:p></o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:normal\"><o:p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</o:p></p><p class=\"MsoNormal\" align=\"center\" style=\"text-align:center;line-height:150%\">Lioo\r\nisnâ€™t just a brand. Itâ€™s a reflection of passion, perseverance and the people\r\nwho helped build it. From our hands to your heart, this is just the\r\nbeginningâ€”and weâ€™re honored to have you be a part of it.</p></div>                                                                                                                                                                                                                ', '                                                                                                                                                                        <p class=\"MsoNormal\" style=\"text-align: center; line-height: normal;\">Have a question or need\r\nassistance? We\'re here to help. Feel free to reach out anytime.<o:p></o:p></p><p class=\"MsoNormal\" style=\"text-align: center; line-height: normal;\"><b>Email: easytechx@gmail.com</b></p><p class=\"MsoNormal\" style=\"text-align: center; line-height: normal;\"><b><o:p></o:p></b></p><p class=\"MsoNormal\" style=\"text-align: center; line-height: normal;\"><b>Hotline &amp; WhatsApp: +880 19XXXXXXXX</b><o:p></o:p></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\" style=\"text-align: center; line-height: normal;\">We aim to respond as soon as\r\npossible. Let us know how we can assist you.<o:p></o:p></p>                                                                                                                                                            ', '                                                                                                                                            <div><p class=\"MsoNormal\"><b>Q: Do you use genuine\r\nleather?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Yes, all of our products are made from 100% genuine\r\nexport grade leather. We take pride in using the finest quality leather that\r\nages beautifully and adds character over time.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: What is oil pull-up\r\nleather and how does it age?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Oil pull-up leather is a type of leather that is infused\r\nwith oils and waxes which gives it a rich, luxurious feel. It may show\r\nscratches or a slight rusty appearance initially but don\'t worryâ€”this is a\r\nnatural part of the leather\'s aging process. Over time, with use the scratches\r\nand marks will fade and the leather will develop a beautiful patina, enhancing\r\nits character. This is the charm of oil pull-up leatherâ€”it only gets better\r\nwith time!<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: How do I care for\r\nmy Lioo leather product?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Leather gets better with time if cared for properly. Keep\r\nit away from direct sunlight, moisture and sharp objects. Use a leather\r\nconditioner occasionally to maintain its shine and texture.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you offer\r\ncustom designs?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Yes! If you have a specific design in mind, weâ€™d love to\r\nbring it to life. Custom orders take 8-10 business days to craft.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you charge\r\nextra for custom products?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Yes, customized products may incur an additional charge\r\nbased on the complexity and materials required for your unique design. Weâ€™ll\r\nprovide you with a clear quote before you place your order to ensure there are\r\nno surprises.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: What payment\r\nmethods do you accept?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: We accept cash on delivery, as well as mobile banking\r\noptions like Bkash, Nagad,&nbsp;<span style=\"font-weight: initial;\">Rocket</span><span style=\"font-size: 0.9375rem; font-weight: initial;\">&nbsp;and Upay. Bank transfers are also available upon\r\nrequest.</span></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you offer gift\r\npackaging?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Absolutely! If you\'re purchasing a Lioo product as a\r\ngift, we offer premium gift packaging for an additional charge. Just let us\r\nknow at checkout.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: How long will it\r\ntake to receive my order?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Once your order is processed (within 2-3 business days),\r\nit will be delivered in 5-7 business days. For customized products, it may take\r\nup to 8-10 business days to craft and ship.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you offer\r\nwholesale pricing?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Currently, we don\'t offer wholesale pricing but we\'re\r\nalways open to collaborating. If youâ€™re interested in purchasing large\r\nquantities or have a special request, please contact us directly.</p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you have a\r\nphysical store?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Not yet, but we\'re working on it! For now, weâ€™re\r\nonline-only but with your support, we hope to open a store in the future. Stay\r\nwith usâ€”weâ€™d love to have you visit one day!<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: Do you ship\r\noutside of Bangladesh?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: At the moment, we only deliver within Bangladesh. Weâ€™re\r\nworking on expanding to other regions, so stay tuned for future updates!<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: What should I do\r\nif I received a defective product?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: Weâ€™re committed to quality but if you receive a defective\r\nitem, please reach out to us immediately via email or WhatsApp with photos of\r\nthe product. Weâ€™ll arrange a return or exchange as quickly as possible.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><b>Q: I still have more\r\nquestions. What should I do?<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\">A: No worries! If you canâ€™t find the answer youâ€™re looking\r\nfor, feel free to reach out to us via email or WhatsApp and weâ€™ll be happy to\r\nassist you. Your satisfaction is our top priority!<br>\r\n<!--[if !supportLineBreakNewLine]--><br>\r\n<!--[endif]--><o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\"><b><span style=\"font-size:14.0pt;mso-bidi-font-size:11.0pt;line-height:\r\n107%\">Additional Information<o:p></o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\">At Lioo, every\r\nleather item is carefully handcrafted with attention to detail. Because leather\r\nis a natural material, no two products will ever look exactly the same. Each\r\npiece of leather has its own unique texture, grain and even small imperfections,\r\nwhich makes every item special.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\"><b>Leather Availability &amp; Substitutions<o:p></o:p></b></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\">Leather availability\r\ncan vary depending on demand and supply. If we run out of a particular leather\r\ntype, weâ€™ll be happy to suggest a similar alternative that maintains the same\r\nquality and craftsmanship you expect from Lioo.<o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\">Some leather types\r\nmay take a bit longer to source, sometimes taking weeks to arrive. If your\r\ncustom order requires a more exclusive leather, weâ€™ll keep you updated on any\r\ndelays so youâ€™re always in the loop.<o:p></o:p></p></div>                                                                                                                                  ', '                                                                                                                                            <p><span style=\"font-size: 0.9375rem; font-weight: initial;\">Welcome to Lioo! By visiting our website and making a\r\npurchase, youâ€™re agreeing to the terms and conditions outlined below. These are\r\nhere to protect both you and us, ensuring smooth transactions. We encourage you\r\nto read them carefully before placing any order.</span></p><p class=\"MsoNormal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\"><b>1. Orders &amp; Payments</b></p><ul><li>All prices on our website are in BDT (Bangladeshi Taka) and these can change without prior notice, so it\'s always good to double-check before checkout.</li><li>We offer several payment options for your convenience, including Cash on Delivery, Bank Transfers, Bkash, Nagad, Rocket and Upay.</li><li>We typically process your order within 2-3 business days and aim to deliver it to you in 5-7 business days. For customized orders, please note it may take 8-10 business days, depending on the design and availability of materials.</li></ul><p class=\"MsoNormal\"><b>&nbsp;</b></p><p class=\"MsoNormal\"><b>2. Shipping &amp; Delivery</b></p><ul><li>We deliver all over Bangladeshâ€”whether youâ€™re in Dhaka, Chittagong or elsewhere, weâ€™ve got you covered.</li><li>While we make every effort to meet our delivery estimates, sometimes unforeseen circumstances like weather, supply chain delays or courier issues can cause delays. We appreciate your understanding in such cases.</li><li>Please double-check that youâ€™ve provided the correct shipping address. If thereâ€™s any mistake on your part, Lioo cannot be held responsible for delivery problems.</li></ul><p class=\"MsoNormal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNoSpacing\"><b>3. Return &amp; Exchange Policy</b></p><ul><li>Upon delivery, we kindly ask you to check your product. If thereâ€™s an issue, let the delivery person know immediately so we can address it as soon as possible.</li><li>After the delivery is completed and accepted, we unfortunately cannot process returns or exchanges.</li></ul><p class=\"MsoNormal\" style=\"margin-left:.25in\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\"><b>4. Product Authenticity &amp; Craftsmanship</b></p><p class=\"MsoNormal\">Every product at Lioo is made from genuine leather, carefully crafted by skilled artisans. Because leather is a natural material, each item is one-of-a-kind and you may notice slight variations in color, texture or grainâ€”thatâ€™s the beauty of real leather!</p><ul><li>As time passes, leather develops a patina that adds character to your product. Taking proper care of your item will help preserve its quality.</li></ul><p class=\"MsoNormal\" style=\"margin-left:.25in\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\"><b>5. Privacy &amp; Data\r\nProtection</b></p><ul><li><span style=\"font-size: 0.9375rem; text-indent: -0.25in; font-weight: initial;\">Your privacy matters to us. We take every measure to safeguard your personal information.</span></li><li><span style=\"font-size: 0.9375rem; text-indent: -0.25in; font-weight: initial;\">Lioo never sells, shares or trades your personal details with third parties. Payment processing is done securely through trusted payment gateways.</span></li></ul><p class=\"MsoNormal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\"><b>6. Intellectual\r\nProperty Rights<o:p></o:p></b></p><p class=\"MsoNormal\">All designs, logos, images and content on our website are\r\nthe exclusive property of Lioo. Reproducing or using any of these materials\r\nwithout our permission is strictly prohibited.<o:p></o:p></p><p class=\"MsoNormal\"><o:p>&nbsp;</o:p></p><p class=\"MsoNormal\"><b>7. Amendments to Terms\r\n&amp; Conditions<o:p></o:p></b></p><p class=\"MsoNormal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\">Lioo reserves the right to modify these terms at any time.\r\nIf we make any changes, weâ€™ll update this page. By continuing to use our\r\nwebsite, you agree to the updated terms.<o:p></o:p></p>                                                                                                                                  ', '                                                                                    <p><b>1. Information We Collect</b></p><p>When you visit our website or make a purchase, we gather a few details to ensure smooth service. These include:</p><ul><li>Your name, phone number, email address, and shipping address.</li><li>Payment details, which are securely processed through trusted payment partners.</li></ul><p><b><br></b></p><p><b>2. How We Use Your Information</b></p><p>We take the information you provide and use it for several reasons, including:</p><ul><li>Processing and delivering your orders quickly and accurately.</li><li>Improving our website and services to provide you with a better shopping experience.</li><li>Sending you order updates or promotional offers (but only if youâ€™ve opted in to receive them).</li></ul><p><b><br></b></p><p><b>3. Data Security</b></p><p>Your security is important to us, which is why we use encryption and security measures to protect your personal data.</p><ul><li>Payment details are never stored by usâ€”every transaction is processed securely through trusted payment providers to ensure your privacy.</li></ul><p><b><br></b></p><p><b>4. Sharing of Information</b></p><p>We respect your privacy and do not sell or share your personal information with anyone outside of our company.</p><ul><li><span style=\"font-size: 0.875rem; font-weight: initial;\">The only time we might share your details is with our delivery partners, to ensure your order reaches you in the best possible condition.</span></li></ul><p><b><br></b></p><p><b>5. Cookies &amp; Tracking</b></p><p>To improve your shopping experience, we use cookies. These small files help us remember your preferences and offer personalized recommendations.</p><ul><li>You can always choose to disable cookies through your browser settings, but keep in mind that this might affect your shopping experience on our site.</li></ul><p><br></p><p>From time to time, we may make updates to our privacy policy to keep it current. When we do, weâ€™ll post the changes right here for you to see.</p><div><br></div>                                                                              ', '                                                                                    <p class=\"MsoNormal\"><b>Shipping &amp; Delivery&nbsp;Policy</b></p><p class=\"MsoNormal\">We proudly deliver all over Bangladesh, making it easy for you to receive your Lioo product no matter where you are.</p><ul><li>Order Processing: We aim to process all orders within 2-3 business days.</li><li>Standard Delivery: Once processed, your order will arrive within 5-7 business days.</li><li>For custom products, we need a bit more time to make them just right, so expect delivery to take up to 8-10 business days.</li></ul><p class=\"MsoNormal\">We work with trusted courier partners to make sure your items arrive safely and on time. If you ever have any questions or concerns during the shipping process, donâ€™t hesitate to reach out.</p><p class=\"MsoNormal\"><br></p><p class=\"MsoNormal\"><b>Return &amp; Exchange Policy</b></p><p class=\"MsoNormal\">Your satisfaction means the world to us! Thatâ€™s why we ask you to carefully check your product upon delivery. If thereâ€™s an issue, please let the delivery person know right away.</p><p class=\"MsoNormal\">Once the delivery is complete and accepted, we unfortunately cannot process returns or exchanges.</p><p class=\"MsoNormal\">While we always ensure the best quality craftsmanship, if you ever face any concerns, weâ€™re here to help. Reach out to us, and weâ€™ll do everything we can to assist you.</p>                                                                              ');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gallery_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`image_id`, `product_id`, `gallery_image`) VALUES
(2, 18, 'uploads/68c67cb797b33_ss.jpg'),
(3, 18, 'uploads/68c67cb79c949_s.jpg'),
(4, 10, 'uploads/68c6a2a604826_iphone-17-pro-max-pakistan-price.jpg'),
(6, 10, 'uploads/68c6a4c2b8d1e_iphone_17_pro_max_95acfd07-44a1-4cf8-90a8-e784f309befb.webp'),
(7, 10, 'uploads/68c6a63f70cff_iphone-17-pro-max-visor-camera-design-render-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `home_title` varchar(255) NOT NULL,
  `home_description` text NOT NULL,
  `home_img` varchar(255) NOT NULL,
  `feature_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landing_pages`
--

INSERT INTO `landing_pages` (`id`, `product_id`, `product_slug`, `home_title`, `home_description`, `home_img`, `feature_img`) VALUES
(1, 10, 'iphone-16-pro-inactive-usa-512gb', 'Iphone is the best product of apple ever.', 'Android and iOS Support GPS & Health Tracker Read & reply to messages Compatible with all devices\r\n', 'uploads/68c6a2a5d5bb2_iphone-17-pro-max-visor-camera-design-render-3.jpg', 'uploads/68c6a2a5e95f0_Apple-iPhone-17-Pro-camera-close-up-250909_big.jpg.large.jpg'),
(2, 18, 'women-premium-tops-parishas', 'This is Home Title women-premium-tops-parishas', 'This is Home Description for  women-premium-tops-parishas', 'uploads/68c67cb773a12_s.jpg', 'uploads/68c67cb785ad0_ss.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE `main_category` (
  `main_ctg_id` int(11) NOT NULL,
  `main_ctg_name` varchar(100) NOT NULL,
  `main_ctg_des` text DEFAULT NULL,
  `main_ctg_img` varchar(255) DEFAULT NULL,
  `main_ctg_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`main_ctg_id`, `main_ctg_name`, `main_ctg_des`, `main_ctg_img`, `main_ctg_slug`) VALUES
(1, 'Mens Fashion', 'All The Men\'s Product You Will Find Here', '../img/compressed_67c4ecd06e2da-square.jpg', 'mens-fashion'),
(2, 'Womens Fashion', 'All The Women\'s Product You Will Find Here', '../img/compressed_67dc35b5a0fc5-square.png', 'womens-fashion'),
(4, 'Gadget & Electronics', 'All The Gadget & Electronics Product You Will Find Here', '../img/compressed_compressed_tech-gift-for-him-2022-metapod.webp', 'gadget-electronics'),
(5, 'Home Appliances', 'All The Home Appliances Product You Will Find Here', '../img/compressed_home appliances 01_AdobeStock_329321873.jpeg', 'home-appliances');

-- --------------------------------------------------------

--
-- Table structure for table `mockup_category`
--

CREATE TABLE `mockup_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mockup_category`
--

INSERT INTO `mockup_category` (`id`, `category_name`, `category_slug`, `created_at`) VALUES
(1, 'AR Mockup Kit', 'ar-mockup-kit', '2025-10-22 09:37:22'),
(2, 'Cricket Jersey Designs', 'cricket-jersey-designs', '2025-10-22 09:46:22'),
(3, 'Football Jersey Designs', 'football-jersey-designs', '2025-10-22 09:46:30'),
(4, 'Badminton Jersey Designs', 'badminton-jersey-designs', '2025-10-22 09:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `mockup_orders`
--

CREATE TABLE `mockup_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `city_address` varchar(50) DEFAULT NULL,
  `team_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_visibility` varchar(50) DEFAULT 'Show'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mockup_orders`
--

INSERT INTO `mockup_orders` (`id`, `user_id`, `user_full_name`, `user_phone`, `user_email`, `user_address`, `city_address`, `team_name`, `quantity`, `order_no`, `product_id`, `payment_method`, `order_note`, `order_date`, `order_status`, `order_visibility`) VALUES
(2, 0, 'Fardin Shawon', '01944667441', '', 'Apishpara, Ati Bazar, Dhaka', 'Dhaka', 'Team Feluda', 1, 'MOCK-1234', 2, 'Cash On Delivery', 'Delivery ', '2025-10-23 12:29:16', 'Pending', 'Show'),
(3, 0, 'Md Jony', '01559907883', 'fardin@gmail.com', 'Dhanmondi', 'Dhaka', 'Team XYZ', 2, 'MOCK-1761200998320-691', 2, 'Cash On Delivery', 'No note', '2025-10-23 12:29:58', 'Processing', 'Show'),
(4, 0, 'Fardin Ahmed', '01944667491', '', 'Dhanmondi', 'Keraniganj', 'Team Billa', 5, 'MOCK-1761201559041-854', 2, 'Cash On Delivery', 'No note', '2025-10-23 12:39:19', 'Completed', 'Show');

-- --------------------------------------------------------

--
-- Table structure for table `mockup_products`
--

CREATE TABLE `mockup_products` (
  `id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) DEFAULT NULL,
  `product_img3` varchar(255) DEFAULT NULL,
  `product_img4` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mockup_products`
--

INSERT INTO `mockup_products` (`id`, `product_title`, `category_id`, `product_code`, `product_description`, `product_img`, `product_img2`, `product_img3`, `product_img4`, `product_slug`, `created_at`) VALUES
(2, 'Football Jersey Mockup Design', 3, 'BDM7132543', '<ul><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Fully Digital Sublimation Printed.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Regular Fit.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Drop Shoulder Sleeve.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Crew Neck.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Twin Needle Topstitch Sewing.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">High-Performance Lurex Mesh Fabric.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">145-150 GSM.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Circular Hem.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">With Customized Name And Number.</li><li style=\"font-family: Poppins, sans-serif; list-style: disc;\">Knitted Elastic Collar, Bottom Rib and Cuffs.</li></ul>', 'uploads/mockup_products/mockup_68f8b68791f6b2.65011616.jpeg', '', '', '', 'football-jersey-mockup-design', '2025-10-22 10:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `order_discount_list`
--

CREATE TABLE `order_discount_list` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `total_order_amount` decimal(10,2) NOT NULL,
  `total_discount_amount` decimal(10,2) NOT NULL,
  `free_shipping` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_discount_list`
--

INSERT INTO `order_discount_list` (`id`, `invoice_no`, `total_order_amount`, `total_discount_amount`, `free_shipping`, `created_at`) VALUES
(3, 'INV-68PP9G1B8', 485.00, 0.00, 0, '2025-10-21 17:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `order_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` text NOT NULL,
  `city_address` varchar(50) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_size` varchar(50) DEFAULT 'Default',
  `total_price` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_note` text DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_visibility` varchar(50) DEFAULT 'Show'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_no`, `user_id`, `user_full_name`, `user_phone`, `user_email`, `user_address`, `city_address`, `invoice_no`, `product_id`, `product_title`, `product_quantity`, `product_size`, `total_price`, `payment_method`, `order_note`, `order_date`, `order_status`, `order_visibility`) VALUES
(3, 0, 'Md Jony', '01559907883', 'fardin@gmail.com', 'Dhanmondi, Dhaka, Bangladesh', 'Inside Dhaka', 'INV-68PP9G1B8', 6, 'Mens Premium Blank T-shirt', 1, '', 485, 'Cash On Delivery', NULL, '2025-10-21 17:57:30', 'Processing', 'Show');

-- --------------------------------------------------------

--
-- Table structure for table `page_access`
--

CREATE TABLE `page_access` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `dashboard` int(11) NOT NULL DEFAULT 1,
  `product` int(11) NOT NULL DEFAULT 0,
  `categories` int(11) NOT NULL DEFAULT 0,
  `slider` int(11) NOT NULL DEFAULT 0,
  `banner` int(11) NOT NULL DEFAULT 0,
  `discounts` int(11) NOT NULL DEFAULT 0,
  `coupons` int(11) NOT NULL DEFAULT 0,
  `customers` int(11) NOT NULL DEFAULT 0,
  `orders` int(11) NOT NULL DEFAULT 0,
  `payments` int(11) NOT NULL DEFAULT 0,
  `accounts` int(11) NOT NULL DEFAULT 0,
  `inventory` int(11) DEFAULT 0,
  `invoice` int(11) DEFAULT 0,
  `courier` int(11) DEFAULT 0,
  `history` int(11) DEFAULT 0,
  `settings` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_access`
--

INSERT INTO `page_access` (`id`, `role_id`, `dashboard`, `product`, `categories`, `slider`, `banner`, `discounts`, `coupons`, `customers`, `orders`, `payments`, `accounts`, `inventory`, `invoice`, `courier`, `history`, `settings`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 1),
(4, 4, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parcel_info`
--

CREATE TABLE `parcel_info` (
  `parcel_id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `tracking_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pathao_acc_info`
--

CREATE TABLE `pathao_acc_info` (
  `id` int(11) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `client_secret` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `grant_type` varchar(50) DEFAULT 'password',
  `store_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pathao_parcel_info`
--

CREATE TABLE `pathao_parcel_info` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `consignment_id` varchar(255) DEFAULT NULL,
  `delivery_fee` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pathao_parcel_info`
--

INSERT INTO `pathao_parcel_info` (`id`, `invoice_no`, `consignment_id`, `delivery_fee`, `created_at`) VALUES
(1, 'INV-68PP9G1B8', 'DA211025SN9LPC', 110, '2025-10-21 11:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `serial_no` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `order_no` int(11) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `order_visibility` varchar(50) DEFAULT 'Show',
  `payment_method` varchar(50) NOT NULL,
  `acc_number` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'Unpaid'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_purchase_price` int(11) NOT NULL,
  `product_regular_price` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `main_ctg_id` int(11) NOT NULL,
  `sub_ctg_id` int(11) NOT NULL,
  `available_stock` int(11) NOT NULL,
  `size_option` varchar(50) DEFAULT NULL,
  `product_keyword` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_short_description` text DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_img1` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) DEFAULT NULL,
  `product_img3` varchar(255) DEFAULT NULL,
  `product_img4` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_type` text NOT NULL,
  `product_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`product_id`, `product_title`, `product_purchase_price`, `product_regular_price`, `product_price`, `main_ctg_id`, `sub_ctg_id`, `available_stock`, `size_option`, `product_keyword`, `product_code`, `product_short_description`, `product_description`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `created_at`, `product_type`, `product_slug`) VALUES
(1, 'Mens Premium Shirt - Designer Edition', 0, 1890, 1450, 1, 1, 31, 'Default', 'shirt', '436546u', '', '<p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Made of premium grade cotton. Stitched with intensive care.&nbsp;Slim-fit shirt in woven fabric with an easy-iron finish.</p><ul style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><li style=\"box-sizing: inherit;\">Y Fit/Slim fit collar shirt</li><li style=\"box-sizing: inherit;\">Turn-down collar, classic button placket.</li><li style=\"box-sizing: inherit;\">Long sleeves with adjustable buttoning at cuffs and a sleeve placket with a link button.</li><li style=\"box-sizing: inherit;\">Gently rounded hem</li></ul> ', '../img/compressed_653e61e89a66d-square.jpeg', NULL, NULL, NULL, '2025-04-18 15:55:24', 'new_arrival', 'mens-premium-shirt-designer-edition'),
(2, 'Mens Premium Shirt - Urban', 0, 2500, 2290, 1, 1, 37, 'Default', 'shirt', '457665uj', '<p style=\"box-sizing: inherit; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px; color: rgb(55, 58, 60);\"><br></p><ul style=\"box-sizing: inherit; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px; color: rgb(55, 58, 60);\"><li style=\"box-sizing: inherit;\">Y Fit/Slim fit collar shirt</li><li style=\"box-sizing: inherit;\">Turn-down collar, classic button placket.</li><li style=\"box-sizing: inherit;\">Long sleeves with adjustable buttoning at cuffs and a sleeve placket with a link button</li></ul>', '<p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Made of premium grade cotton. Stitched with intensive care.&nbsp;Slim-fit shirt in woven fabric with an easy-iron finish.</p><ul style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><li style=\"box-sizing: inherit;\">Y Fit/Slim fit collar shirt</li><li style=\"box-sizing: inherit;\">Turn-down collar, classic button placket.</li><li style=\"box-sizing: inherit;\">Long sleeves with adjustable buttoning at cuffs and a sleeve placket with a link button.</li><li style=\"box-sizing: inherit;\">Gently rounded hem</li></ul> ', '../img/compressed_651f9a7d524d3-square.jpg', NULL, NULL, NULL, '2025-04-18 15:56:50', 'new_arrival', 'mens-premium-shirt-urban'),
(3, 'Mens Denim Jeans - Indigo', 0, 2200, 1690, 1, 2, 13, 'Default', 'pant', '347645t78u', NULL, '', '../img/compressed_651830ea2edad-square.png', NULL, NULL, NULL, '2025-04-18 15:58:08', 'trending', 'mens-denim-jeans-indigo'),
(4, 'Mens Denim Jeans - Jet Black', 0, 2200, 2050, 1, 2, 36, 'Default', 'pant', '467587uy', NULL, '', '../img/compressed_660ab04660919-square.jpg', '../img/compressed_660aad08a5cec-square.jpg', '../img/compressed_6549f0fa83036-square.jpg', NULL, '2025-04-18 16:00:07', 'trending', 'mens-denim-jeans-jet-black'),
(5, 'Premium Elite Edition Cotton Polo - Sky Blue', 0, 1410, 1080, 1, 3, 27, 'Default', 't shirt', '342654y', NULL, '<p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><b>The Polo t-shirt is made with Double&nbsp;PK fabric which features premium 80% combed compact organic cotton. The t-shirt has a soft touch which makes it very comfortable for day-long usage.&nbsp;</b></p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><b>Regular fit, Shirt collar.</b></p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Color:&nbsp;</span>Sky Blue</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Fabric type&nbsp; :</span>&nbsp; Double&nbsp;PK</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Yarn count&nbsp; &nbsp;:&nbsp;</span>&nbsp;26/1</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Composition :</span>&nbsp;Cvc ( 80% cotton + 20% polyester )&nbsp;</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">GSM&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</span>&nbsp;210-220</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Color type:</span>&nbsp;Reactive Dye, Dye Finishing: Enzyme and Silicon Washed</p> ', '../img/compressed_641ad6ab2e091-square.jpg', '../img/compressed_641ad6ab2a461-square.jpg', '../img/compressed_641ad6ab2e091-square.jpg', '../img/compressed_641ad6ab2a461-square.jpg', '2025-04-18 16:04:51', '', 'premium-elite-edition-cotton-polo-sky-blue'),
(6, 'Mens Premium Blank T-shirt', 0, 640, 485, 1, 3, 27, 'Default', 't shirt', '354tery', NULL, '<p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Fabrilife Mens Premium Quality t-shirt that offers a much smoother, silky feel and more structured, mid-weight fit than the regular t-shirts . The t-shirts are made with finest quality Combed Compact Cotton , features astonishing ~175 GSM on just 26\'s cotton which gives a smooth and compact construction.</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">The compact finish guarantees that the t-shirt length and width will not change over wash or months of usage.</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Color:&nbsp;</span>Black</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\">Detailed Specification:</span></p><ul style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><li style=\"box-sizing: inherit;\">Organic Ringspun Combed Compact Cotton</li><li style=\"box-sizing: inherit;\">100% Cotton</li><li style=\"box-sizing: inherit;\">Regular fit, Crew Neck Mid-weight, 5.16 oz/yd2(~175GSM)</li><li style=\"box-sizing: inherit;\">Reactive Dye, enzyme and silicon washed</li><li style=\"box-sizing: inherit;\">Preshurnk to minimize shrinkage</li></ul> ', '../img/compressed_61507e01ee991-square.jpg', '../img/compressed_61507e01e099f-square.jpg', NULL, NULL, '2025-04-18 16:06:30', 'new_arrival', 'mens-premium-blank-t-shirt');
INSERT INTO `product_info` (`product_id`, `product_title`, `product_purchase_price`, `product_regular_price`, `product_price`, `main_ctg_id`, `sub_ctg_id`, `available_stock`, `size_option`, `product_keyword`, `product_code`, `product_short_description`, `product_description`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `created_at`, `product_type`, `product_slug`) VALUES
(8, 'SAFE ST18KRINV Inverter AC', 0, 65000, 48300, 5, 26, 14, 'Default', 'ac', '346treyhg', NULL, '<h1 class=\"font-semibold\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-size: 1.5rem; margin-bottom: 0px; color: rgb(37, 38, 43); font-family: Inter, sans-serif;\">1.5 Ton - White</h1><p style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-size: 1.5rem; margin-bottom: 0px; color: rgb(37, 38, 43); font-family: Inter, sans-serif;\"><br></p><p class=\"mb-6 text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 1.5rem; --tw-text-opacity: 1; color: rgb(82, 82, 82); font-family: Inter, sans-serif; font-size: 14px;\"><span style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-weight: bolder;\">Category:</span>&nbsp;<a class=\"text-blue-500\" href=\"https://evaly.com.bd/search?page=1&amp;categoryName=Air%20Conditioners\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(59, 130, 246); --tw-text-opacity: 1;\">Air Conditioners</a>&nbsp;<span class=\"mx-2\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229);\">|</span><span style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-weight: bolder;\">Brand:</span>&nbsp;<a class=\"text-blue-500\" href=\"https://evaly.com.bd/search?page=1&amp;brandName=SAFE\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(59, 130, 246); --tw-text-opacity: 1;\">SAFE</a></p><h2 class=\"mb-2 text-base font-semibold\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-size: 1rem; font-weight: 600; line-height: 1.5rem; color: rgb(37, 38, 43); font-family: Inter, sans-serif;\">Specifications:</h2><div style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(37, 38, 43); font-family: Inter, sans-serif; font-size: 14px;\"><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Brand&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Safe</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Product Type&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Air Conditioner</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Model&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">SAFE-ST18KPINV</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Air Conditioner Type&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Intelligent Inverter</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Function&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Cooling</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Cooling Capacity&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">18000 BTU/Hr</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Refrigerant&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">R-32</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Capacity&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">1.5 Ton</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Color&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">White</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Service Warranty&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">5 Years</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Spare Parts Warranty&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">1 Year Guarantee</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Installation Charge&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Free</dd></dl></div> ', '../img/compressed_53cf61f4-2f1f-4a97-a03f-a81eef2b2b7f.png', NULL, NULL, NULL, '2025-04-18 16:09:23', 'top_selling', 'safe-st18krinv-inverter-ac');
INSERT INTO `product_info` (`product_id`, `product_title`, `product_purchase_price`, `product_regular_price`, `product_price`, `main_ctg_id`, `sub_ctg_id`, `available_stock`, `size_option`, `product_keyword`, `product_code`, `product_short_description`, `product_description`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `created_at`, `product_type`, `product_slug`) VALUES
(9, 'Stainless Steel Electric Kettle - 1.8 Litre', 0, 1250, 750, 5, 18, 6, 'Default', 'trefj', '465t37', NULL, '<p class=\"mb-6 text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 1.5rem; --tw-text-opacity: 1; color: rgb(82, 82, 82); font-family: Inter, sans-serif; font-size: 14px;\"><span style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-weight: bolder;\">Category:</span>&nbsp;<a class=\"text-blue-500\" href=\"https://evaly.com.bd/search?page=1&amp;categoryName=Electric%20Kettles\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(59, 130, 246); --tw-text-opacity: 1;\">Electric Kettles</a>&nbsp;<span class=\"mx-2\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229);\">|</span><span style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-weight: bolder;\">Brand:</span>&nbsp;<a class=\"text-blue-500\" href=\"https://evaly.com.bd/search?page=1&amp;brandName=Individual%20Collection\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(59, 130, 246); --tw-text-opacity: 1;\">Individual Collection</a></p><h2 class=\"mb-2 text-base font-semibold\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); font-size: 1rem; font-weight: 600; line-height: 1.5rem; color: rgb(37, 38, 43); font-family: Inter, sans-serif;\">Specifications:</h2><div style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); color: rgb(37, 38, 43); font-family: Inter, sans-serif; font-size: 14px;\"><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Product Type&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Electric Kettle</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Material&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Stainless Steel</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Voltage&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">230 Volts</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Wattage&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">1500 Watts</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Capacity&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">1.8 liters</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Warranty&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">3 Month Replacement</dd></dl><dl class=\"flex gap-4 mb-1\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); display: flex; gap: 1rem;\"><dt class=\"flex-1 max-w-[200px] font-semibold text-gray-600\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); max-width: 200px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(82, 82, 82);\">Delivery Time&nbsp;:</dt><dd class=\"flex-1 text-gray-500\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ; border: 0px solid rgb(229, 229, 229); margin-bottom: 0px; flex: 1 1 0%; --tw-text-opacity: 1; color: rgb(115, 115, 115);\">Delivery in 72 Hours</dd></dl></div> ', '../img/compressed_763673f8-bc5e-424f-a6ff-eb7893acee63 (1).png', NULL, NULL, NULL, '2025-04-18 16:11:18', 'top_selling', 'stainless-steel-electric-kettle-18-litre');
INSERT INTO `product_info` (`product_id`, `product_title`, `product_purchase_price`, `product_regular_price`, `product_price`, `main_ctg_id`, `sub_ctg_id`, `available_stock`, `size_option`, `product_keyword`, `product_code`, `product_short_description`, `product_description`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `created_at`, `product_type`, `product_slug`) VALUES
(10, 'iPhone 16 Pro Inactive USA 512GB', 0, 274999, 239999, 4, 10, 5, 'Default', 'phone', '436yr54y', NULL, '<h3 class=\"text-xl font-semibold pb-2 text-primary\" style=\"border: 0px solid rgb(229, 231, 235); --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; font-size: 1.25rem; font-weight: 600; margin-bottom: 0px; line-height: 1.75rem; --tw-text-opacity: 1; color: rgb(242, 110, 33); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;;\"><table class=\"Description_specification__pXv75\" style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;; color: rgb(33, 37, 41); font-size: 16px; font-weight: 400; border-width: 0px; border-style: solid; border-color: inherit; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; text-indent: 0px; width: 814.297px;\"><tbody style=\"border-color: rgb(229, 231, 235); border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><tr class=\"border-b border-gray-200 py-3 p-2\" style=\"padding-top: 0.75rem; padding-bottom: 0.75rem; border-color: rgb(229, 231, 235); border-bottom-width: 1px; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-border-opacity: 1;\"><td style=\"padding: 0.75rem 1rem; border-color: rgb(229, 231, 235); border-width: 0px; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; min-width: 300px; --tw-text-opacity: 1; color: rgb(54, 69, 79);\"><div class=\"flex flex-col md:flex-row md:items-center\" style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; display: flex; flex-direction: row; align-items: center;\"><p class=\"basis-[30%]\" style=\"margin-bottom: 0px; font-size: 14px; border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 30%;\">Size</p><p class=\"basis-[70%] !font-normal text-black text-base\" style=\"margin-bottom: 0px; font-size: 1rem; border: 0px solid rgb(229, 231, 235); --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 70%; line-height: 1.5rem; --tw-text-opacity: 1;\">6.3‑inch</p></div></td></tr><tr class=\"border-b border-gray-200 py-3 p-2\" style=\"padding-top: 0.75rem; padding-bottom: 0.75rem; border-color: rgb(229, 231, 235); border-bottom-width: 1px; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-border-opacity: 1;\"><td style=\"padding: 0.75rem 1rem; border-color: rgb(229, 231, 235); border-width: 0px; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; min-width: 300px; --tw-text-opacity: 1; color: rgb(54, 69, 79);\"><div class=\"flex flex-col md:flex-row md:items-center\" style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; display: flex; flex-direction: row; align-items: center;\"><p class=\"basis-[30%]\" style=\"margin-bottom: 0px; font-size: 14px; border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 30%;\">Type</p><p class=\"basis-[70%] !font-normal text-black text-base\" style=\"margin-bottom: 0px; font-size: 1rem; border: 0px solid rgb(229, 231, 235); --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 70%; line-height: 1.5rem; --tw-text-opacity: 1;\">Super Retina XDR display</p></div></td></tr><tr class=\"border-b border-gray-200 py-3 p-2\" style=\"padding-top: 0.75rem; padding-bottom: 0.75rem; border-color: rgb(229, 231, 235); border-bottom-width: 1px; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-border-opacity: 1;\"><td style=\"padding: 0.75rem 1rem; border-color: rgb(229, 231, 235); border-width: 0px; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; min-width: 300px; --tw-text-opacity: 1; color: rgb(54, 69, 79);\"><div class=\"flex flex-col md:flex-row md:items-center\" style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; display: flex; flex-direction: row; align-items: center;\"><p class=\"basis-[30%]\" style=\"margin-bottom: 0px; font-size: 14px; border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 30%;\">Resolution</p><p class=\"basis-[70%] !font-normal text-black text-base\" style=\"margin-bottom: 0px; font-size: 1rem; border: 0px solid rgb(229, 231, 235); --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 70%; line-height: 1.5rem; --tw-text-opacity: 1;\">460 ppi</p></div></td></tr><tr class=\"border-b border-gray-200 py-3 p-2\" style=\"padding-top: 0.75rem; padding-bottom: 0.75rem; border-color: rgb(229, 231, 235); border-bottom-width: 1px; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-border-opacity: 1;\"><td style=\"padding: 0.75rem 1rem; border-color: rgb(229, 231, 235); border-width: 0px; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; min-width: 300px; --tw-text-opacity: 1; color: rgb(54, 69, 79);\"><div class=\"flex flex-col md:flex-row md:items-center\" style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; display: flex; flex-direction: row; align-items: center;\"><p class=\"basis-[30%]\" style=\"margin-bottom: 0px; font-size: 14px; border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 30%;\">Brightness</p><p class=\"basis-[70%] !font-normal text-black text-base\" style=\"margin-bottom: 0px; font-size: 1rem; border: 0px solid rgb(229, 231, 235); --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 70%; line-height: 1.5rem; --tw-text-opacity: 1;\">1000 nits max brightness (typical); 1600 nits peak brightness (HDR); 2000 nits peak brightness (outdoor); 1 nit minimum brightness</p></div></td></tr><tr class=\"border-b border-gray-200 py-3 p-2\" style=\"padding-top: 0.75rem; padding-bottom: 0.75rem; border-color: rgb(229, 231, 235); border-bottom-width: 1px; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-border-opacity: 1;\"><td style=\"padding: 0.75rem 1rem; border-color: rgb(229, 231, 235); border-width: 0px; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; min-width: 300px; --tw-text-opacity: 1; color: rgb(54, 69, 79);\"><div class=\"flex flex-col md:flex-row md:items-center\" style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; display: flex; flex-direction: row; align-items: center;\"><p class=\"basis-[30%]\" style=\"margin-bottom: 0px; font-size: 14px; border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 30%;\">Features</p><p class=\"basis-[70%] !font-normal text-black text-base\" style=\"margin-bottom: 0px; font-size: 1rem; border: 0px solid rgb(229, 231, 235); --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; flex-basis: 70%; line-height: 1.5rem; --tw-text-opacity: 1;\">Dynamic Island<br style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\">Always-On display<br style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\">ProMotion technology with adaptive refresh rates up to 120Hz<br style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\">HDR display<br style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\">True Tone<br></p></div></td></tr></tbody></table><br></h3>', '../img/compressed_iphone-16-pro-512gb-black-titanium.jpeg', '../img/compressed_iphone-16-pro-512gb-black-titanium-1.jpeg', '../img/compressed_iphone-16-pro-512gb-black-titanium-2.jpeg', '../img/compressed_iphone-16-pro-512gb-black-titanium-3.jpeg', '2025-04-18 16:13:48', 'top_selling', 'iphone-16-pro-inactive-usa-512gb'),
(11, 'Meko Ti5 ANC LCD True Wireless Earbuds', 0, 2999, 2499, 4, 13, 38, 'Default', '3etyr', '47yt5u', NULL, '<ul style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; list-style-position: initial; list-style-image: initial; margin-bottom: 0px; padding-left: 1.25rem; max-width: 100%; overflow-x: auto; line-height: 1.25rem; font-size: 16px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;;\"><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Wireless Version 5.4</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Battery Capacity: 300mAh</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Charging Time: 1.5-2 hrs</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Music Playback Time 4.5 hrs</li></ul> ', '../img/compressed_meko-ti5-anc-plus-lcd-earbuds340.jpeg', '../img/compressed_meko-ti5-anc-plus-lcd-earbuds-1832.jpeg', '../img/compressed_meko-ti5-anc-plus-lcd-earbuds-2898.jpeg', '../img/compressed_meko-ti5-anc-plus-lcd-earbuds-4335.jpeg', '2025-04-18 16:19:10', 'top_selling', 'meko-ti5-anc-lcd-true-wireless-earbuds');
INSERT INTO `product_info` (`product_id`, `product_title`, `product_purchase_price`, `product_regular_price`, `product_price`, `main_ctg_id`, `sub_ctg_id`, `available_stock`, `size_option`, `product_keyword`, `product_code`, `product_short_description`, `product_description`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `created_at`, `product_type`, `product_slug`) VALUES
(12, 'MacBook Air 15\" M3 Chip 16 512GB Midnight', 0, 194000, 179999, 4, 11, 8, 'Default', 'tghfn', '4463527', NULL, '<ul style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; list-style-position: initial; list-style-image: initial; margin-bottom: 0px; padding-left: 1.25rem; max-width: 100%; overflow-x: auto; line-height: 1.25rem; font-size: 16px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;;\"><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Apple M3 chip</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">Liquid Retina display</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">52.6-watt?hour lithium?polymer battery</li><li style=\"border: 0px solid rgb(229, 231, 235); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; padding-top: 0.25rem; line-height: 1.5rem !important; font-size: 1rem !important;\">1080p FaceTime HD camera</li></ul> ', '../img/compressed_macbook-air-m3-chip-16-512-midnighat-4.jpeg', '../img/compressed_macbook-air-m3-chip-16-512-midnight.jpeg', NULL, NULL, '2025-04-18 16:21:07', 'trending', 'macbook-air-15quot-m3-chip-16-512gb-midnight'),
(13, 'TECNO CAMON 40 Pro (8 256GB)', 0, 29999, 27499, 4, 10, 40, 'Default', 'etrh', 'erh', NULL, '', '../img/compressed_camon-40-pro-galaxy-black-1114.jpeg', '../img/compressed_camon-40-pro-emerald-lake-green-1728.jpeg', '../img/compressed_camon-40-pro-glacier-white-134.jpeg', '../img/compressed_camon-40-pro-galaxy-black25.jpeg', '2025-04-18 16:23:03', 'top_selling', 'tecno-camon-40-pro-8-256gb'),
(14, 'Women\'s Premium Kurti - Creimenia', 0, 1500, 1190, 2, 6, 40, 'Default', 'hfg', '4667', NULL, '', '../img/compressed_67dbac21a0020-square.jpg', '../img/compressed_67dbac2190c65-square.jpg', NULL, NULL, '2025-04-18 16:35:32', 'trending', 'women039s-premium-kurti-creimenia'),
(15, 'Women Premium Kurti - Lailati', 0, 1600, 1250, 2, 6, 26, 'Default', 'ghfn', '65t7u', NULL, '', '../img/compressed_67dbe432df816-square.jpg', '../img/compressed_67dbe4335a278-square.jpg', NULL, NULL, '2025-04-18 16:36:18', 'new_arrival', 'women-premium-kurti-lailati'),
(16, 'Urban Elegance Women\'s Pant Prestig', 0, 1800, 1490, 2, 8, 33, 'Default', 'rfhn', '54673', NULL, '', '../img/compressed_67f4e4d2010b2-square.jpg', NULL, NULL, NULL, '2025-04-18 16:37:23', 'top_rated', 'urban-elegance-women039s-pant-prestig'),
(17, 'Women\'s Premium Palazzo - Rihania', 0, 1250, 890, 2, 8, 30, 'Default', '4624ty', '5ythg', NULL, '<p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"font-family: Poppins;\">?</span>Made with soft double georgette&nbsp;fabric which is comfortable while remaining lightweight.&nbsp; From cozy to breathable georgette, our Palazzo collection is curated to meet your every need and desire , Great use for Tops or kurti. The waistband is made of double georgette&nbsp;&nbsp;fabric material for comfortable wear. These Formal pants also feature convenient side seam pockets. Explore our collection today and experience the ultimate in comfort and luxury with our premium double.&nbsp;</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\"><span style=\"box-sizing: inherit; font-size: 10pt; font-family: Verdana, sans-serif;\">Composition</span></span></p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\"><span style=\"box-sizing: inherit; font-weight: bolder;\"><span style=\"box-sizing: inherit; font-size: 10pt; font-family: Verdana, sans-serif;\">Color : Black &amp;&nbsp;cream</span></span></p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Made of double georgette.</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Convenient side seam pockets</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Straight leg cut</p><p style=\"box-sizing: inherit; color: rgb(55, 58, 60); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14.4px;\">Soft material for comfort</p> ', '../img/compressed_67dbb07806bdb-square.jpg', NULL, NULL, NULL, '2025-04-18 16:40:09', 'trending', 'women039s-premium-palazzo-rihania'),
(18, 'Women Premium Tops -Parishas', 0, 1100, 860, 2, 6, 0, 'Default', 'sdhfd', '4622547', '', '<p>Dress</p>', '../img/compressed_67daeef4e87ee-square.jpg', NULL, NULL, NULL, '2025-04-18 16:41:03', 'new_arrival', 'women-premium-tops-parishas');

-- --------------------------------------------------------

--
-- Table structure for table `product_size_list`
--

CREATE TABLE `product_size_list` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size_list`
--

INSERT INTO `product_size_list` (`id`, `product_id`, `size`, `created_at`) VALUES
(29, 6, 'L', '2025-06-21 23:42:15'),
(30, 6, 'XXL', '2025-06-21 23:42:15'),
(31, 5, 'XS', '2025-06-29 13:11:44'),
(32, 5, 'XXXL', '2025-06-29 13:11:44'),
(34, 2, 'S', '2025-08-25 16:46:05'),
(35, 2, 'M', '2025-08-25 16:46:05'),
(36, 2, 'L', '2025-08-25 16:46:05'),
(37, 2, 'XL', '2025-08-25 16:46:05'),
(42, 1, 'S', '2025-08-31 11:13:24'),
(43, 1, 'M', '2025-08-31 11:13:24'),
(44, 1, 'L', '2025-08-31 11:13:24'),
(45, 1, 'XL', '2025-08-31 11:13:24'),
(46, 1, 'XXL', '2025-08-31 11:13:24'),
(47, 18, '20', '2025-09-01 17:19:35'),
(48, 18, '30', '2025-09-01 17:19:35'),
(49, 18, '40', '2025-09-01 17:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `review_image`) VALUES
(1, 10, '../img/review.png'),
(2, 18, 'uploads/68c67cb7912ff_images.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_rating` int(11) NOT NULL CHECK (`user_rating` between 1 and 5),
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`) VALUES
(1, 'Admin', '2025-08-05'),
(2, 'Accountant', '2025-08-05'),
(4, 'Product Manager', '2025-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `size_labels`
--

CREATE TABLE `size_labels` (
  `id` int(11) NOT NULL,
  `size_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_labels`
--

INSERT INTO `size_labels` (`id`, `size_label`) VALUES
(1, 'XS'),
(2, 'X'),
(3, 'M'),
(4, 'L'),
(5, 'XL'),
(6, 'XXL'),
(7, 'XXL'),
(10, '20'),
(11, '30'),
(12, '40');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `slider_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_img`) VALUES
(13, '../img/compressed_sld2.jpg'),
(14, '../img/compressed_sld1.jpg'),
(15, '../img/compressed_banner1.jpg'),
(16, '../img/compressed_banner2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `steadfast_info`
--

CREATE TABLE `steadfast_info` (
  `id` int(11) NOT NULL,
  `api_url` text NOT NULL,
  `api_key` text NOT NULL,
  `secret_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steadfast_info`
--

INSERT INTO `steadfast_info` (`id`, `api_url`, `api_key`, `secret_key`) VALUES
(1, 'https://portal.packzy.com/api/v1/create_order', ' ', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_ctg_id` int(11) NOT NULL,
  `sub_ctg_name` varchar(100) NOT NULL,
  `main_ctg_name` varchar(100) NOT NULL,
  `sub_ctg_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_ctg_id`, `sub_ctg_name`, `main_ctg_name`, `sub_ctg_slug`) VALUES
(1, 'Shirts', 'Mens Fashion', 'shirts'),
(2, 'Pants', 'Mens Fashion', 'pants'),
(3, 'T-Shirt', 'Mens Fashion', 't-shirt'),
(4, 'Panjabi', 'Mens Fashion', 'panjabi'),
(5, 'Jacket', 'Mens Fashion', 'jacket'),
(6, 'Tops Long', 'Womens Fashion', 'tops-long'),
(8, 'Ladies Plajo', 'Womens Fashion', 'ladies-plajo'),
(9, 'Borka', 'Womens Fashion', 'borka'),
(10, 'Phone', 'Gadget & Electronics', 'phone'),
(11, 'Laptop', 'Gadget & Electronics', 'laptop'),
(12, 'Drone', 'Gadget & Electronics', 'drone'),
(13, 'Headphones & Earphones', 'Gadget & Electronics', 'headphones-amp-earphones'),
(15, 'Fridge', 'Home Appliances', 'fridge'),
(16, 'Washing Machine', 'Home Appliances', 'washing-machine'),
(17, 'Micro Oven', 'Home Appliances', 'micro-oven'),
(18, 'Electric Kettle', 'Home Appliances', 'electric-kettle'),
(22, 'Body Lotion', 'Health & Beauty', 'body-lotion'),
(23, 'Hair Cream', 'Health & Beauty', 'hair-cream'),
(26, 'AC', 'Home Appliances', 'ac'),
(27, 'Leather Bag', 'Bags and Travel', 'leather-bag'),
(31, 'Hoodies', 'Mens Fashion', 'hoodies'),
(32, 'Shoe', 'Mens Fashion', 'shoe');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `text_color` varchar(255) DEFAULT NULL,
  `button_color` varchar(255) DEFAULT NULL,
  `button_text_color` varchar(255) DEFAULT NULL,
  `button_hover_color` varchar(255) DEFAULT NULL,
  `navbar_color` varchar(255) DEFAULT NULL,
  `navbar_text_color` varchar(255) DEFAULT NULL,
  `indicator_color` varchar(255) DEFAULT NULL,
  `search_btn_color` varchar(255) DEFAULT NULL,
  `search_btn_text_color` varchar(255) DEFAULT NULL,
  `search_btn_hover_color` varchar(255) DEFAULT NULL,
  `subscribe_btn_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `user_fName` varchar(50) NOT NULL,
  `user_lName` varchar(50) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_gender` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_fName`, `user_lName`, `user_phone`, `user_email`, `user_gender`, `user_password`) VALUES
(3, 'Fardin', 'Ahmed', '01944667441', 'mdshawon7443@gmail.com', 'Male', '$2y$10$Uk8ZD6Ui4dSRx772cl35UuIM9xxZ3/BT5eixm69VKMi9RAOyAe/am'),
(4, 'Md', 'Jony', '01559907883', 'jony@gmail.com', 'Male', '$2y$10$n7aCco9VBswIV0IFAGVdLuhOsL743s7B8nLqdzv9diFTIC7CohESO');

-- --------------------------------------------------------

--
-- Table structure for table `website_info`
--

CREATE TABLE `website_info` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo_size` varchar(50) NOT NULL DEFAULT '50',
  `fav` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `inside_location` text NOT NULL,
  `inside_delivery_charge` int(11) NOT NULL,
  `outside_delivery_charge` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `wp_api_num` varchar(15) NOT NULL,
  `messenger_username` text DEFAULT NULL,
  `acc_num` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb_link` varchar(255) NOT NULL,
  `insta_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `yt_link` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `vdo_location` varchar(255) NOT NULL,
  `banner_one` varchar(255) NOT NULL,
  `banner_two` varchar(255) NOT NULL,
  `shop_banner` varchar(255) NOT NULL,
  `about_banner` varchar(255) NOT NULL,
  `contact_banner` varchar(255) NOT NULL,
  `faq_banner` varchar(255) NOT NULL,
  `term_banner` varchar(255) NOT NULL,
  `privacy_banner` varchar(255) NOT NULL,
  `shipping_banner` varchar(255) NOT NULL,
  `top_banner_ad_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_info`
--

INSERT INTO `website_info` (`id`, `name`, `logo`, `logo_size`, `fav`, `address`, `inside_location`, `inside_delivery_charge`, `outside_delivery_charge`, `phone`, `wp_api_num`, `messenger_username`, `acc_num`, `email`, `fb_link`, `insta_link`, `twitter_link`, `yt_link`, `location`, `vdo_location`, `banner_one`, `banner_two`, `shop_banner`, `about_banner`, `contact_banner`, `faq_banner`, `term_banner`, `privacy_banner`, `shipping_banner`, `top_banner_ad_content`) VALUES
(1, 'Easy Tech', '', '120', '', 'Dhaka, Bangladesh', 'Dhaka', 80, 150, '01XXXXXXXXX', '1XXXXXXXXX', '', '01XXXXXXXXX', 'example@gmail.com', '#', '#', '#', '#', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58433.58839526138!2d90.35775996504786!3d23.743839015450195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf6de2c3b19b%3A0xeeef7eec6d1d012a!2sEasy%20Tech%20Solutions!5e0!3m2!1sen!2sbd!4v1752511116922!5m2!1sen!2sbd', '', 'uploads/ss3.jpg', 'uploads/ss2.jpg', '', '', '', '', '', '', '', 'Get 25% off on your purchase! Use this coupon code RKKXSO50PQ on the Checkout Page');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `customized_category`
--
ALTER TABLE `customized_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `customized_orders`
--
ALTER TABLE `customized_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customized_payments`
--
ALTER TABLE `customized_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `customized_products`
--
ALTER TABLE `customized_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `expense_info`
--
ALTER TABLE `expense_info`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `footer_info`
--
ALTER TABLE `footer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`main_ctg_id`);

--
-- Indexes for table `mockup_category`
--
ALTER TABLE `mockup_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `mockup_orders`
--
ALTER TABLE `mockup_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `mockup_products`
--
ALTER TABLE `mockup_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `order_discount_list`
--
ALTER TABLE `order_discount_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`order_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `page_access`
--
ALTER TABLE `page_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `parcel_info`
--
ALTER TABLE `parcel_info`
  ADD PRIMARY KEY (`parcel_id`);

--
-- Indexes for table `pathao_acc_info`
--
ALTER TABLE `pathao_acc_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pathao_parcel_info`
--
ALTER TABLE `pathao_parcel_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`serial_no`),
  ADD UNIQUE KEY `order_no` (`order_no`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `main_ctg_id` (`main_ctg_id`),
  ADD KEY `sub_ctg_id` (`sub_ctg_id`);

--
-- Indexes for table `product_size_list`
--
ALTER TABLE `product_size_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `review_table`
--
ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size_labels`
--
ALTER TABLE `size_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `steadfast_info`
--
ALTER TABLE `steadfast_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_ctg_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_phone` (`user_phone`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `website_info`
--
ALTER TABLE `website_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customized_category`
--
ALTER TABLE `customized_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customized_orders`
--
ALTER TABLE `customized_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customized_payments`
--
ALTER TABLE `customized_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customized_products`
--
ALTER TABLE `customized_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_info`
--
ALTER TABLE `expense_info`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `main_category`
--
ALTER TABLE `main_category`
  MODIFY `main_ctg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mockup_category`
--
ALTER TABLE `mockup_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mockup_orders`
--
ALTER TABLE `mockup_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mockup_products`
--
ALTER TABLE `mockup_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_discount_list`
--
ALTER TABLE `order_discount_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `page_access`
--
ALTER TABLE `page_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `parcel_info`
--
ALTER TABLE `parcel_info`
  MODIFY `parcel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathao_acc_info`
--
ALTER TABLE `pathao_acc_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathao_parcel_info`
--
ALTER TABLE `pathao_parcel_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `serial_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_size_list`
--
ALTER TABLE `product_size_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `size_labels`
--
ALTER TABLE `size_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `steadfast_info`
--
ALTER TABLE `steadfast_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_ctg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `website_info`
--
ALTER TABLE `website_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD CONSTRAINT `admin_info_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customized_orders`
--
ALTER TABLE `customized_orders`
  ADD CONSTRAINT `customized_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `customized_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customized_payments`
--
ALTER TABLE `customized_payments`
  ADD CONSTRAINT `customized_payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customized_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customized_products`
--
ALTER TABLE `customized_products`
  ADD CONSTRAINT `customized_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `customized_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `features_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD CONSTRAINT `landing_pages_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `mockup_orders`
--
ALTER TABLE `mockup_orders`
  ADD CONSTRAINT `mockup_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `mockup_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mockup_products`
--
ALTER TABLE `mockup_products`
  ADD CONSTRAINT `mockup_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `mockup_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_access`
--
ALTER TABLE `page_access`
  ADD CONSTRAINT `page_access_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_size_list`
--
ALTER TABLE `product_size_list`
  ADD CONSTRAINT `product_size_list_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `review_table`
--
ALTER TABLE `review_table`
  ADD CONSTRAINT `review_table_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
