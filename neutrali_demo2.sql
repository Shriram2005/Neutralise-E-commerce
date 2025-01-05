-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2025 at 10:48 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neutrali_demo2`
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `content` text,
  `post_date` date DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `excerpt` text,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `size_option` varchar(50) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `size_option`, `added_at`) VALUES
(14, NULL, 6, 8, NULL, '2025-01-03 19:19:34'),
(15, NULL, 5, 3, NULL, '2025-01-03 19:20:18'),
(16, NULL, 13, 1, NULL, '2025-01-05 17:00:57');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Cash on Delivery',
  `payment_status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `order_date`, `shipping_address`, `payment_method`, `payment_status`) VALUES
(4, 0, 1801.00, 'Pending', '2024-12-27 13:01:39', 'nashik', 'Cash on Delivery', 'Pending');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `our_approach`
--

CREATE TABLE `our_approach` (
  `id` int(11) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `our_promise`
--

INSERT INTO `our_promise` (`id`, `image`, `intro_text`, `list_items`, `closing_text`) VALUES
(1, 'image2.png', 'At Neutralise Naturals, we promise:', '100% natural, chemical-free products, Faster and better relief compared to alternative medicines, Ongoing research and development for continuous improvement, Exceptional customer support and guidance', 'Once you experience our products, you\'ll understand why our customers keep coming back.');

-- --------------------------------------------------------

--
-- Table structure for table `our_story`
--

CREATE TABLE `our_story` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `description` text,
  `full_description` text,
  `size_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ingredients` text,
  `usage_instructions` text,
  `featured` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image1`, `image2`, `image3`, `category`, `tags`, `sku`, `rating`, `reviews_count`, `description`, `full_description`, `size_options`, `ingredients`, `usage_instructions`, `featured`) VALUES
(5, 'Neutralise Total Skin Combo', 2650.00, 'combo.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'Neutralise Naturals: India’s first wheatgrass powder with roots, grown in our cutting-edge Indoor Hydroponic system, It provides effective remedies for all skin problems. Certified by FSSAI, Ayush, and GMP, our product reflects 8 years of meticulous development, backed by rave reviews from hundreds of satisfied customers. Experience the premium difference today.', 'Treat yourself better without antibiotics and steroids, naturally with our proprietary products\\r\\nPack Contents : Soaps-2, Wheat Grass Powder with Roots-1, Moisturiser-1, Shampoo-1\\r\\nOur products are giving better and faster relief naturally by improving your immune system both internally and externally for Person with elements like Psoriasis, Eczema, Dermatitis, Sun burn\\r\\nThese days skin problems are increasing in Indian families reason be food, water, environment pollution.\\r\\nChemical Free Products and 100 % Naturally Made.\\r\\nRemember! Following diet plan is important for full recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', '{\"small\":\"100g\"}', 'its made with wheat and grass powder', 'Measure: Take one spoonful (3 grams) of Wheatgrass powder. Prepare: Mix the measured powder into a glass of normal or lukewarm water. Timing: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner Frequency: Twice a day.\\r\\n\\r\\nDuration: We recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\r\\n\\r\\nStorage: Close Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.', 0),
(6, 'Neutralise Wheatgrass Powder With Roots', 750.00, 'grass powder.jpg', '', '', 'HAIR', 'natural', '-----', NULL, NULL, 'Neutralise Wheatgrass powder with roots is grown in a Hydroponic soil-free system which gives year-long uninterrupted production along with consistent quality.\\r\\n\\r\\nOur Neutralise wheatgrass is grown for 7 days at the pre-jointing phase of growth, i.e., just before the new leaf begins to form, the sprouts are cut from the top of the seeds and the roots below the seeds remaining middle part (the seed part) will be removed.\\r\\n\\r\\nThe grass and roots are separately dehydrated in the sun under UV protected playhouse and made into powder.', 'Wheatgrass Powder with roots is nature’s gift to mankind. \\r\\nA natural source to maintain good health it is a rich source of amino acids, nutrients, proteins, vitamins, minerals, omega acids, etc.\\r\\nNeutralise unique selling point (USP): 7 days crop with roots. Fresh Single crop harvest, there is no second and third harvest. Also, they don’t use any chemicals, pesticides or growing agents. Water used for crops is RO & UV purified drinking water.\\r\\nNeutralise Wheatgrass Powder with Roots is a complete food supplement that includes grass and roots in the right ratio.\\r\\nOur unit is FSSAI, Ayush and GMP certified. Helps in curing skin Diseases internally.\\r\\nDirections for Usage: For the first 4 days take half a T-Spoon of powder and from the 5th day take 1 T-Spoon of Powder in the morning with water, vegetables, or fruit juices. People with Psoriasis, Eczema and other skin diseases can consume 1 spoon of powder in the evening with an empty stomach.', '{\"small\":\"250g\",\"medium\":\"500g\",\"large\":\"750g\"}', 'made with natural grass', 'Measure: Take one spoonful (3 grams) of Wheatgrass powder. Prepare: Mix the measured powder into a glass of normal or lukewarm water. Timing: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner Frequency: Twice a day.\\r\\n\\r\\nDuration: We recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\r\\n\\r\\nStorage: Close Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.', 0),
(7, 'neutralise wheatgrass moisturizer cream', 600.00, 'cream.jpg', '', '', 'BODY', 'natural', '-----', NULL, NULL, 'Neutralise Wheatgrass moisturizer is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system. On top of everything else you need to do in the morning is moisturize your skin. Moisturizing doesn’t just feel great, it can even help keep your skin clear, smooth, and wrinkle-free in the future.\\r\\n', 'Made with Wheatgrass and Roots and Cow Butter as the main ingredient along with essential oils is blended to give better moisturizing and soft skin.\\r\\nHelps in reducing acne and scars, skin infections, lighten dark spots, improve skin texture, etc. Our Unit is FSSAI, Ayush and GMP certified.\\r\\nIngredients : Wheatgrass with roots, Cow butter, Honey Wax, Turmeric oil, Coconut oil, Til oil, Olive oil, Badam oil, Vitamin E extract.\\r\\nOur Unit is FSSAI, Ayush and GMP certified. Helps in prevention of Skin related problems\\r\\n', '[]', 'made with grass', 'Direction for Usage : Can be applied for complete body. Take little amount of moisturiser and apply it. If required apply it for sole especially for women’s.\\r\\nImportant! Consuming Neutralise wheatgrass powder is key to resolving any skin problem.\\r\\nRemember! Following diet plan is important for full skin recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', 0),
(13, 'Neutralise Wheatgrass Shampoo & Conditioner', 500.00, 'shampoo.jpg', '', '', 'HAIR', 'natural', '-----', NULL, NULL, '3X potent Wheatgrass shampoo is also an All Natural conditioner and soft scrub. Highly recommended as Anti Dandruff , Anti Itching, Anti Irritation and Hair Fall control.\\r\\nNatural herbs processed in a proprietary technique along with SLS makes the Wheat grass shampoo 3 times more effective.\\r\\nCan use 2 to 3 times a week for normal people. If you’re effected with Scalp Psoriasis then use it on daily basis\\r\\n', 'Neutralise Wheatgrass shampoo is made from Ayurvedic and Natural Herbs combined with 200 years old Indian traditional Ayurvedic system. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure. Antioxidants are known to be anti-aging as they repair or prevent skin and Hair damage and detox to remove toxins from your body and skin. Wheatgrass – nature’s most effective and gentle cleanser – helps remove excess oil, residue and debris without stripping hair of moisture or vitality.', '[]', ' Wheat Grass, Coconut oil, different herbs and SLS.\\r\\n', 'Twice or thrice a week for a regular person. People suffering from Psoriasis or irritable scalp can use it on daily basis and see the difference within a few days. First wash cleanses the scalp and second wash gives lather.\\r\\nImportant! Consuming Neutralise wheatgrass powder is key to resolving any skin problem.\\r\\nRemember! Following diet plan is important for full skin recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', 0),
(14, 'Neutralise Naturals Herbal Wheatgrass Soap | Pack of 2', 800.00, 'soap.jpg', '', '', 'BODY', 'natural', '-----', NULL, NULL, 'This Ayurvedic soap is made with wheatgrass, desi cow butter, and essential oils. It deeply moisturizes, protects against free radicals, and heals the skin. It’s good for all skin types and helps get rid of acne, scars, and skin problems like eczema and psoriasis while making you feel good and smelling nice. Certified by FSSAI, Ayush, and GMP', 'Neutralise Wheatgrass soap is made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system. As per Indian Vedic Astrology Wheat seeds represents Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin. Wheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure. Antioxidants are known to be anti-aging as they repair or prevent skin damage and detox to remove toxins from your body and skin.', '[]', 'Desi Cow Butter as the main ingredient along with essential oils is blended to give better moisturizing and soft skin.', 'Can be used for body as Bathing Soap. Apply it for the head helps in reducing Dandruff, Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay atleast 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel.', 0),
(16, 'Basic Skin Kit', 2900.00, 'body kit.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'Wheat sprout grass powder with roots (2X 100g).\\r\\nWheatgrass herbal soaps (2X 100g)\\r\\nWheatgrass moisturizer cream', 'Basic Skin Kit is specially designed for individuals who have been grappling with skin problems for months or even years, with approximately 10% of their body affected by symptoms like scaling, itching, or thickness. For one month use.', '{\"wheat sprout grass powder with roots\":\"100g\",\"Wheatgrass herbal soaps\":\"100g\"}', 'made with organic grass, wheat and cow butter', 'Wheatgrass Powder:\\r\\n\\r\\nMeasure: Take one spoonful (3 grams) of Wheatgrass powder. Prepare: Mix the measured powder into a glass of normal or lukewarm water. Timing: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner Frequency: Twice a day\\r\\n\\r\\nDuration: We recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\r\\n\\r\\nStorage: Close Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.\\r\\n\\r\\n \\r\\n\\r\\nWheatgrass Herbal Soap\\r\\n\\r\\nUse as Normal: Use our Herbal Therapeutic Soap like your regular bathing soap.\\r\\n\\r\\nApplication: Apply the soap to wet skin, gently massaging it in. Wait for 5 minutes. After applying the soap, refrain from washing it off immediately. Allow the herbal ingredients to work their magic for atleast 5 minutes.\\r\\n\\r\\nRinse Off: After the 5-minute wait, rinse off the soap thoroughly with water.\\r\\n\\r\\nPat Dry: Gently pat your skin dry with a towel.\\r\\n\\r\\n\\r\\nWheatgrass Herbal Cream\\r\\n\\r\\nDispense Cream: Take a small amount of the dense Wheatgrass cream onto your fingertips.\\r\\n\\r\\nApplication: Spread the cream over the affected area, covering it generously. Use a small amount like Zandu Balm; a little goes a long way.\\r\\n\\r\\nFrequency: Apply as needed throughout the day on affected areas. For best results, use at least twice a day after bathing and drying your body.\\r\\n\\r\\nScalp Application: For scalp psoriasis or dandruff, gently massage the cream directly onto the scalp.', 0),
(19, 'Basic Body Kit', 3400.00, 'kit.jpg', '', '', 'BODY', 'natural', '-----', NULL, NULL, 'Wheat sprout grass powder with roots (2X 100g).\\r\\nWheatgrass herbal soaps (2X 100g)\\r\\nWheatgrass moisturizer cream (50 ml)\\r\\nWheatgrass Shampoo (100 ml)', 'Basic Body Kit Tailored for individuals contending with skin problems affecting the scalp and other body parts, our Basic Body Kit is meticulously crafted to help reverse the skin problem. Approximately 10% of the scalp and body is afflicted with symptoms such as scaling, itching, or thickness, making this kit a targeted product for relief and reversal.', '{\"Wheat sprout powder with roots\":\"100g\",\"Wheatgrass herbal soaps\":\"100g\",\"Wheatgrass moisturizer cream\":\"50ml\",\"Wheatgrass Shampoo\":\"100ml\"}', 'made with grass,wheat and cow butter', 'Wheatgrass Powder:\\r\\n\\r\\nMeasure: Take one spoonful (3 grams) of Wheatgrass powder.\\r\\n\\r\\nPrepare: Mix the measured powder into a glass of normal or lukewarm water.\\r\\n\\r\\nTiming: Consume the mixture on an empty stomach, preferably in the morning atleast 30 mins before breakfast. For second time in the day 2 hours after a meal/snack and 30 mins before dinner\\r\\n\\r\\nFrequency: Twice a day\\r\\n\\r\\nDuration: We recommend consistent daily use for a minimum of 4 months to observe significant improvements.\\r\\n\\r\\nStorage: Close Ziplock after using and Store the Wheatgrass powder in a cool, dry place away from direct sunlight to maintain its freshness.\\r\\n\\r\\n \\r\\n\\r\\nWheatgrass Herbal Soap\\r\\n\\r\\nUse as Normal: Use our Herbal Therapeutic Soap like your regular bathing soap.\\r\\n\\r\\nApplication: Apply the soap to wet skin, gently massaging it in. Wait for 5 Minutes. After applying the soap, refrain from washing it off immediately. Allow the herbal ingredients to work their magic for atleast 5 minutes.\\r\\n\\r\\nRinse Off: After the 5-minute wait, rinse off the soap thoroughly with water.\\r\\n\\r\\nPat Dry: Gently pat your skin dry with a towel.\\r\\n\\r\\n \\r\\n\\r\\nWheatgrass Herbal Cream\\r\\n\\r\\nDispense Cream: Take a small amount of the dense Wheatgrass cream onto your fingertips.\\r\\n\\r\\nApplication: Spread the cream over the affected area, covering it generously. Use a small amount like Zandu Balm; a little goes a long way.\\r\\n\\r\\nFrequency: Apply as needed throughout the day on affected areas. For best results, use at least twice a day after bathing and drying your body Scalp .\\r\\n\\r\\nApplication: For scalp psoriasis or dandruff, gently massage the cream directly onto the scalp.\\r\\nWheatgrass Shampoo\\r\\n\\r\\nDispense Shampoo: Pour a small amount of Neutralise’s Wheatgrass shampoo into your palm.\\r\\n\\r\\nApplication: Apply the shampoo to wet hair and scalp, focusing on areas prone to dandruff, psoriasis, or irritation.\\r\\n\\r\\nMassage: Gently massage the shampoo into your scalp using circular motions for about 1-2 minutes.\\r\\n\\r\\nLeave On: Leave the shampoo on your scalp for an additional 2-3 minutes to allow the herbal ingredients to penetrate and work effectively, targeting dandruff and scalp issues.\\r\\n\\r\\nRinse: Rinse your hair thoroughly with water.\\r\\n\\r\\nRepeat: For best results, repeat the process by applying the shampoo for a second time. The first wash cleanses the scalp, while the second wash creates a lather for a deeper cleanse.\\r\\n\\r\\nFrequency: For regular use, shampoo your hair and scalp with Neutralise’s Wheatgrass shampoo twice or thrice a week. However, individuals suffering from dandruff, Psoriasis, or irritable scalp can use it on a daily basis to see noticeable improvements.', 0),
(20, 'Psoriasis Eczema and dermatitis Wheatgrass Skin Care Combo', 2150.00, 'skin care combo.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'One packet Wheatgrass powder with Roots Rs.600/- 100gms\\r\\n\\r\\nTwo packs Wheatgrass Herbal Premium Soap Rs.350/- 100gms each.\\r\\n\\r\\nOne pack Wheatgrass Moisturizer Cream Rs.500/- 50ml', 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types.\\r\\n\\r\\nAs per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin.\\r\\n\\r\\nWheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental tosins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally.', '{\"One packet Wheatgrass powder with Roots\":\"100gms\",\"Two packs Wheatgrass Herbal Premium Soap\":\"100gms\",\"One pack Wheatgrass Moisturizer Cream\":\"50ml\"}', 'Cow Butter as the main ingredient along with essential oils combined with selective traditional herbs are added to suit all skin types is blended to give better moisturizing to improve skin elasticity like Psoriasis, Eczema and other skin conditions,.', 'Twice or thrice a week for a regular person. People suffering from Psoriasis or irritable scalp can use it on daily basis and see the difference within a few days. First wash cleanses the scalp and second wash gives lather.\\r\\nImportant! Consuming Neutralise wheatgrass powder is key to resolving any skin problem.\\r\\nRemember! Following diet plan is important for full skin recovery. Contact us at 9000088227 or select “Diet Plan” in chat box.', 0),
(21, 'Psoriasis Eczema and dermatitis Skin Care all in one Combo', 3250.00, 'all in one combo.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'One packet of Wheatgrass powder with Roots – 100gms\\r\\n\\r\\nTwo packs of Wheatgrass Herbal Premium Soap – 100gms\\r\\n\\r\\nOne pack of Wheatgrass Moisturiser Cream – 50ml\\r\\n\\r\\nOne pack of Wheatgrass Herbal Shampoo – 100ml\\r\\n\\r\\nOne Pack Avocado Wheatgrass Facewash – 100ml', 'A combination of Wheatgrass proprietary ayurvedic products made with desi cow butter and natural herbs combined with 200 years of south Indian traditional ayurvedic practices made our products to suet all skin types, including those with psoriasis and eczema\\r\\n\\r\\nAs per Indian Vedic Astrology wheat seed symbolizes to the Sun (Surya Graha) and Ayurveda says wheat has the power of sun and sun energy is most important for good skin.\\r\\n\\r\\nWheatgrass and Roots are high in antioxidants preventing damage from free radicals including environmental toxins and UV exposure, Antioxidants that are antifungal and antibacterial properties present in wheatgrass and roots are known to be anti-aging as they repair and prevent skin damages and detox to remove toxins from the body and skin to help improve immunity both internally and externally and heal skin problems naturally.', '[]', 'Cow Butter as the main ingredient along with essential oils combined with selective traditional herbs are added to suit all skin types is blended to give better moisturizing to improve skin elasticity like Psoriasis, Eczema and other skin conditions,.', 'Can be used for body as Bathing Soap. Apply it for the head helps in reducing Dandruff, Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay atleast 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel.', 0),
(22, 'Dark Spots / Pigmentation Combo', 2150.00, 'dark spots.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'packet Wheatgrass powder with Roots Rs.600/- 100gms\\r\\n\\r\\nTwo packs Wheatgrass Herbal Premium Soap Rs.350/- 100gms each.\\r\\n\\r\\nOne pack Wheatgrass Moisturizer Cream Rs.500/- 50ml', 'Our Wheatgrass Ayurvedic products mix desi cow butter with natural herbs, as per 200 years of South Indian Ayurvedic tradition, and are suitable for all skin types, particularly those with psoriasis, eczema, dermatitis, and pigmentation concerns.\\r\\n\\r\\nAccording to Indian Vedic Astrology, wheat represent the Sun (Surya Graha), and Ayurveda relates considerable skin benefits to the sun’s vitality.\\r\\n\\r\\nWheatgrass and its roots are high in antioxidants, which help protect the skin from free radicals, environmental toxins, and UV radiation. These antioxidants also have antifungal and antibacterial effects, which help prevent aging, repair skin damage, detoxify, and promote general skin health and immunity.\\r\\n\\r\\n', '[]', 'Our composition combines desi cow butter and essential oils with traditional herbs to promote optimal moisture and skin suppleness.', 'Twice or thrice a week for a regular person. People suffering from Psoriasis or irritable scalp can use it on daily basis and see the difference within a few days. First wash cleanses the scalp and second wash gives lather.\\r\\nImportant! Consuming Neutralise wheatgrass powder is key to resolving any skin problem.\\r\\n', 0),
(23, 'All Soaps Combo', 1200.00, 'all soaps.jpg', '', '', 'COMBO', 'natural', '-----', NULL, NULL, 'Wheatgrass Herbal Premium Soap Rs.350/- 100gms\\r\\n\\r\\nTulsi Wheatgrass Herbal Premium Soap Rs.350/- 100gms\\r\\n\\r\\nPapaya Wheatgrass Herbal Premium Soap Rs.350/- 100gms', 'Having wheatgrass as a health drink which has a great number of antioxidants, bioactive compounds, chlorophylls, amino acids, vitamins, and enzymes. it  improves immunity, purifies and cleanses the body, aids weight loss and promotes healthy skin. It has antioxidant properties and fights against free radicals.At Neutralise Wheat grass is grown for 7 days and on completion of 7day, the grass from the top of the seeds and the roots below the seeds are cut for further use. The middle part (the seed part) will be removed. The grass and roots are separately dehydrated in sun under UV protected playhouse and made into powder. Neutralise soaps are made from Ayurvedic and Natural Herbs combined with 200 years old South Indian traditional Ayurvedic system.', '[]', 'Cow Butter as the main ingredient along with essential oils combined with selective traditional herbs are added to suit all skin types is blended to give better moisturizing to improve skin elasticity like Psoriasis, Eczema and other skin conditions,.', 'Can be used for body as Bathing Soap. Apply it for the head helps in reducing Dandruff, Scalp Psoriasis. Don’t immediately Wash off the Soap while bathing stay atleast 2-5 minutes, and then wash off your body for better results. It can also be used for Shaving instead of Shaving gel.', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `percentage_score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `full_name`, `email`, `phone`, `address`, `password`, `created_at`) VALUES
(1, 'Shriram mange', 'shrirammange1@gmail.com', '7821851927', 'nashik', '$2y$10$cOcmWHMyoKTSds99QF6rtu2Z5BFAGikIz4q85f3YOF75bqkYNRJEG', '2024-12-25 12:05:29');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(14, 'Darshan', '2024-12-23', 'efgsefgsyufvshdfsgfusgfzbkd\\\\\\\\r\\\\\\\\nsbgkusjdfjdbkz.z/odilghkbdkfjbd\\\\\\\\r\\\\\\\\nndgjkbdkgmjxbvjmnfd fmn  ', '4', 'users.png'),
(15, 'Sneha', '2024-12-12', 'jsefgsjGFjgsfydhcvfrsdhygffffuygfdhvyregfdhnvhergdvhbcxhvfdhfgxvcbdnxfvmdsfg,dujgfbvfdnvcxhnbdjghksrghsrjgbd vc', '2', 'users.png'),
(16, 'TechEntrance', '2024-12-13', 'Noiceeee Products!!!!!!!!!!!', '5', 'favicon.png'),
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
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
