<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=86400">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jacques+Francois&display=swap"
        rel="stylesheet">
</head>


<body>
    <!-------- Navbar --------->
    <?php include 'header.php';?>

    <!-- Top image -------------------------------->
    <div class="top-image" id="imageSlider">
        <div class="slider-images">
            <img src="./contents/coverphoto1.jpg" alt="Slider Image 1" class="slider-img active" loading="lazy">
            <img src="./contents/coverphoto2.jpg" alt="Slider Image 2" class="slider-img" loading="lazy">
            <img src="./contents/coverphoto3.jpg" alt="Slider Image 3" class="slider-img" loading="lazy">
            <img src="./contents/coverphoto4.jpg" alt="Slider Image 4" class="slider-img" loading="lazy">
        </div>
    </div>

    <!-- top text  -------------------------------->
    <div class="top-text-area">

        <h1>92% Success Rate with Neutralize Naturals over 35000+ Happy Customers</h1>

        <p class="t1">We offer a curated range of skincare products, developed with renowned Ayurvedic experts,
            sepcifically
            formulated to address chronic skin conditions like proriasis. This unique blend nourishes your skin both
            internally and externaly, helping in complete oreversal fo Proriasis and other skin problems.
        </p>
        <div class="explore-btn-area">
            <a href="./shop.php" class="explore-btn">
                <p>EXPLORE</p>
                <i>→</i>
            </a>
        </div>
    </div>

    <!-- Product Section ---------------------------->





    <?php
include('connection.php');



// Get the selected category from the request (default to 'ALL' if no category is selected)
$category = isset($_GET['category']) ? $_GET['category'] : 'ALL';

// Query to get products based on category
if ($category == 'ALL') {
    $sql = "SELECT * FROM products";
} else {
    $sql = "SELECT * FROM products WHERE category = '$category'";
}

$result = $con->query($sql);

// Fetch all products into an array
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<div class="products-section">
    <div class="products-section-title-bar">
        <h2 class="featured-products">FEATURED PRODUCTS</h2>
    </div>
    
    <div class="secondary-navbar">
        <div class="navbar-row green-row">
            <div class="category-buttons">
                <button class="category-btn <?php echo ($category == 'ALL') ? 'active' : ''; ?>"><a href="?category=ALL">ALL</a></button>
                <button class="category-btn <?php echo ($category == 'BODY') ? 'active' : ''; ?>"><a href="?category=BODY">BODY</a></button>
                <button class="category-btn <?php echo ($category == 'SKIN') ? 'active' : ''; ?>"><a href="?category=SKIN">SKIN</a></button>
                <button class="category-btn <?php echo ($category == 'FACE') ? 'active' : ''; ?>"><a href="?category=FACE">FACE</a></button>
                <button class="category-btn <?php echo ($category == 'HAIR') ? 'active' : ''; ?>"><a href="?category=HAIR">HAIR</a></button>
                <button class="category-btn <?php echo ($category == 'BATH') ? 'active' : ''; ?>"><a href="?category=BATH">BATH</a></button>
            </div>
        </div>
    </div>

