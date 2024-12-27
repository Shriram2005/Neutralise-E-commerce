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

    <div class="bento-grid">
    <?php
        foreach ($products as $index => $row) {
            $size_class = '';
            // Assign different sizes to create visual interest
            if ($index % 7 === 0) {
                $size_class = 'bento-large'; // Large card every 7th item
            } elseif ($index % 5 === 0) {
                $size_class = 'bento-wide'; // Wide card every 5th item
            } elseif ($index % 3 === 0) {
                $size_class = 'bento-tall'; // Tall card every 3rd item
            }
            
                echo '
            <div class="bento-card ' . $size_class . '">
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
        </div>

            <?php
$con->close();
?>

<style>
.bento-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.bento-card {
    background: var(--white-bg-color);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.bento-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.bento-large {
    grid-column: span 2;
    grid-row: span 2;
}

.bento-wide {
    grid-column: span 2;
}

.bento-tall {
    grid-row: span 2;
}

.product-image {
    position: relative;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    overflow: hidden;
}

.product-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.bento-card:hover .product-img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bento-card:hover .product-overlay {
    opacity: 1;
}

.quick-view-btn {
    background: var(--white-bg-color);
    color: var(--text-color);
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-family: var(--font-body);
    font-weight: 500;
    transition: all 0.3s ease;
}

.quick-view-btn:hover {
    background: var(--green-bg-color);
    color: white;
}

.product-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: var(--white-bg-color);
}

.product-title {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    margin-bottom: 8px;
    color: var(--text-color);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-family: var(--font-body);
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--green-bg-color);
    margin: 10px 0;
}

.add-to-cart-btn {
    background: var(--green-bg-color);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    font-family: var(--font-body);
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.add-to-cart-btn:hover {
    background: var(--hover-color);
}

@media (max-width: 1200px) {
    .bento-large, .bento-wide {
        grid-column: span 1;
    }
    .bento-tall {
        grid-row: span 1;
    }
}

@media (max-width: 768px) {
    .bento-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 15px;
    }
    
    .product-info {
        padding: 15px;
    }
}

@media (max-width: 480px) {
    .bento-grid {
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 10px;
    }
    
    .bento-card {
        min-height: 350px;
    }
    
    .product-title {
        font-size: 1rem;
    }
    
    .product-price {
        font-size: 1.1rem;
    }
    
    .add-to-cart-btn {
        padding: 10px;
    }
}
</style>

    <!-- features section ------------------------->

    <section class="treat-yourself">
        <div class="section-header">
            <h1 class="section-title">Treat Yourself Naturally</h1>
            <p class="section-subtitle">Transform your skin health with these three essential steps</p>
            <div class="title-accent"></div>
        </div>

        <div class="treatment-steps">
            <div class="step-card" data-aos="fade-right" data-aos-delay="100">
                <div class="step-icon-wrapper">
                    <img src="./contents/features/dietplan.webp" loading="lazy" alt="Diet Plan" class="step-icon">
                    <div class="step-number">1</div>
                </div>
                <div class="step-content">
            <h3>DIET PLAN</h3>
                    <p>A comprehensive naturopathic diet plan is intended to treat people with skin problems.</p>
                    <div class="step-hover">
                        <ul class="step-details">
                            <li>Personalized nutrition guidance</li>
                            <li>Ayurvedic dietary principles</li>
                            <li>Skin-friendly food choices</li>
                        </ul>
                    </div>
                </div>
        </div>

            <div class="step-card" data-aos="fade-up" data-aos-delay="200">
                <div class="step-icon-wrapper">
                    <img src="./contents/features/products.webp" loading="lazy" alt="Natural Products" class="step-icon">
                    <div class="step-number">2</div>
                </div>
                <div class="step-content">
                    <h3>NATURAL PRODUCTS</h3>
                    <p>Use natural Handmade skin care products crafted with pure ingredients.</p>
                    <div class="step-hover">
                        <ul class="step-details">
                            <li>Chemical-free formulations</li>
                            <li>Traditional Ayurvedic herbs</li>
                            <li>Gentle on sensitive skin</li>
                        </ul>
                    </div>
                </div>
        </div>

            <div class="step-card" data-aos="fade-left" data-aos-delay="300">
                <div class="step-icon-wrapper">
                    <img src="./contents/features/wellness.webp" loading="lazy" alt="Wellness" class="step-icon">
                    <div class="step-number">3</div>
        </div>
                <div class="step-content">
                    <h3>WELLNESS ROUTINE</h3>
                    <p>Encourage healthy lifestyle changes through exercise, yoga, and meditation.</p>
                    <div class="step-hover">
                        <ul class="step-details">
                            <li>Stress reduction techniques</li>
                            <li>Holistic healing approach</li>
                            <li>Mind-body balance</li>
                        </ul>
    </div>
    </div>
            </div>
        </div>
    </section>

