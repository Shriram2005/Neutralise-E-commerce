-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 01:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
(8, 'Busting Common Psoriasis Myths', 'Natural Solutions for Chronic Skin Conditions', 'Psoriasis is a chronic autoimmune disease...', '2024-12-02', 'Neutralise Team', 'DarkSpot.jpeg', 'Vitiligo', 'Natural Remedies for Ringworm', 'vitiligo'),
(9, 'A Guide to Eczema Symptoms Causes and its Management', 'Eczema', 'Atopic Dermatitis, commonly referred to as Eczema is a subtype of dermatitis. It is a non-fatal condition that is usually chronic (lasts throughout the individual’s lifetime with alternating periods of flare – ups and remission). \r\n\r\n', '2024-12-31', 'by Praveen kumar Wheatgrass', 'Untitled-design-3.png', 'Eczema', 'Atopic Dermatitis, commonly referred to as Eczema is a subtype of dermatitis. It is a non-fatal condition that is usually chronic (lasts throughout the individual’s lifetime with alternating periods of flare – ups and remission). \r\n', 'cure, eczema, guide, natural, remedy, solution, wheatgrass'),
(10, 'Busting Common Psoriasis Myths', 'Psoriasis', 'Psoriasis is a chronic autoimmune disease that affects millions of people around the world. Myths about this skin problem are spread....', '2024-12-31', 'by Praveen kumar Wheatgrass', 'WhatsApp-Image-2024-09-11-at-23.18.12.jpeg', 'Psoriasis', 'Psoriasis is a chronic autoimmune disease that affects millions of people around the world. Myths about this skin problem are spread....', 'Psoriasis'),
(11, 'The Sleep-Psoriasis Connection', 'Psoriasis', 'Psoriasis is a persistent autoimmune illness that causes excessive skin cell proliferation, resulting in thick, red, and itchy patches on the skin.', '2024-12-31', 'by Praveen kumar Wheatgrass', 'WhatsApp-Image-2024-09-03-at-04.24.06-1.jpeg', 'Psoriasis', 'Psoriasis is a persistent autoimmune illness that causes excessive skin cell proliferation, resulting in thick, red, and itchy patches on the skin.', 'Psoriasis'),
(12, 'The 3 P’s in Psoriasis', 'Psoriasis', 'Psoriasis might feel like an uphill struggle, but Neutralise Naturals believes that with the appropriate strategy, you can get control of this illness.', '2024-12-31', 'by Praveen kumar Wheatgrass', 'vrAZ6IKgRueckOcZiiDU-w-1-e1724911517874.webp', 'Psoriasis', 'Psoriasis might feel like an uphill struggle, but Neutralise Naturals believes that with the appropriate strategy, you can get control of this illness.', 'Psoriasis');

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
(4, 0, 1801.00, 'Pending', '2024-12-27 13:01:39', 'nashik', 'Cash on Delivery', 'Pending', '9412356789'),
(0, 0, 5005.00, 'Pending', '2024-12-30 06:56:31', 'nashik', 'Cash on Delivery', 'Pending', '9412356789');

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
(0, 0, 1, 5, 1001.00),
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
(1, 'Basic Body Kit', 2800.00, 'WhatsApp-Image-2024-05-01-at-12.22.00-PM-1.jpeg', '', '', 'COMBO', 'Neutralise Naturals Combo body kit, WHEAT GRASS CREAM, Wheat Grass Powder With Roots, Wheat Grass Shampoo, WHEAT GRASS SOAP, wheatgrass basic body kit', 'NH001', NULL, NULL, 'Basic Body Kit Tailored for individuals contending with skin problems affecting the scalp and other body parts, our Basic Body Kit is meticulously crafted to help reverse the skin problem. Approximately 10% of the scalp and body is afflicted with symptoms such as scaling, itching, or thickness, making this kit a targeted product for relief and reversal.', 'Basic Body Kit Tailored for individuals contending with skin problems affecting the scalp and other body parts, our Basic Body Kit is meticulously crafted to help reverse the skin problem. Approximately 10% of the scalp and body is afflicted with symptoms such as scaling, itching, or thickness, making this kit a targeted product for relief and reversal.', '{\"small\":\"1000g\",\"medium\":\"2000g\"}', 'Wheatgrass Powder:\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nWheatgrass Herbal Soap\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nWheatgrass Herbal Cream\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nWheatgrass Shampoo', 'Take one spoonful (3 grams) of Wheatgrass powder.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nMix the measured powder into a glass of normal or lukewarm water.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nConsume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nTwice a day\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nWe recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nClose Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.', 0),
(2, 'Basic Skin Kit', 2400.00, '16-1-1024x1024.png', '', '', 'COMBO', 'Basic Skin Kit, Neutralise Naturals Combo Skin Kit, Neutralise Naturals Products, WHEAT GRASS CREAM, Wheat Grass Powder, Wheat Grass Powder With Roots, WHEAT GRASS SOAP', 'NH002', NULL, NULL, 'Basic Skin Kit is specially designed for individuals who have been grappling with skin problems for months or even years, with approximately 10% of their body affected by symptoms like scaling, itching, or thickness. For one month use.', 'Basic Skin Kit is specially designed for individuals who have been grappling with skin problems for months or even years, with approximately 10% of their body affected by symptoms like scaling, itching, or thickness. For one month use.', '{\"small\":\"1000g\",\"medium\":\"2000g\"}', 'Wheat sprout grass powder with roots (2X 100g).,Wheatgrass herbal soaps (2X 100g).,Wheatgrass moisturizer cream', 'Take one spoonful (3 grams) of Wheatgrass powder. Prepare: Mix the measured powder into a glass of normal or lukewarm water. Timing: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner Frequency: Twice a day,\\\\r\\\\nWe recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\\\r\\\\nClose Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.', 0),
(3, 'Psoriasis, Eczema and dermatitis Wheatgrass Skin Care Combo', 1800.00, '3-1.png', '1Q1A0460-copy.jpg', '1Q1A0436.jpg', 'COMBO', 'Psoriasis, Eczema and dermatitis', 'NH003', NULL, NULL, 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types.', 'As per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin.Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental tosins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally.', '{\"small\":\"250g\",\"medium\":\"500g\"}', 'Cow Butter as the main ingredient along with essential oils combined with selective traditional herbs are added to suit all skin types is blended to give better moisturizing to improve skin elasticity like Psoriasis, Eczema and other skin conditions,.', 'As per the doctors references', 0),
(4, 'Neutralise Total Skin Combo', 2200.00, 'Total-Skin-Combo.JPG', '1Q1A0483-copy.jpg', '1Q1A0503.JPG', 'SKIN', 'Wheat sprout grass powder with roots,  Wheatgrass herbal soaps,  Wheatgrass moisturizer cream,  Wheatgrass shampoo', 'NH004', NULL, NULL, 'Neutralise Naturals: India’s first wheatgrass powder with roots, grown in our cutting-edge Indoor Hydroponic system, It provides effective remedies for all skin problems. Certified by FSSAI, Ayush, and GMP, our product reflects 8 years of meticulous development, backed by rave reviews from hundreds of satisfied customers. Experience the premium difference today.', 'Treat yourself better without antibiotics and steroids, naturally with our proprietary products. Our products are giving better and faster relief naturally by improving your immune system both internally and externally for Person with elements like Psoriasis, Eczema, Dermatitis, Sun burn. These days skin problems are increasing in Indian families reason be food, water, environment pollution.Chemical Free Products and 100 % Naturally Made.Remember! Following diet plan is important for full recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', '[]', 'Soaps-2, Wheat Grass Powder with Roots-1, Moisturiser-1, Shampoo-1', 'Measure: Take one spoonful (3 grams) of Wheatgrass powder. Prepare: Mix the measured powder into a glass of normal or lukewarm water. Timing: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner Frequency: Twice a day.\\\\r\\\\n\\\\r\\\\nDuration: We recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\\\r\\\\n\\\\r\\\\nStorage: Close Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.', 0),
(5, 'Psoriasis, Eczema and dermatitis Skin Care all in One Combo', 2700.00, '4-1.png', '1Q1A0460-copy.jpg', '1Q1A0439.jpg', 'BODY', 'Psoriasis, Eczema and dermatitis Skin', 'NH005', NULL, NULL, 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types, including those with psoriasis and eczema', 'As per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally. Cow Butter as the main ingredient along with essential oils combined with selective traditional herbs are added to suit all skin types is blended to give better moisturizing to improve skin elasticity like Psoriasis, Eczema and other skin conditions,. All Natural ingredients and Essential Aromatherapy Oils have been used to give a Premium and rich experience.', '{\"small\":\"1000g\",\"medium\":\"2000g\"}', 'One packet of Wheatgrass powder with Roots – 100gms, Two packs of Wheatgrass Herbal Premium Soap – 100gms,One pack of Wheatgrass Moisturiser Cream – 50ml,\\\\r\\\\nOne pack of Wheatgrass Herbal Shampoo – 100ml,One Pack Avocado Wheatgrass Facewash – 100ml', 'As per doctors reference', 0),
(6, 'Neutralise Naturals Wheatgrass Powder with Roots', 600.00, 'wheat11.jpg', '3-460x460.jpg', '5-600x600.jpg', 'FACE', 'Best wheatgrass powder, organic wheatgrass powder, Wheatgrass powder', 'NH006', NULL, NULL, 'Wheatgrass is used as health drink as it is an important source of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins and enzymes. Wheatgrass improves immunity, purifies and cleanses the body, aids weight loss and promotes healthy Skin. It is having antioxidant property and fight against free radicals. Remember! Following diet plan is important for full skin recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', 'Neutralise Wheatgrass powder with roots is grown in a Hydroponic soil-free system which gives year-long uninterrupted production along with consistent quality. Our Neutralise wheatgrass is grown for 7 days at the pre-jointing phase of growth, i.e., just before the new leaf begins to form, the sprouts are cut from the top of the seeds and the roots below the seeds remaining middle part (the seed part) will be removed. The grass and roots are separately dehydrated in the sun under UV protected playhouse and made into powder.', '{\"small\":\"250g\",\"medium\":\"500\",\"large\":\"750g\"}', 'Wheatgrass Powder with roots is nature’s gift to mankind., A natural source to maintain good health it is a rich source of amino acids, nutrients, proteins, vitamins, minerals, omega acids etc., Neutralise unique selling point (USP): 7 days crop with roots. Fresh Single crop harvest, there is no second and third harvest. Also, they don’t use any chemicals, pesticides or growing agents. Water used for crops is RO & UV purified drinking water.,Neutralise Wheatgrass Powder with Roots is a complete food supplement that includes grass and roots in the right ratio.,Our unit is FSSAI, Ayush and GMP certified. Helps in curing skin Diseases internally.', ' For the first 4 days take half a T-Spoon of powder and from the 5th day take 1 T-Spoon of Powder in the morning with water, vegetables, or fruit juices. People with Psoriasis, Eczema and other skin diseases can consume 1 spoon of powder in the evening with an empty stomach.', 0),
(7, 'Neutralise Naturals Herbal Wheatgrass Soap | Pack of 2', 700.00, '1Q1A0448.JPG', '1Q1A0460-copy.jpg', '1Q1A0467.jpg', 'FACE', 'herbal soap, soap, wheatgrass soap', 'NH007', NULL, NULL, 'This Ayurvedic soap is made with wheatgrass, desi cow butter, and essential oils. It deeply moisturizes, protects against free radicals, and heals the skin. It’s good for all skin types and helps get rid of acne, scars, and skin problems like eczema and psoriasis while making you feel good and smelling nice. Certified by FSSAI, Ayush, and GMP.', 'Wheatgrass is used as health drink as it is an important source of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins and enzymes. Wheatgrass improves immunity, purifies and cleanses the body,promotes healthy Skin. It is having antioxidant property and fight against free radicals. Neutralise Wheatgrass soap is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system. As per Indian Vedic Astrology Wheat seeds represents Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure. Antioxidants are known to be anti-aging as they repair or prevent skin damage and detox to remove toxins from your body and skin', '{\"small\":\"250g\",\"medium\":\"500g\"}', 'main ingredient along with essential oils, blended to give better moisturizing, and better soft skin.', 'Can be used for body as Bathing Soap. Apply it for the head helps in reducing Dandruff, Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay atleast 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel.\\r\\nImportant! Consuming Neutralise wheatgrass powder is key to resolving any skin problem.', 0),
(8, 'Neutralise Wheatgrass Moisturizer Cream', 500.00, '1Q1A0436.jpg', '1Q1A0439.jpg', 'ma2-768x760.jpg', 'SKIN', 'Neutralise, Wheatgrass Moisturizer Cream', 'NH008', NULL, NULL, 'Neutralise Wheatgrass Moisturizer cream is made with Wheatgrass and Roots and Cow Butter as the main ingredient along with essential oils. Helps in reducing acne and scars, skin infections, lighten dark spots, improve skin texture, etc. Our Unit is FSSAI, Ayush and GMP certified', 'Neutralise Wheatgrass moisturizer is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system. On top of everything else you need to do in the morning is moisturize your skin. Moisturizing doesn’t just feel great, it can even help keep your skin clear, smooth, and wrinkle-free in the future.', '{\"small\":\"250g\",\"medium\":\"500g\"}', 'Wheatgrass with roots, Cow butter, Honey Wax, Turmeric oil, Coconut oil, Til oil, Olive oil, Badam oil, Vitamin E extract.', 'Can be applied for complete body. Take little amount of moisturiser and apply it. If required apply it for sole especially for women’s.', 0),
(9, 'Neutralise Wheatgrass Shampoo & Conditioner', 400.00, '1Q1A0502-scaled.jpg', 'Wheat-Grass-Hair-Shampoo.JPG', 'sm5.jpg', 'HAIR', 'Neutralise, Wheatgrass Shampoo & Conditioner', 'NH009', NULL, NULL, 'Neutralise Wheatgrass shampoo is made from Ayurvedic and Natural Herbs combined with 200 years old Indian traditional Ayurvedic system. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure. Antioxidants are known to be anti-aging as they repair or prevent skin and Hair damage and detox to remove toxins from your body and skin. Wheatgrass – nature’s most effective and gentle cleanser – helps remove excess oil, residue and debris without stripping hair of moisture or vitality.', 'Neutralise Wheatgrass shampoo is made from Ayurvedic and Natural Herbs combined with 200 years old Indian traditional Ayurvedic system. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure. Antioxidants are known to be anti-aging as they repair or prevent skin and Hair damage and detox to remove toxins from your body and skin. Wheatgrass – nature’s most effective and gentle cleanser – helps remove excess oil, residue and debris without stripping hair of moisture or vitality.', '[]', 'Wheat Grass, Coconut oil, different herbs and SLS.', 'Twice or thrice a week for a regular person. People suffering from Psoriasis or irritable scalp can use it on daily basis and see the difference within a few days. First wash cleanses the scalp and second wash gives lather.', 0),
(10, 'Dark Spots/ Pigmentation Combo', 1800.00, '3-1.png', 'wheat11.jpg', '1Q1A0460-copy.jpg', 'COMBO', 'dark spots, dark spots/pigmentation combo, pigmentation', 'NH010', NULL, NULL, 'Our Wheatgrass Ayurvedic products mix desi cow butter with natural herbs, as per 200 years of South Indian Ayurvedic tradition, and are suitable for all skin types, particularly those with psoriasis, eczema, dermatitis, and pigmentation concerns. According to Indian Vedic Astrology, wheat represent the Sun (Surya Graha), and Ayurveda relates considerable skin benefits to the sun’s vitality.', 'Wheatgrass and its roots are high in antioxidants, which help protect the skin from free radicals, environmental toxins, and UV radiation. These antioxidants also have antifungal and antibacterial effects, which help prevent aging, repair skin damage, detoxify, and promote general skin health and immunity. Our composition combines desi cow butter and essential oils with traditional herbs to promote optimal moisture and skin suppleness.', '[]', 'One packet Wheatgrass powder with Roots Rs.600/- 100gms,Two packs Wheatgrass Herbal Premium Soap Rs.350/- 100gms each.,One pack Wheatgrass Moisturizer Cream Rs.500/- 50ml', 'As per doctors recomendation', 0),
(11, 'All Soaps Combo', 1000.00, '1-.png', '1Q1A0454.JPG', '1Q1A0457-copy.jpg', 'BATH', 'herbal soaps, herbal soaps combo, soaps, soaps combo', 'NH011', NULL, NULL, 'Having wheatgrass as a health drink which has a great number of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins, and enzymes. it  improves immunity, purifies and cleanses the body, aids weight loss and promotes healthy skin. It has antioxidant properties and fights against free radicals.', 'At Neutralise Wheat grass is grown for 7 days and on completion of 7day, the grass from the top of the seeds and the roots below the seeds are cut for further use. The middle part (the seed part) will be removed. The grass and roots are separately dehydrated in sun under UV protected playhouse and made into powder. Neutralise soaps are made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system.', '{\"small\":\"100g\"}', 'Wheatgrass Herbal,Tulsi Wheatgrass Herbal, Papaya Wheatgrass Herbal', 'As per doctors reference', 0),
(12, 'Neutralise Naturals – 6 Month Skin Recovery Program – SRP (Psoriasis)', 15000.00, 'IMG-20231012-WA0002-600x600.jpg', 'IMG-20231013-WA0000-600x338.jpg', 'IMG-20231013-WA0001-600x338.jpg', 'SKIN', 'Skin Recovery Program, SRP', 'NH012', NULL, NULL, 'A skin recovery program using natural remedies can be a holistic approach to rejuvenate and heal the skin. Incorporating natural ingredients such as wheatgrass powder can provide a range of benefits due to their rich nutrient profiles. Below is a detailed description of a skin recovery program that leverages the benefits of wheatgrass powder and other natural remedies. Natural remedies for skin recovery involve using plant-based ingredients and lifestyle practices that support the skin’s natural healing processes. These remedies are often gentler on the skin and free from harsh chemicals found in many commercial skincare products.', 'A skin recovery program using natural remedies can be a holistic approach to rejuvenate and heal the skin. Incorporating natural ingredients such as wheatgrass powder can provide a range of benefits due to their rich nutrient profiles. Below is a detailed description of a skin recovery program that leverages the benefits of wheatgrass powder and other natural remedies. Natural remedies for skin recovery involve using plant-based ingredients and lifestyle practices that support the skin’s natural healing processes. These remedies are often gentler on the skin and free from harsh chemicals found in many commercial skincare products. Wheatgrass powder is derived from the young shoots of the wheat plant. It is packed with vitamins, minerals, amino acids, and antioxidants.', '[]', 'Contains vitamins A, Contains vitamins C, and Contains vitamins E which are crucial for skin health', 'As per doctors suggestion', 0),
(13, 'Neutralise Premium Herbal Tulasi Wheatgrass Soap | pack of 2', 700.00, '1Q1A0448.JPG', '1Q1A0465.jpg', '1Q1A0467.jpg', 'BATH', ' herbal soap, Tulasi Soap, wheatgrass soap', 'NH013', NULL, NULL, 'Wheatgrass is used as health drink as it is an important source of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins and enzymes. It improves immunity, purifies and cleanses the body, and promotes healthy skin. It is having antioxidant property and fight against free radicals.', 'At Neutralise it is grown for 7 days and on completion of 7day the grass from the top of the seeds and the roots below the seeds are cut for further use. The middle part (the seed part) will be removed.The grass and roots are separately dehydrated in sun under UV protected playhouse and made into powder. Neutralise Wheatgrass/Tulasi soap is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system. As per Indian Vedic Astrology Wheat seeds represents Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin. Tulasi is great for the skin.', '[]', 'Tulsi added to the soap suits all skin types particularly with skin ailments like Psoriasis, Eczema etc., help treat acne and scars, skininfections, lighten dark spots,improve skin texture', 'Can be used for body as Bathing Soap. Apply it for the head helps in reducing Dandruff,Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay atleast 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel.', 0),
(14, 'Neutralise Premium Herbal Papaya Wheatgrass Soap | Pack of 2', 700.00, '1Q1A0448.JPG', '1Q1A0456.jpg', 't6-600x600.jpg', 'FACE', 'Skincare', 'NH014', NULL, NULL, 'Wheatgrass is used as health drink as it is an important source of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins and enzymes. It improves immunity, purifies and cleanses the body, aids weight loss and promotes healthy skin. It also has antioxidant properties and fights against free radicals.', 'At Neutralise Wheatgrass is grown for 7 days and on completion of 7 day the grass from the top of the seeds and the roots below the seeds are cut for further use. The middle part (the seed part) will be removed. The grass and roots are separately dehydrated in sun under UV protected playhouse and made into powder. Neutralise Papaya soap is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system.', '[]', ' natural ingredients, acts as a natural scrub, helps in preventing premature aging of the skin and cellular damage.', ' Can be used for the body as Bathing Soap. Applying it to the head helps in reducing Dandruff, Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay at least 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel', 0),
(15, 'Neutralise Naturals Wheatgrass Avocado Herbal Face Wash', 500.00, '1Q1A0512c.jpg', '1Q1A0483-copy.jpg', '', 'FACE', ' Avocado facewash, facewash, herbal facewash, Wheatgrass Avocado Herbal Face Wash', 'NH015', NULL, NULL, 'Having Wheatgrass as a health drink which has a great number of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins, and enzymes. Wheatgrass Avocado Herbal Face Wash is a healthy addition to the health of the facial skin Wheatgrass improves immunity, purifies and cleanses the body, aids weight loss and promotes healthy skin. It has antioxidant properties and fights against free radicals.', 'As wheatgrass avocado herbal face wash has antioxidants that are known to be anti-ageing as they repair or prevent skin damage.\\\\r\\\\n\\\\r\\\\nAnd detox to remove toxins from your body and skin. Avocados are a great source of biotin and are known to help prevent dry skin when applied topically. Avocado is a butter fruit consisting high in healthy fats, but they’re also an excellent source of B complex vitamins E and C both of which play a key role in the health and vitality of your skin. Wheatgrass Avocado Herbal Face Wash made with Wheatgrass and Roots, Avocado, and Desi Cow Butter as the main ingredients, along with essential oils in a proprietary technology, make the Face Wash more effective. Highly recommended for skin problems like Dry Skin, Pimples, Acne, pigmentation, Anti-ageing, soft-skin Psoriasis, Eczema, Itching, etc.', '[]', 'Made with Wheatgrass and Roots, Avocado and Desi Cow Butter as the main ingredient, essential oils in a proprietary technology make the Face Wash more effective.', 'As per doctors recomendation', 0),
(16, 'Psoriasis, Eczema and dermatitis Skin Care all One One Combo', 2350.00, 'All-In-One-Combo.JPG', '1Q1A0472.JPG', '1Q1A0460-copy.jpg', 'COMBO', 'Psoriasis, Eczema and dermatitis Skin Care all One One Combo', 'NH016', NULL, NULL, 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types. Including those with psoriasis and Eczema. As per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin.', 'Wheatgrass and Roots are high in antioxidants, preventing damage from free radicals including environmental toxins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally.', '[]', 'Cow Butter as the main ingredient, along with essential oils combined with selective traditional herbs are added, give better moisturizing to improve skin elasticity like Psoriasis Eczema and other skin conditions,.', 'As per suggested', 0),
(17, 'Psoriasis, Eczema and dermatitis Skin Care Starter Combo', 1450.00, '5.png', '1Q1A0460 (1).jpg', '1Q1A0439.jpg', 'COMBO', 'Psoriasis, Eczema and dermatitis Skin Care Starter Combo', 'NH017', NULL, NULL, 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types. Including those to Psoriasis , Eczema and Dermatitis. As per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin.', 'Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental tosins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally.', '[]', 'Cow Butter as the main ingredient along with essential oils, combined with selective traditional herbs, give better moisturizing to improve skin elasticity like Psoriasis Eczema and other skin conditions,.', 'As per recommended', 0);

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
(0, 'Diksha Sonawane', 'sonawanediksha14@gmail.com', '9412356789', 'nashik', '$2y$10$VlV2cZzvPd0wgdcTBIe7EeESy3jdTJFAabgEng8sFKOIUvVluv1/e', '2024-12-30 06:55:05');

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
(1, 'Venkata Ramana', '2022-01-20', 'నాకు డ్రై స్కిన్ సమస్య ఉంది నేను ఇద్దరి డాక్టర్స్ దెగ్గరికి వెళ్ళాను అది తాత్కాలికంగా పంచేసింది మళ్ళీ చలికాలం వస్తే వచ్చేది వీతగ్రాస్ పౌడర్ వాడటం వలన డ్రైస్కిన్ సమస్య తగ్గుతున్నది', '5', 'unnamed.png'),
(2, 'B Pavan Bellamkonda', '2023-08-20', 'All businesses with only 5 star reviews are usually fake reviews. But not this one, it deserves 5 stars. I have seen so many people who had complete relief from psoriasisand such autoimmune skin disorders by using their products. It truly is helping a lot of people where superficial treatments from other sections of healthcare (eg Allopathy) have not worked even after spending loads of time and money. Good luck with your endeaveours. And please those with skin disorders make a journey with this company to help you lead a healthy life...', '5', 'unnamed (2).png'),
(3, 'Radhakrishna Ayyalasomayyajula', '2022-01-20', 'I purchased Fresh Wheat grass for my wife. It\\\'s nutritious value is very high and works as a wonderful natural medicine for various ailments. It can be kept in Fridge and used for a short period without losing the nutrients. Apart from Wheatgrass, various beauty products are also available. Prices are quite reasonable as customers directly buy from the producer.', '5', 'unnamed (4).png'),
(4, 'Sridhar Sunkari', '2022-01-20', 'ఒక ప్రాడక్ట్ కొసం ఇంత జెన్యూన్ గా ఇంత హెల్తిగా ఇవ్వడనికి వీళ్ళు చాలా హార్డ్ వర్క్ చేస్తున్నారు,,,వీళ్ళ దగ్గర ప్రైస్ గురంచి మాట్లాడి వీళ్ళని తక్కవ చేయలేయం,,,,, నేను రెగ్యులర్ గా ఈ ప్రౌడాక్ట్స్ వాడుతున్నాను,,,,,, 🙏🙏🙏🙏🙏', '5', 'unnamed (1).png'),
(5, 'Mallela Jyothi', '2022-03-25', 'his product is really amazing for psoriasis\\r\\nWe spent lakhs of rupees on this skin disease but finally Mantena Satya Narayana sir said about this product… we started using this wheat grass powder lotion shampoo and cream from last one and half year onwards…. It is showing amazing results in a1 month only along with this we avoided salt and we ate fruits as dinner time now it has reduced 85/% thank you 🙏🏻\\r\\n\\r\\n', '5', 'users.png'),
(6, 'safiya rehan', '2022-01-20', 'Skin prblms unna vallaki world mothham lo akkada vethikina entha kanna manchi product dhorakadhu,chala manchi product and very healthy', '5', 'users.png'),
(7, 'Teena V', '2021-05-25', 'Bought fresh wheat grass from here, quality is good.', '5', 'users.png');

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
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