<div class="products-scroll-container">
    <?php
    if ($category == 'ALL') {
        $left_products = [];
        $right_products = [];

        for ($i = 0; $i < count($products); $i++) {
            if ($i % 2 == 0) {
                $left_products[] = $products[$i];
            } else {
                $right_products[] = $products[$i];
            }
        }
        ?>
        <div class="products-row products-row-left">
            <?php
            foreach ($left_products as $row) {
                echo '
                    <div class="product-card">
                        <div class="product-image">
                            <img src="contents/products/' . $row['image1'] . '" loading="lazy" alt="' . $row['name'] . '" class="product-img">
                            <div class="product-overlay">
                                <a href="product-view.php?id=' . $row['id'] . '" class="quick-view-btn">Quick View</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">' . $row['name'] . '</h3>
                            <p class="product-price">₹' . $row['price'] . '</p>
                            <button class="add-to-cart-btn" onclick="addToCart(\'' . $row['id'] . '\', \'' . addslashes($row['name']) . '\', \'' . $row['price'] . '\', \'' . $row['image1'] . '\')">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>';
            }
            ?>
        </div>

        <div class="products-row products-row-right">
            <?php
            foreach ($right_products as $row) {
                echo '
                    <div class="product-card">
                        <div class="product-image">
                            <img src="contents/products/' . $row['image1'] . '" loading="lazy" alt="' . $row['name'] . '" class="product-img">
                            <div class="product-overlay">
                                <a href="product-view.php?id=' . $row['id'] . '" class="quick-view-btn">Quick View</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">' . $row['name'] . '</h3>
                            <p class="product-price">₹' . $row['price'] . '</p>
                            <button class="add-to-cart-btn" onclick="addToCart(\'' . $row['id'] . '\', \'' . addslashes($row['name']) . '\', \'' . $row['price'] . '\', \'' . $row['image1'] . '\')">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>';
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <div class="products-row">
            <?php
            foreach ($products as $row) {
                echo '
                    <div class="product-card">
                        <div class="product-image">
                            <img src="contents/products/' . $row['image1'] . '" loading="lazy" alt="' . $row['name'] . '" class="product-img">
                            <div class="product-overlay">
                                <a href="product-view.php?id=' . $row['id'] . '" class="quick-view-btn">Quick View</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">' . $row['name'] . '</h3>
                            <p class="product-price">₹' . $row['price'] . '</p>
                            <button class="add-to-cart-btn" onclick="addToCart(\'' . $row['id'] . '\', \'' . addslashes($row['name']) . '\', \'' . $row['price'] . '\', \'' . $row['image1'] . '\')">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>';
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>

</div>

<?php
$con->close();
?>

<style type="">
    .quick-view-btn {
    background: none;        /* No background */
    border: none;            /* No border */
    color: white;          /* Blue text color */
    text-decoration: none;   /* Remove underline */
    font-size: 1rem;         /* Adjust font size */
    font-weight: normal;     /* Normal font weight */
    cursor: pointer;         /* Pointer cursor for interactivity */
}

.quick-view-btn:hover {
    color: black;          /* Darker color on hover */
    text-decoration: underline; /* Optional underline on hover */
}

</style>

    <!-- features section ------------------------->

    <h1 class="features-title">Treat yourself without steroids and antibiotics</h1>
    <p class="features-title-p">Making these 3 little changes to your everyday routine will solve vour skin problem very
        easily.</p>

    <div class="features-section">
        <div class="feature-box">
            <img src="./contents/features/dietplan.webp" loading="lazy" alt="feature1" class="feature-img">
            <h3>DIET PLAN</h3>
            <p>
                A comprehensive naturopathic diet plan is intended to treat people with skin problems.
            </p>
        </div>

        <div class="feature-box">
            <img src="./contents/features/products.webp" loading="lazy" alt="feature2" class="feature-img">
            <h3>PRODUCTS</h3>
            <p>
                Use natural Handmade skin care products.
            </p>
        </div>

        <div class="feature-box">
            <img src="./contents/features/wellness.webp" loading="lazy" alt="feature3" class="feature-img">
            <h3>WELLNESS</h3>
            <p>
                Encourage healthy lifestyle changes through exercise, yoga,
                and meditation.
            </p>
        </div>
    </div>
    <!--  Autoimmune Disorders -->
    <!-- <div class="autoimmune-disorders-title-bar">
        <div class="autoimmune-disorders">Autoimmune Disorders has Multiple Root Causes</div>
    </div>

    <div class="autoimmune-disorders-top-image">

    </div> -->

    <!-- Testimonials Section -->


   
<?php include('connection.php');

// Fetch testimonials from the database
// $sql = "SELECT * FROM testimonials ORDER BY date DESC";  // You can adjust the order as needed
$sql = "SELECT * FROM testimonials";  // You can adjust the order as needed

$result = $con->query($sql);

// Initialize an array to store testimonials
$testimonials = [];

if ($result->num_rows > 0) {
    // Fetch testimonials data
    while($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
} else {
    echo "No testimonials found.";
}

// Close the connection

?>

<style>
    
    .testimonial-card {
        width: 300px; /* Fixed width for consistency */
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .testimonial-text {
        font-size: 1rem;
        margin: 15px 0;
        word-wrap: break-word; /* Break long words */
        overflow-wrap: break-word; /* Compatibility for modern browsers */
        text-align: justify; /* Optional: Align the text neatly */
        max-width: 100%; /* Prevent text from overflowing horizontally */
    }

   /**/
</style>


<section class="testimonials-section">
    <h2>What Our Customers Say</h2>
    <div class="testimonials-container">
        <?php
        // Fetch testimonials from the database
        $result = mysqli_query($con, "SELECT imgSrc, name, date, message, rating FROM testimonials");

        while ($testimonial = mysqli_fetch_assoc($result)):
            $imgSrc = "contents/products/" . $testimonial['imgSrc']; // Assuming the image is stored in this folder
            $name = htmlspecialchars($testimonial['name']);
            $date = htmlspecialchars($testimonial['date']);
            $message = nl2br(htmlspecialchars($testimonial['message'])); // Format multiline text
            $rating = (int) $testimonial['rating']; // Numeric rating (1-5)
        ?>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="<?php echo $imgSrc; ?>" alt="<?php echo $name; ?>" class="user-image">
                    <div class="testimonial-info">
                        <h3><?php echo $name; ?></h3>
                        <span class="testimonial-date"><?php echo date('d F, Y', strtotime($date)); ?></span>
                    </div>
                </div>
                <p class="testimonial-text"><?php echo '"' . $message . '"'; ?></p>
                <div class="testimonial-rating">
                    <?php
                    // Display the rating stars
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<span>&#9733;</span>'; // Filled star (★)
                        } else {
                            echo '<span>&#9734;</span>'; // Empty star (☆)
                        }
                    }
                    ?>
                </div>

            </div>

        <?php endwhile; ?>

    </div>
</section>

<div class="feedback-btn-area" style="display: flex; justify-content: center; align-items: center; margin: 20px 0;">
    <a href="feedback.php" class="feedback-btn" style="text-decoration: none; background-color: black; border-color: black; color: gold; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
        <p style="margin: 0;">GIVE A FEEDBACK</p>
    </a>
</div>


<?php 
$con->close();
?>



    <!-- <section class="testimonials-section">
        <h2>What Our Customers Say</h2>
        <div class="testimonials-container">

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Priya Sharma">
                    <div class="testimonial-info">
                        <h3>Priya Sharma</h3>
                        <span class="testimonial-date">15 June, 2023</span>
                    </div>
                </div>
                <p>"Namaste! I've been struggling with psoriasis for years, and Neutralise Naturals has been a true blessing. Their wheatgrass powder and Ayurvedic skincare products have made such a difference. My skin feels so much better now, and I'm finally confident again. Thank you, Neutralise Naturals!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Rajesh Patel">
                    <div class="testimonial-info">
                        <h3>Rajesh Patel</h3>
                        <span class="testimonial-date">3 July, 2023</span>
                    </div>
                </div>
                <p>"Being someone with very sensitive skin, I was scared to try new products. But Neutralise Naturals' gentle and natural approach has done wonders for me. My skin is much clearer now!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Anita Desai">
                    <div class="testimonial-info">
                        <h3>Anita Desai</h3>
                        <span class="testimonial-date">20 August, 2023</span>
                    </div>
                </div>
                <p>"The holistic approach of Neutralise Naturals has totally transformed my skin health. Their diet tips, wellness advice, and amazing products have given me the perfect tools to manage my psoriasis effectively. I'm so grateful for this Ayurvedic miracle! It's like having a personal skin guru. Highly recommended for anyone struggling with skin issues."</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Vikram Singh">
                    <div class="testimonial-info">
                        <h3>Vikram Singh</h3>
                        <span class="testimonial-date">5 September, 2023</span>
                    </div>
                </div>
                <p>"I was very doubtful at first, but after using Neutralise Naturals for 3 months, I'm a true believer now. My psoriasis patches have reduced so much, and my skin feels so much more comfortable. Dhanyavaad, Neutralise Naturals!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Meera Reddy">
                    <div class="testimonial-info">
                        <h3>Meera Reddy</h3>
                        <span class="testimonial-date">12 October, 2023</span>
                    </div>
                </div>
                <p>"The Ayurvedic-inspired products from Neutralise Naturals match perfectly with my belief in natural healing. Not only has my skin improved, but I'm feeling more balanced overall. It's like a spa day for my skin every day!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Arjun Mehta">
                    <div class="testimonial-info">
                        <h3>Arjun Mehta</h3>
                        <span class="testimonial-date">8 November, 2023</span>
                    </div>
                </div>
                <p>"After trying so many different treatments over the years, Neutralise Naturals has finally given me hope. Their products and lifestyle advice have made such a big difference in my skin's health and appearance. I'm feeling so much better now!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Kavita Gupta">
                    <div class="testimonial-info">
                        <h3>Kavita Gupta</h3>
                        <span class="testimonial-date">17 December, 2023</span>
                    </div>
                </div>
                <p>"As a busy mom, I needed something effective yet easy to use. Neutralise Naturals fits perfectly into my routine. My skin has never looked better, and I love that it's all-natural. It's a game-changer!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Sanjay Kapoor">
                    <div class="testimonial-info">
                        <h3>Sanjay Kapoor</h3>
                        <span class="testimonial-date">2 January, 2024</span>
                    </div>
                </div>
                <p>"I've battled with psoriasis for decades, trying everything under the sun. Neutralise Naturals is the first product that's given me lasting relief. The combination of their supplements and topical treatments is truly powerful. My skin hasn't been this clear since I was a young man. It's nothing short of miraculous!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Lakshmi Nair">
                    <div class="testimonial-info">
                        <h3>Lakshmi Nair</h3>
                        <span class="testimonial-date">20 February, 2024</span>
                    </div>
                </div>
                <p>"Neutralise Naturals has been a blessing. The improvement in my skin is remarkable. Highly recommend!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="/contents/testimonials/users.png" alt="Rahul Verma">
                    <div class="testimonial-info">
                        <h3>Rahul Verma</h3>
                        <span class="testimonial-date">5 March, 2024</span>
                    </div>
                </div>
                <p>"I was skeptical about trying yet another skin product, but Neutralise Naturals surprised me. The natural ingredients really do make a difference. My psoriasis flare-ups have reduced significantly, and my skin feels soothed and nourished. It's like my skin can finally breathe again. Thank you for bringing Ayurvedic wisdom to modern skincare!"</p>
                <div class="testimonial-rating">★★★★★</div>
            </div>

        </div>
    </section>
 -->    <!-- End of Testimonials Section -->



    

    <!-- features section ------------------------->
    <h1 class="features-title">Why Choose Us</h1>

    <div class="features-section">
        <div class="feature-box">
            <img src="./contents/features/trophy.webp" loading="lazy" alt="feature1" class="feature-img">
            <h3>CURATED PRODUCTS</h3>
            <p>Handpicked natural ingredients like Wheat Grass, Coconut oil, specific herbs in making of wheatgrass
                products.</p>
        </div>

        <div class="feature-box">
            <img src="./contents/features/handmade.webp" loading="lazy" alt="feature2" class="feature-img">
            <h3>HANDMADE PRODUCTS</h3>
            <p>Crafted with passion in use of organic ingredients that supports for all skin types for natural
                results.</p>
        </div>

        <div class="feature-box">
            <img src="./contents/features/natural.webp" loading="lazy" alt="feature3" class="feature-img">
            <h3>100%NATURAL PRODUCTS</h3>
            <p>India's first Products made of Hydroponic Wheatgrass Products with 100% pest-free hygienic growing
                system.</p>
        </div>

        <div class="feature-box">
            <img src="./contents/features/shipping.webp" loading="lazy" alt="feature4" class="feature-img">
            <h3>SHIPPING</h3>
            <p>To reach our customers at there door step. By serving at Pan India level.</p>
        </div>
    </div>


    <!-- Youtube video and paragrphs over here -->
    <!-- Psoriasis Reversal Section -->
    <div class="psoriasis-container">
        <h2 class="psoriasis-main-title">Neutralise Naturals: Nature's Cure for Chronic Skin Conditions</h2>

        <!-- Left Section with YouTube Video -->
        <div class="psoriasis-left">
            <h3 class="psoriasis-subtitle">Customer Testimonial:</h3>
            <iframe class="psoriasis-video" width="560" height="315"
                src="https://www.youtube.com/embed/zcZoJl4h7mU?si=Oh0j0YV1rxJEGsVX" title="YouTube video player"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
            encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
        </div>

        <!-- Right Section with Text Content -->
        <div class="psoriasis-right">
            <p class="psoriasis-paragraph">
                Tired of psoriasis ruling your life? <br><strong>Neutralise Naturals</strong> is your secret weapon.
                Our Ayurvedic-inspired skincare, powered by pure, hydroponic wheatgrass, is a game-changer. Nourish
                your skin from within and out, and watch psoriasis fade away.
            </p>
            <p class="psoriasis-paragraph">
                Say goodbye to flakes, itchiness, and self-doubt. It's time to reclaim your skin—and your
                confidence.
            </p>
        </div>
    </div>

    <!-- Footer --------------------------------------->
<?php include('footer.php');?>

    <!-- Add to Cart Modal -->
    <div id="add-to-cart-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <p id="modal-message">Product added to cart!</p>
            <button class="modal-ok-btn" onclick="closeModal()">Okay</button>
            <button class="modal-go-to-cart-btn" onclick="goToCart()">Go to Cart</button>
        </div>
    </div>

    <script src="./js/cart.js"></script>
    <script src="./js/script.js" defer></script>
</body>

</html>