<style>
.treat-yourself {
    padding: 80px 20px;
    background: linear-gradient(135deg, #fff4c4 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
}

.section-title {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 4vw, 2.5rem);
    color: var(--text-color);
    margin-bottom: 15px;
}

.section-subtitle {
    font-family: var(--font-body);
    font-size: clamp(1rem, 2vw, 1.2rem);
    color: #666;
    margin-bottom: 20px;
}

.title-accent {
    width: 80px;
    height: 3px;
    background: var(--green-bg-color);
    margin: 0 auto;
    position: relative;
}

.treatment-steps {
    display: flex;
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    flex-wrap: wrap;
    justify-content: center;
}

.step-card {
    flex: 1;
    min-width: 300px;
    max-width: 400px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 30px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.step-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--green-bg-color), var(--hover-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.step-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.step-card:hover::before {
    opacity: 1;
}

.step-icon-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 25px;
}

.step-icon {
    width: 100%;
    height: 100%;
    object-fit: contain;
    position: relative;
    z-index: 2;
    transition: transform 0.3s ease;
}

.step-number {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 40px;
    height: 40px;
    background: var(--green-bg-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-heading);
    font-size: 1.2rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.step-content {
    text-align: center;
}

.step-content h3 {
    font-family: var(--font-heading);
    font-size: 1.3rem;
    color: var(--text-color);
    margin-bottom: 15px;
    position: relative;
}

.step-content p {
    font-family: var(--font-body);
    font-size: 1rem;
    line-height: 1.6;
    color: #666;
    margin-bottom: 20px;
}

.step-hover {
    height: 0;
    overflow: hidden;
    transition: height 0.3s ease;
}

.step-card:hover .step-hover {
    height: 100px;
}

.step-details {
    list-style: none;
    padding: 0;
    margin: 0;
}

.step-details li {
    font-family: var(--font-body);
    font-size: 0.9rem;
    color: #666;
    margin: 8px 0;
    position: relative;
    padding-left: 20px;
}

.step-details li::before {
    content: '•';
    color: var(--green-bg-color);
    position: absolute;
    left: 0;
    font-size: 1.2rem;
}

@media (max-width: 1024px) {
    .treatment-steps {
        gap: 20px;
    }

    .step-card {
        min-width: calc(50% - 20px);
    }
}

@media (max-width: 768px) {
    .treat-yourself {
        padding: 60px 15px;
    }

    .step-card {
        min-width: 100%;
    }

    .step-icon-wrapper {
        width: 100px;
        height: 100px;
    }

    .step-number {
        width: 35px;
        height: 35px;
        font-size: 1.1rem;
    }
}
</style>

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
    <h2 class="testimonials-title">What Our Customers Say</h2>
    <div class="testimonials-container">
        <?php
        // Fetch testimonials from the database, limit to 3 most recent ones
        $result = mysqli_query($con, "SELECT imgSrc, name, date, message, rating FROM testimonials ORDER BY date DESC LIMIT 3");

        $index = 0;
        while ($testimonial = mysqli_fetch_assoc($result)):
            $imgSrc = "contents/products/" . $testimonial['imgSrc'];
            $name = htmlspecialchars($testimonial['name']);
            $date = htmlspecialchars($testimonial['date']);
            $message = nl2br(htmlspecialchars($testimonial['message']));
            $rating = (int) $testimonial['rating'];
            
            // Determine card size and position classes
            $sizeClass = '';
            $positionClass = '';
            
            if ($index === 0) {
                $sizeClass = 'testimonial-large';
                $positionClass = 'position-center';
            } elseif ($index === 1) {
                $sizeClass = 'testimonial-wide';
                $positionClass = 'position-right';
            } else {
                $sizeClass = 'testimonial-tall';
                $positionClass = 'position-left';
            }
            
            $index++;
        ?>
            <div class="testimonial-card <?php echo $sizeClass . ' ' . $positionClass; ?>">
                <div class="testimonial-header">
                    <div class="testimonial-image-wrapper">
                    <img src="<?php echo $imgSrc; ?>" alt="<?php echo $name; ?>" class="user-image">
                <div class="testimonial-rating">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                                    echo '<span class="star filled">★</span>';
                        } else {
                                    echo '<span class="star">☆</span>';
                        }
                    }
                    ?>
                </div>
            </div>
                    <div class="testimonial-info">
                        <h3><?php echo $name; ?></h3>
                        <span class="testimonial-date"><?php echo date('d F, Y', strtotime($date)); ?></span>
                    </div>
                </div>
                <div class="testimonial-content">
                    <p class="testimonial-text"><?php echo '"' . $message . '"'; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="testimonial-actions">
        <a href="testimonials.php" class="view-all-btn">
            <span class="view-all-text">VIEW ALL REVIEWS</span>
            <span class="view-all-icon">→</span>
        </a>
        <a href="feedback.php" class="feedback-btn">
            <span class="feedback-text">SHARE YOUR STORY</span>
            <span class="feedback-icon">✍️</span>
    </a>
