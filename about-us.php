<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Neutralise Naturals - Luxury Skincare</title>

    <!-- stylesheet -->
     <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/about-us.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
</head>

<body>


 <!-------- Navbar --------->
    <?php include 'header.php';?>

    <!-- <div class="navbar">
        <a href="#about">About Us</a>
    </div> -->


    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>About Neutralise Naturals</h1>
            <p>Revolutionizing skincare with the power of nature</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <?php
// Database connection (replace with your actual database credentials)
include('connection.php');
// Fetch story content from the database
$query = "SELECT heading, text, image FROM our_story LIMIT 1"; // Assuming a table named 'our_story'
$result = mysqli_query($con, $query);

// Initialize variables with default values
$heading = "Our Story";
$text = "Content coming soon.";
$image = "default-image.jpg"; // Replace with the path to your default image

// Retrieve data if available
if ($row = mysqli_fetch_assoc($result)) {
    $heading = htmlspecialchars($row['heading']);
    $text = nl2br(htmlspecialchars($row['text'])); // Convert newlines to <br> for proper formatting
    $image = htmlspecialchars($row['image']); // Path to the image
}


?>

<section class="our-story">
    <div class="container">
        <h2><?php echo $heading; ?></h2>
        <div class="story-content">
            <div class="story-text">
                <p><?php echo $text; ?></p>
            </div>
            <div class="story-image">
                <img src="<?php echo './contents/aboutUs/' . $image; ?>" alt="<?php echo $heading; ?>" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- 
    <section class="our-story">
        <div class="container">
            <h2>Our Story</h2>
            <div class="story-content">
                <div class="story-text">
                    <p>Neutralise Naturals, a brand of Sri Satyajyothi Agro foods, brings you India's first wheatgrass powder with roots, grown in our innovative Indoor Hydroponic soil-free process.</p>
                    <p>Our journey began with a simple mission: to harness the power of nature and provide effective, natural solutions for chronic skin conditions like psoriasis.</p>
                </div>
                <div class="story-image">
                    <img src="./contents/aboutUs/image1.JPG" alt="Our Story" loading="lazy">
                </div>
            </div>
        </div>
    </section> -->



    <!-- Our Approach Section -->
    <?php


// Fetch approach cards data from the database
$query = "SELECT icon_class, title, description FROM our_approach";
$result = mysqli_query($con, $query);
?>

<section class="our-approach">
    <div class="container">
        <h2>Our Approach</h2>
        <div class="approach-cards">
            <?php
            // Loop through the fetched data and dynamically create the cards
            while ($row = mysqli_fetch_assoc($result)) {
                $icon_class = htmlspecialchars($row['icon_class']); // Icon class (e.g., fas fa-leaf)
                $title = htmlspecialchars($row['title']); // Card title
                $description = htmlspecialchars($row['description']); // Card description
            ?>
                <div class="approach-card">
                    <i class="<?php echo $icon_class; ?>"></i>
                    <h3><?php echo $title; ?></h3>
                    <p><?php echo $description; ?></p>
                </div>
            <?php
            }
            // Close the database connection
            // mysqli_close($con);
            ?>
        </div>
    </div>
</section>

 <!--    <section class="our-approach">
        <div class="container">
            <h2>Our Approach</h2>
            <div class="approach-cards">
                <div class="approach-card">
                    <i class="fas fa-leaf"></i>
                    <h3>Natural Ingredients</h3>
                    <p>We use only the finest natural ingredients, carefully selected for their healing properties.</p>
                </div>
                <div class="approach-card">
                    <i class="fas fa-flask"></i>
                    <h3>Scientific Formulation</h3>
                    <p>Our products are developed in collaboration with renowned Ayurvedic experts.</p>
                </div>
                <div class="approach-card">
                    <i class="fas fa-heart"></i>
                    <h3>Holistic Healing</h3>
                    <p>We focus on improving your immune system both internally and externally.</p>
                </div>
            </div>
        </div>
    </section> -->



    <!-- Our Promise Section -->

    <?php


// Fetch promise content from the database
$query = "SELECT image, intro_text, list_items, closing_text FROM our_promise LIMIT 1";
$result = mysqli_query($con, $query);

// Default values in case no data is found
$image = "default-image.png";
$intro_text = "Content coming soon.";
$list_items = "";
$closing_text = "";

if ($row = mysqli_fetch_assoc($result)) {
    $image = htmlspecialchars($row['image']);
    $intro_text = nl2br(htmlspecialchars($row['intro_text']));
    $list_items = htmlspecialchars($row['list_items']); // Comma-separated list items
    $closing_text = nl2br(htmlspecialchars($row['closing_text']));
}

// Convert list items to an array
$list_items_array = array_map('trim', explode(',', $list_items));

// Close the database connection
mysqli_close($con);
?>

<section class="our-promise">
    <div class="container">
        <h2>Our Promise</h2>
        <div class="promise-content">
            <div class="promise-image">
                <img src="<?php echo './contents/aboutUs/' . $image; ?>" alt="Our Promise" loading="lazy">
            </div>
            <div class="promise-text">
                <p><?php echo $intro_text; ?></p>
                <ul>
                    <?php
                    // Loop through the list items and render them
                    foreach ($list_items_array as $item) {
                        echo '<li>' . htmlspecialchars($item) . '</li>';
                    }
                    ?>
                </ul>
                <p><?php echo $closing_text; ?></p>
            </div>
        </div>
    </div>
</section>


    <!-- <section class="our-promise">
        <div class="container">
            <h2>Our Promise</h2>
            <div class="promise-content">
                <div class="promise-image">
                    <img src="./contents/aboutUs/image2.png" alt="Our Promise" loading="lazy">
                </div>
                <div class="promise-text">
                    <p>At Neutralise Naturals, we promise:</p>
                    <ul>
                        <li>100% natural, chemical-free products</li>
                        <li>Faster and better relief compared to alternative medicines</li>
                        <li>Ongoing research and development for continuous improvement</li>
                        <li>Exceptional customer support and guidance</li>
                    </ul>
                    <p>Once you experience our products, you'll understand why our customers keep coming back.</p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Our Vision Section -->
    <section class="our-vision">
        <div class="container">
            <h2>Our Vision</h2>
            <div class="vision-content">
                <p>"We believe that nature has all the solutions. Our dream is to make India healthy again, using the miraculous power of wheatgrass. When you think of natural skincare, we want Neutralise Naturals to be your first choice."</p>
            </div>
        </div>
    </section>

    <!-- Join Us Section -->
    <section class="join-us">
        <div class="container">
            <h2>Join Our Natural Health Revolution</h2>
            <p>Experience the power of nature with Neutralise Naturals</p>
            <a href="./shop.php" class="cta-button">Shop Now</a>
        </div>
    </section>

    <!-- Footer -->
   <?php include('footer.php');?>
  
    <script>
        // Simple script to add fade-in effect
        document.addEventListener('DOMContentLoaded', (event) => {
            const sections = document.querySelectorAll('section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {threshold: 0.1});

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>

</body>

</html>