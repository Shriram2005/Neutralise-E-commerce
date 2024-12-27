-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 03:12 PM
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
-- Database: `neutral`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `email`, `created_at`, `last_login`) VALUES
(1, 'admin', '$2y$10$YQtQzlXM0JHXnrR9yZOkUuHT3V5Hy0k9gVwqT.7LwE5vgQVkV8Iq.', 'Administrator', 'admin@neutralise.com', '2024-12-27 12:50:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `applied_before` enum('yes','no') NOT NULL,
  `department` varchar(100) NOT NULL,
  `procedure1` varchar(100) NOT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `first_name`, `last_name`, `dob`, `gender`, `phone`, `email`, `applied_before`, `department`, `procedure1`, `appointment_date`) VALUES
(1, 'Diksha', 'gadakh', '2024-12-03', 'male', '9412356789', 'prajakta@gmail.com', 'no', 'none', 'organic_facial', '2025-01-02'),
(2, 'Darshan', 'Gadekar', '2024-12-08', 'female', '(123) 123-4567', 'prajakta@gmail.com', 'no', 'none', 'holistic_nutrition_plan', '2024-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `subtitle`, `content`, `post_date`, `author`, `image`, `category`, `excerpt`, `tags`) VALUES
(1, 'Busting Common Psoriasis Myths', 'Natural Solutions for Chronic Skin Conditions', 'Psoriasis is a chronic autoimmune disease...', '2024-09-15', 'Neutralise', 'pl.jpeg', 'Psoriasis', 'Psoriasis is a chronic autoimmune disease that affects millions of people worldwide.', 'ringworm'),
(2, 'The Sleep-Psoriasis Connection', 'Natural Solutions for Chronic Skin Conditions', 'Discover how quality sleep...', '2024-09-01', 'Dr. Ayush Sharma', 'sleep-psoriasis-connection.jpeg', 'Psoriasis', 'Discover how quality sleep can impact psoriasis symptoms.', 'ayurveda'),
(3, 'Identifying and Avoiding Eczema Triggers', 'Natural Solutions for Chronic Skin Conditions', 'Learn about common eczema triggers...', '2024-08-20', 'Neutralise Team', 'Identifying and Avoiding Eczema Triggers.png', 'Eczema', 'Learn about common eczema triggers and how to create an environment that supports healthier skin.', 'psoriasis'),
(4, 'Natural Remedies for Ringworm', 'August 5, 2024 | by Dr. Priya Patel', 'Explore effective, natural ways to treat ringworm and prevent its recurrence using Ayurvedic principles.', '0000-00-00', 'by Dr. Priya Patel', 'ringworm.jpeg', 'Vitiligo', 'Natural Remedies for Ringworm', 'vitiligo'),
(5, 'Understanding Vitiligo: Causes, Symptoms, and Management', 'August 5, 2024 | by Dr. Priya Patel', 'Gain insights into vitiligo, its impact on skin pigmentation, and holistic approaches to managing this condition.', '0000-00-00', 'by Neutralise Team', 'viltigo.jpeg', 'Ayurvedic Wisdom', 'Understanding Vitiligo: Causes, Symptoms, and Management', 'natural remedies'),
(8, 'Busting Common Psoriasis Myths', 'Natural Solutions for Chronic Skin Conditions', 'Psoriasis is a chronic autoimmune disease...', '2024-12-02', 'Neutralise Team', 'DarkSpot.jpeg', 'Vitiligo', 'Natural Remedies for Ringworm', 'vitiligo');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `size_option` varchar(50) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'shweta', 'sonawanepratiksha77@gmail.com', '9412356789', 'none', 'i have no message', '2024-12-19 13:10:08'),
(2, 'shweta', 'sonawanepratiksha77@gmail.com', '9412356789', 'none', 'message not send yet', '2024-12-19 13:24:08'),
(3, 'Diksha', 'prajakta@gmail.com', '9876543210', 'none', 'what is this', '2024-12-19 13:24:56'),
(4, 'Pratiksha Sunil Sonawane', 'sonawanediksha14@gmail.com', '9412356789', 'none', 'afjabkfakjf', '2024-12-19 13:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Cash on Delivery',
  `payment_status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending',
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `order_date`, `shipping_address`, `payment_method`, `payment_status`, `phone`) VALUES
(1, 0, 1600.00, 'Pending', '2024-12-26 11:40:49', 'yukiyuk iukuiykui kyuyk yuik yu uik yuh ui uik yu kk yu kyu yuk uyik t yujur tyj', 'Cash on Delivery', 'Pending', '9412356789'),
(2, 0, 1001.00, 'Pending', '2024-12-26 12:05:11', 'nashik', 'Cash on Delivery', 'Pending', '9412356789'),
(3, 0, 6404.00, 'Pending', '2024-12-26 15:32:31', 'nashik', 'Cash on Delivery', 'Pending', '9412356789'),
(4, 0, 1801.00, 'Pending', '2024-12-27 13:01:39', 'nashik', 'Cash on Delivery', 'Pending', '9412356789');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 2, 800.00),
(2, 2, 1, 1, 1001.00),
(3, 3, 2, 3, 800.00),
(4, 3, 1, 4, 1001.00),
(5, 4, 2, 1, 800.00),
(6, 4, 1, 1, 1001.00);

-- --------------------------------------------------------

--
-- Table structure for table `our_approach`
--

CREATE TABLE `our_approach` (
  `id` int(11) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `our_approach`
--

INSERT INTO `our_approach` (`id`, `icon_class`, `title`, `description`) VALUES
(1, 'fas fa-leaf', 'Natural Ingredients', 'We use only the finest natural ingredients, carefully selected for their healing properties.'),
(2, 'fas fa-flask', 'Scientific Formulation', 'Our products are developed in collaboration with renowned Ayurvedic experts.'),
(3, 'fas fa-heart', 'Holistic Healing', 'We focus on improving your immune system both internally and externally.');

-- --------------------------------------------------------

--
-- Table structure for table `our_promise`
--

CREATE TABLE `our_promise` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `intro_text` text NOT NULL,
  `list_items` text NOT NULL,
  `closing_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `our_promise`
--

INSERT INTO `our_promise` (`id`, `image`, `intro_text`, `list_items`, `closing_text`) VALUES
(1, 'image2.png', 'At Neutralize Naturals, we promise:', '100% natural, chemical-free products, Faster and better relief compared to alternative medicines, Ongoing research and development for continuous improvement, Exceptional customer support and guidance', 'Once you experience our products, you\'ll understand why our customers keep coming back.');

-- --------------------------------------------------------

--
-- Table structure for table `our_story`
--

CREATE TABLE `our_story` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `our_story`
--

INSERT INTO `our_story` (`id`, `heading`, `text`, `image`) VALUES
(1, 'Our Story', 'Neutralise Naturals, a brand of Sri Satyajyothi Agro foods, brings you India\'s first wheatgrass powder with roots, grown in our innovative Indoor Hydroponic soil-free process. Our journey began with a simple mission: to harness the power of nature and provide effective, natural solutions for chronic skin conditions like psoriasis.', 'image1.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `reviews_count` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `size_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`size_options`)),
  `ingredients` text DEFAULT NULL,
  `usage_instructions` text DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image1`, `image2`, `image3`, `category`, `tags`, `sku`, `rating`, `reviews_count`, `description`, `full_description`, `size_options`, `ingredients`, `usage_instructions`, `featured`) VALUES
(1, 'product 1', 1001.00, 'freepik__candid-image-photography-natural-textures-highly-r__56373.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56374.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56376.jpeg', 'demo', 'a,b,cc,dd,ccc', 'demo1', NULL, NULL, 'kasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdf', 'kasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdfkasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdfkasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdfkasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdfkasdjf aksdjf asjf aksdjf; asdlkfj;alskfj s;lkdfjlksdflskadfjl;ksfdjl asdfl;jk sadfalksfjl;kasjdf; l;jkas f;lj sadflj; asdf', '{\"one\":\"100ml\",\"two \":\"200gm\"}', 'aloo butter', 'dont eat , just apply', 1),
(2, 'product 2', 800.00, 'freepik__candid-image-photography-natural-textures-highly-r__56374.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56375.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56374.jpeg', 'sdaf', 'asf', 'asdf', NULL, NULL, 'asdfafa', 'asdfasdf', '{\"asdf\":\"200ml\",\"fhhffh\":\"230gm\"}', 'sdfasdfafdasdf', 'asfasdfasdfasdf', 1),
(3, 'sdfaaf', 4525.00, 'freepik__candid-image-photography-natural-textures-highly-r__56367.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56368.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56369.jpeg', 'ergt', 'sdfgsd', 'gsdfg', NULL, NULL, 'sdfg', 'sdfg', '{\"sdfg\":\"sdfg\"}', 'sdfg', 'sdfg', 1),
(4, 'sdfghgmjfg', 4574.00, 'freepik__candid-image-photography-natural-textures-highly-r__56372.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56368.jpeg', 'freepik__candid-image-photography-natural-textures-highly-r__56376.jpeg', 'fjhfgjhfgj', 'fgjdghjfg', 'dfgsdfg', NULL, NULL, 'sdfgsdg', 'sdfgsdfgs', '{\"sdfg\":\"sdfgsrdg\",\"sdfgs\":\"dfg\"}', 'dfgsdfgsdf', 'gsdfgsdfg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_page`
--

CREATE TABLE `product_page` (
  `Id` int(30) NOT NULL,
  `Photo` text NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Category` varchar(30) NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_page`
--

INSERT INTO `product_page` (`Id`, `Photo`, `Name`, `Category`, `Price`) VALUES
(1, 'Avocado-Wheat-Grass-Facewash.JPG', 'Avacado', 'facewash', 50);

-- --------------------------------------------------------

--
-- Table structure for table `psoriasis_data`
--

CREATE TABLE `psoriasis_data` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `head_neck_skin_area` int(11) NOT NULL,
  `head_neck_redness` int(11) NOT NULL,
  `head_neck_thickness` int(11) NOT NULL,
  `head_neck_scale` int(11) NOT NULL,
  `head_neck_itching` int(11) NOT NULL,
  `hands_skin_area` int(11) NOT NULL,
  `hands_redness` int(11) NOT NULL,
  `hands_thickness` int(11) NOT NULL,
  `hands_scale` int(11) NOT NULL,
  `hands_itching` int(11) NOT NULL,
  `trunk_skin_area` int(11) NOT NULL,
  `trunk_redness` int(11) NOT NULL,
  `trunk_thickness` int(11) NOT NULL,
  `trunk_scale` int(11) NOT NULL,
  `trunk_itching` int(11) NOT NULL,
  `groin_skin_area` int(11) NOT NULL,
  `groin_redness` int(11) NOT NULL,
  `groin_thickness` int(11) NOT NULL,
  `groin_scale` int(11) NOT NULL,
  `groin_itching` int(11) NOT NULL,
  `total_score` int(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `percentage_score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psoriasis_data`
--

INSERT INTO `psoriasis_data` (`id`, `first_name`, `last_name`, `mobile`, `image_path`, `head_neck_skin_area`, `head_neck_redness`, `head_neck_thickness`, `head_neck_scale`, `head_neck_itching`, `hands_skin_area`, `hands_redness`, `hands_thickness`, `hands_scale`, `hands_itching`, `trunk_skin_area`, `trunk_redness`, `trunk_thickness`, `trunk_scale`, `trunk_itching`, `groin_skin_area`, `groin_redness`, `groin_thickness`, `groin_scale`, `groin_itching`, `total_score`, `created_at`, `percentage_score`) VALUES
(1, 'Diksha', 'Sonawane', '9423027789', 'uploads/users.png', 0, 0, 0, 2, 0, 0, 1, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, '2024-12-19 07:46:37', NULL),
(2, 'Diksha', 'Sonawane', '9423027789', 'contents/calculator/users.png', 0, 0, 0, 2, 0, 0, 1, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, '2024-12-19 07:48:01', NULL),
(3, 'Shweta', 'gadakh', '9876543210', 'contents/calculator/1000000696.jpg', 40, 2, 2, 3, 2, 40, 2, 3, 1, 2, 60, 1, 2, 1, 2, 10, 1, 2, 3, 4, 183, '2024-12-19 08:32:49', NULL),
(4, 'Diksha', 'Sonawane', '9423027789', 'contents/calculator/users.png', 0, 0, 0, 2, 0, 0, 1, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, '2024-12-19 09:00:56', NULL),
(5, 'Diksha', 'Sonawane', '9423027789', 'contents/calculator/users.png', 0, 0, 0, 2, 0, 0, 1, 2, 3, 1, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 49, '2024-12-19 09:02:22', NULL),
(6, 'Diksha', 'Sonawane', '9423027789', 'contents/calculator/Identifying and Avoiding Eczema Triggers.png', 10, 2, 2, 2, 2, 25, 0, 0, 0, 0, 25, 0, 0, 0, 0, 25, 0, 0, 0, 0, 93, '2024-12-20 14:06:26', NULL),
(7, 'sneha', 'sonawane', '9876543210', 'contents/calculator/sleep-psoriasis-connection.jpeg', 25, 3, 3, 3, 3, 40, 3, 2, 2, 2, 40, 3, 3, 2, 2, 40, 3, 2, 2, 2, 185, '2024-12-20 14:09:35', NULL),
(8, 'sneha', 'gadakh', '9423027789', 'contents/calculator/users.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, '2024-12-24 10:24:48', NULL),
(9, 'sneha', 'gadakh', '9423027789', 'contents/calculator/users.png', 25, 2, 2, 2, 2, 25, 2, 2, 2, 2, 10, 2, 2, 2, 2, 0, 2, 2, 2, 2, 92, '2024-12-24 10:34:53', NULL),
(10, 'Nilesh', 'Sonawane', '9423027789', 'contents/calculator/users.png', 25, 2, 2, 2, 2, 25, 2, 2, 2, 2, 25, 2, 2, 2, 2, 25, 2, 2, 2, 2, 107, '2024-12-24 10:37:14', NULL),
(11, 'Pravin', 'gadakh', '9423027789', 'contents/calculator/users.png', 25, 2, 2, 2, 2, 25, 2, 2, 2, 2, 10, 2, 2, 2, 2, 0, 2, 2, 2, 2, 92, '2024-12-24 10:44:37', 21.70),
(12, 'Siddhi', 'Sonawane', '9423027789', 'contents/calculator/users.png', 90, 2, 3, 3, 2, 60, 3, 3, 3, 3, 0, 2, 2, 2, 2, 0, 2, 2, 2, 2, 188, '2024-12-24 11:00:05', 44.34),
(13, 'Pranali', 'Bhalerao', '9423027789', 'contents/calculator/users.png', 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 148, '2024-12-24 11:07:08', 34.91),
(14, 'Pravin', 'Bhalerao', '9876543210', 'contents/calculator/users.png', 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 25, 3, 3, 3, 3, 148, '2024-12-24 11:09:47', 34.91),
(15, 'Darshan', 'Bhalerao', '9423027789', 'contents/calculator/users.png', 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 0, '2024-12-24 11:51:59', 0.00),
(16, 'Darshan', 'Bhalerao', '9423027789', 'contents/calculator/users.png', 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 40, 3, 3, 3, 3, 0, '2024-12-24 12:09:03', 0.00),
(17, 'Pravin', 'gadakh', '9423027789', 'contents/calculator/users.png', 10, 1, 1, 1, 1, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 10, 1, 1, 1, 1, 38, '2024-12-24 12:35:58', NULL),
(18, 'man', 'son', '9423027789', 'contents/calculator/users.png', 10, 2, 3, 2, 3, 10, 3, 2, 3, 2, 25, 3, 2, 3, 2, 25, 3, 2, 3, 2, 110, '2024-12-24 12:43:43', NULL),
(19, 'Pravin', 'gadakh', '9423027789', 'contents/calculator/users.png', 10, 2, 2, 2, 2, 10, 2, 2, 2, 2, 10, 2, 2, 2, 2, 10, 2, 2, 2, 2, 72, '2024-12-24 14:43:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `full_name`, `email`, `phone`, `address`, `password`, `created_at`) VALUES
(0, 'Shriram mange', 'shrirammange1@gmail.com', '7821851927', 'nashik', '$2y$10$cOcmWHMyoKTSds99QF6rtu2Z5BFAGikIz4q85f3YOF75bqkYNRJEG', '2024-12-25 12:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `message` text NOT NULL,
  `rating` varchar(10) NOT NULL,
  `imgSrc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `date`, `message`, `rating`, `imgSrc`) VALUES
(1, 'Priya Sharma', '2023-06-15', 'Namaste! I\'ve been struggling with psoriasis for years, and Neutralise Naturals has been a true blessing. ', '4', '/contents/testimonials/users.png'),
(2, 'Rajesh Patel', '2023-07-03', 'Being someone with very sensitive skin, I was scared to try new products. ', '★★★★★', '/contents/testimonials/users.png'),
(3, 'Anita Desai 222', '2023-08-20', 'The holistic approach of Neutralise Naturals has totally transformed my skin health. ', '', '/contents/testimonials/users.png'),
(4, 'Vikram Singh', '2023-09-05', 'I was very doubtful at first, but after using Neutralise Naturals for 3 months, I\'m a true believer now. My psoriasis patches have reduced so much, and my skin feels so much more comfortable. Dhanyavaad, Neutralise Naturals!', '3', '/contents/testimonials/users.png'),
(7, 'Pratiksha Sunil Sonawane', '2024-12-06', 'The Ayurvedic-inspired products from Neutralise Naturals match perfectly with my belief in natural healing. Not only has my skin improved, but  feeling more balanced overall. It like a spa day for my skin every day!', '4', 'users.png'),
(10, 'shweta', '2024-12-03', 'jgsghsjfghdyfrtsugggggggggggfyrrrrrrrrrrrrrrrrrrrrrrrrrrr', '4', 'users.png'),
(11, 'Pratiksha Sunil Sonawane', '2024-12-03', 'dsfgvhjuiytresdzxgvbhjuytfrdfxgvh', '3', 'users.png'),
(12, 'Diksha', '2024-12-10', 'hgggggggggggggggggggv', '3', 'users.png'),
(13, 'Darshan', '2024-12-04', 'Hello it is very useful product\nthat can be used for daily purpose', '3', 'DarkSpot.jpeg'),
(14, 'Darshan', '2024-12-23', 'efgsefgsyufvshdfsgfusgfzbkd\r\nsbgkusjdfjdbkz.z/odilghkbdkfjbd\r\nndgjkbdkgmjxbvjmnfd fmn', '4', 'users.png'),
(15, 'Sneha', '2024-12-12', 'jsefgsjGFjgsfydhcvfrsdhygffffuygfdhvyregfdhnvhergdvhbcxhvfdhfgxvcbdnxfvmdsfg,dujgfbvfdnvcxhnbdjghksrghsrjgbd vc', '2', 'users.png'),
(16, 'TechEntrance', '2024-12-13', 'Noiceeee Products!!!!!!!!!!!', '5', 'favicon.png'),
(27, 'android', '2024-12-27', 'great product from neutralise', '5', 'freepik__candid-image-photography-natural-textures-highly-r__56372.jpeg'),
(28, 'adfasdf', '2024-12-21', 'asdfasdfasf', '5', 'freepik__candid-image-photography-natural-textures-highly-r__56373.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `our_approach`
--
ALTER TABLE `our_approach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_promise`
--
ALTER TABLE `our_promise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_story`
--
ALTER TABLE `our_story`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_page`
--
ALTER TABLE `product_page`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `psoriasis_data`
--
ALTER TABLE `psoriasis_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