</div>
</section>

<style>
.testimonials-section {
    padding: clamp(30px, 5vw, 60px) clamp(15px, 3vw, 30px);
    background: linear-gradient(135deg, var(--main-bg-color) 0%, #fff 100%);
    overflow: hidden;
    position: relative;
    width: 100%;
    margin: 0 auto;
}

.testimonials-title {
    text-align: center;
    font-family: var(--font-heading);
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    margin-bottom: clamp(30px, 5vw, 50px);
    color: var(--text-color);
    position: relative;
}

.testimonials-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: var(--green-bg-color);
}

.testimonials-container {
    display: grid;
    gap: 20px;
    width: 95%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.testimonial-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.testimonial-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.testimonial-image-wrapper {
    position: relative;
    flex-shrink: 0;
}

.user-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--green-bg-color);
}

.testimonial-rating {
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 2px 8px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    white-space: nowrap;
}

.testimonial-info {
    flex-grow: 1;
}

.testimonial-info h3 {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    margin: 0 0 5px 0;
    color: var(--text-color);
}

.testimonial-date {
    font-size: 0.9rem;
    color: #666;
}

.testimonial-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.testimonial-text {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-color);
    position: relative;
    padding-left: 24px;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.testimonial-text::before {
    content: '"';
    position: absolute;
    left: 0;
    top: -10px;
    font-size: 2.5rem;
    color: var(--green-bg-color);
    opacity: 0.3;
}

/* Large screens */
@media (min-width: 1024px) {
    .testimonials-container {
        grid-template-columns: repeat(2, 1fr);
        grid-template-areas: 
            "main side1"
            "main side2";
    }

    .testimonial-card:nth-child(1) {
        grid-area: main;
    }

    .testimonial-card:nth-child(2) {
        grid-area: side1;
    }

    .testimonial-card:nth-child(3) {
        grid-area: side2;
    }
}

/* Medium screens */
@media (min-width: 768px) and (max-width: 1023px) {
    .testimonials-container {
        grid-template-columns: repeat(2, 1fr);
    }

    .testimonial-card:nth-child(1) {
        grid-column: span 2;
    }
}

/* Small screens */
@media (max-width: 767px) {
    .testimonials-container {
        grid-template-columns: 1fr;
        width: 90%;
        padding: 10px;
    }

    .testimonial-card {
        padding: 20px;
        margin: 0 auto;
        max-width: 400px;
    }
}

.testimonial-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px auto;
    padding: 0 20px;
    max-width: 600px;
}

.view-all-btn, .feedback-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-family: var(--font-body);
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    white-space: nowrap;
    min-width: 180px;
    max-width: 250px;
}

.view-all-btn {
    background: var(--green-bg-color);
    color: white;
}

.feedback-btn {
    background: var(--text-color);
    color: var(--main-bg-color);
}

.view-all-btn:hover, .feedback-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.view-all-text, .feedback-text {
    font-size: 1rem;
    letter-spacing: 1px;
}

.view-all-icon, .feedback-icon {
    font-size: 1.2rem;
}

@media (max-width: 640px) {
    .testimonial-actions {
        flex-direction: column;
        align-items: center;
        gap: 15px;
        width: 90%;
    }

    .view-all-btn, .feedback-btn {
        width: 100%;
        max-width: 300px;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

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
    <section class="why-choose-us">
        <div class="section-header">
            <h1 class="section-title">Why Choose Us</h1>
            <div class="title-accent"></div>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon-wrapper">
                    <img src="./contents/features/trophy.webp" loading="lazy" alt="Curated Products" class="feature-icon">
                    <div class="icon-bg"></div>
                </div>
                <div class="feature-content">
            <h3>CURATED PRODUCTS</h3>
                    <p>Handpicked natural ingredients like Wheat Grass, Coconut oil, specific herbs in making of wheatgrass products.</p>
                </div>
                <div class="hover-effect"></div>
        </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon-wrapper">
                    <img src="./contents/features/handmade.webp" loading="lazy" alt="Handmade Products" class="feature-icon">
                    <div class="icon-bg"></div>
                </div>
                <div class="feature-content">
            <h3>HANDMADE PRODUCTS</h3>
                    <p>Crafted with passion in use of organic ingredients that supports for all skin types for natural results.</p>
                </div>
                <div class="hover-effect"></div>
        </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon-wrapper">
                    <img src="./contents/features/natural.webp" loading="lazy" alt="Natural Products" class="feature-icon">
                    <div class="icon-bg"></div>
                </div>
                <div class="feature-content">
                    <h3>100% NATURAL PRODUCTS</h3>
                    <p>India's first Products made of Hydroponic Wheatgrass Products with 100% pest-free hygienic growing system.</p>
                </div>
                <div class="hover-effect"></div>
        </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon-wrapper">
                    <img src="./contents/features/shipping.webp" loading="lazy" alt="Shipping" class="feature-icon">
                    <div class="icon-bg"></div>
        </div>
                <div class="feature-content">
                    <h3>PAN INDIA SHIPPING</h3>
                    <p>To reach our customers at their doorstep. Serving across all corners of India.</p>
    </div>
                <div class="hover-effect"></div>
            </div>
        </div>
    </section>

    <style>
    .why-choose-us {
        padding: 80px 20px;
        background: linear-gradient(135deg, var(--main-bg-color) 60%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }

    .section-title {
        font-family: var(--font-heading);
        font-size: clamp(2rem, 4vw, 2.5rem);
        color: var(--text-color);
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .title-accent {
        width: 80px;
        height: 3px;
        background: var(--green-bg-color);
        margin: 0 auto;
        position: relative;
    }

    .title-accent::before,
    .title-accent::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 3px;
        background: var(--green-bg-color);
        top: -6px;
    }

    .title-accent::before {
        left: 15px;
    }

    .title-accent::after {
        right: 15px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin-bottom: 25px;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        object-fit: contain;
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .icon-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--green-bg-color) 0%, var(--hover-color) 100%);
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.3s ease;
    }

    .feature-card:hover .icon-bg {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0.2;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
    }

    .feature-content {
        position: relative;
        z-index: 2;
    }

    .feature-content h3 {
        font-family: var(--font-heading);
        font-size: 1.3rem;
        color: var(--text-color);
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .feature-content h3::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: var(--green-bg-color);
        transition: width 0.3s ease;
    }

    .feature-card:hover h3::after {
        width: 100%;
    }

    .feature-content p {
        font-family: var(--font-body);
        font-size: 1rem;
        line-height: 1.6;
        color: #666;
        margin: 0;
    }

    .hover-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(171, 190, 71, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .feature-card:hover .hover-effect {
        opacity: 1;
    }

    @media (max-width: 768px) {
        .why-choose-us {
            padding: 60px 15px;
        }

        .features-grid {
            gap: 20px;
            padding: 10px;
        }

        .feature-card {
            padding: 25px;
        }

        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
        }

        .feature-content h3 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .features-grid {
            grid-template-columns: 1fr;
        }

        .feature-card {
            max-width: 320px;
            margin: 0 auto;
        }
    }
    </style>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

    <!-- Youtube video and paragrphs over here -->
    <!-- Psoriasis Reversal Section -->
    <section class="psoriasis-section">
    <div class="psoriasis-container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Nature's Solution for Healthy Skin</h2>
                <div class="title-accent"></div>
            </div>

            <div class="content-wrapper">
        <!-- Left Section with YouTube Video -->
                <div class="video-section" data-aos="fade-right">
                    <div class="video-wrapper">
                        <div class="video-badge">Featured Story</div>
                        <iframe class="video-frame" 
                            src="https://www.youtube.com/embed/zcZoJl4h7mU?si=Oh0j0YV1rxJEGsVX" 
                            title="Customer Success Story" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
            </iframe>
                    </div>
        </div>

        <!-- Right Section with Text Content -->
                <div class="content-section" data-aos="fade-left">
                    <div class="content-card">
                        <div class="highlight-box">
                            <span class="highlight-icon">✨</span>
                            <h3>Transform Your Skin Journey</h3>
                        </div>
                        
                        <div class="content-text">
                            <p class="main-message">
                                Tired of psoriasis ruling your life? <strong>Neutralise Naturals</strong> is your secret weapon.
                            </p>
                            
                            <div class="benefits-list">
                                <div class="benefit-item">
                                    <span class="check-icon">✓</span>
                                    <p>Ayurvedic-inspired skincare solutions</p>
                                </div>
                                <div class="benefit-item">
                                    <span class="check-icon">✓</span>
                                    <p>Pure, hydroponic wheatgrass formulation</p>
                                </div>
                                <div class="benefit-item">
                                    <span class="check-icon">✓</span>
                                    <p>Nourishes skin from within</p>
                                </div>
                            </div>

                            <p class="empowering-message">
                                Say goodbye to flakes, itchiness, and self-doubt. It's time to reclaim your skin—and your confidence.
                            </p>

                            <a href="shop.php" class="cta-button">
                                <span>Start Your Healing Journey</span>
                                <span class="arrow">→</span>
                            </a>
        </div>
    </div>
                </div>
            </div>
        </div>
    </section>

<style>
.psoriasis-section {
    padding: 80px 20px;
    background: linear-gradient(135deg, var(--main-bg-color) 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.psoriasis-container {
    max-width: 1400px;
    margin: 0 auto;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 4vw, 2.5rem);
    color: var(--text-color);
    margin-bottom: 15px;
}

.title-accent {
    width: 80px;
    height: 3px;
    background: var(--green-bg-color);
    margin: 0 auto;
    position: relative;
}

.content-wrapper {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    align-items: center;
}

.video-section {
    position: relative;
}

.video-wrapper {
    position: relative;
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.video-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--green-bg-color);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: bold;
    z-index: 2;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.video-frame {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 20px;
}

.content-section {
    padding: 20px;
}

.content-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.highlight-box {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.highlight-icon {
    font-size: 2rem;
}

.highlight-box h3 {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    color: var(--text-color);
    margin: 0;
}

.content-text {
    color: var(--text-color);
}

.main-message {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 25px;
}

.main-message strong {
    color: var(--green-bg-color);
}

.benefits-list {
    margin: 30px 0;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.check-icon {
    color: var(--green-bg-color);
    font-size: 1.2rem;
    font-weight: bold;
}

.benefit-item p {
    margin: 0;
    font-size: 1.1rem;
}

.empowering-message {
    font-size: 1.1rem;
    font-style: italic;
    margin: 25px 0;
    color: #666;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--green-bg-color);
    color: white;
    padding: 15px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.arrow {
    transition: transform 0.3s ease;
}

.cta-button:hover .arrow {
    transform: translateX(5px);
}

@media (max-width: 1024px) {
    .content-wrapper {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .video-section {
        order: 2;
    }

    .content-section {
        order: 1;
    }
}

@media (max-width: 768px) {
    .psoriasis-section {
        padding: 60px 15px;
    }

    .content-card {
        padding: 30px;
    }

    .highlight-box h3 {
        font-size: 1.3rem;
    }

    .main-message {
        font-size: 1.1rem;
    }

    .benefit-item p {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .content-card {
        padding: 20px;
    }

    .video-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    .cta-button {
        width: 100%;
        justify-content: center;
    }
}
</style>

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
</html>