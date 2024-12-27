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
<!-- Space for bento grid -->
<section class="Bento-Grid">
        <div
          class="container"
          style="
            display: flex;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-content: center;
          "
        >
          <div
            class="grid"
            style="
              display: grid;
              height: 0%;
              width: 80%;
              grid-template-columns: repeat(4, 1fr);
              grid-template-rows: repeat(4, 1fr);
              gap: 16px;
              padding: 8px;
              border-radius: 8px;
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                0 1px 2px rgba(0, 0, 0, 0.1);
            "
          >
            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 2;
                grid-row: span 4;
                background-color: rgb(255, 255, 255);
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0435.JPG"
                alt="product 1"
                style="height: 100%; width: 80%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>

            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 1;
                grid-row: span 4;
                background-color: lightGray;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0477.JPG"
                alt="product 2"
                style="height: 100%; width: 100%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>

            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 1;
                grid-row: span 4;
                background-color: lightGray;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0435.JPG"
                alt="product 1"
                style="height: 100%; width: 100%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>

            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 1;
                grid-row: span 4;
                background-color: lightGray;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0435.JPG"
                alt="product 1"
                style="height: 100%; width: 100%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>

            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 1;
                grid-row: span 4;
                background-color: lightGray;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0435.JPG"
                alt="product 1"
                style="height: 100%; width: 100%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>

            <div
              style="
                font-family: 'M PLUS 2 Variable', sans-serif;
                grid-column: span 2;
                grid-row: span 4;
                background-color: rgb(255, 255, 255);
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25),
                  0 1px 2px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
              "
            >
              <img
                src="./contents/Pd_Imgs/1Q1A0435.JPG"
                alt="product 1"
                style="height: 100%; width: 80%"
              />
              <div
                style="
                  position: absolute;
                  bottom: 10px;
                  left: 10px;
                  width: calc(100% - 20px);
                  background: linear-gradient(to bottom, #ffffff, #a2b139);
                  color: white;
                  padding: 5px;
                  border-radius: 5px;
                  overflow: hidden;
                "
              >
                <h4 style="margin: 0; color: #a2b139; font-weight: bold">
                  Product Title
                </h4>
                <p style="margin: 0; font-weight: bold">$Price</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End of bento grid -->
        
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
    <!-- Testimonials Section -->

    <h2 class="TestiHeadline">What Our Customers Say</h2>
    <section class="testimonials-section">
      <div class="container">
        <div class="card card-1">
          <div class="heading">
            <div class="img-wrapper">
              <div class="border"></div>
              <img
                src="https://raw.githubusercontent.com/khatri2002/testimonials-grid-section/refs/heads/main/images/image-daniel.jpg"
                alt="Daniel Clifford"
              />
            </div>
            <div class="text">
              <h1>Priya Sharma</h1>
              <h2>15 June, 2023</h2>
            </div>
          </div>
          <div class="main">
            <h3>★★★★★</h3>
          </div>
          <div class="desc">
            <p>
              "Namaste! I've been struggling with psoriasis for years, and
              Neutralise Naturals has been a true blessing. Their wheatgrass
              powder and Ayurvedic skincare products have made such a
              difference. My skin feels so much better now, and I'm finally
              confident again. Thank you, Neutralise Naturals!"
            </p>
          </div>
        </div>
        <div class="card card-2">
          <div class="heading">
            <div class="img-wrapper">
              <div class="border"></div>
              <img
                src="https://raw.githubusercontent.com/khatri2002/testimonials-grid-section/refs/heads/main/images/image-jonathan.jpg"
                alt="Jonathan Walters"
              />
            </div>
            <div class="text">
              <h1>Rajesh Patel</h1>
              <h2>3 July, 2023</h2>
            </div>
          </div>
          <div class="main">
            <h3>★★★★★</h3>
          </div>
          <div class="desc">
            <p>
              "Being someone with very sensitive skin, I was scared to try new
              products. But Neutralise Naturals' gentle and natural approach has
              done wonders for me. My skin is much clearer now!"
            </p>
          </div>
        </div>
        <div class="card card-3">
          <div class="heading">
            <div class="img-wrapper">
              <div class="border"></div>
              <img
                src="https://raw.githubusercontent.com/khatri2002/testimonials-grid-section/refs/heads/main/images/image-jeanette.jpg"
                alt="Jeanette Harmon"
              />
            </div>
            <div class="text">
              <h1>Anita Desai</h1>
              <h2>20 August, 2023</h2>
            </div>
          </div>
          <div class="main">
            <h3>★★★★★</h3>
          </div>
          <div class="desc">
            <p>
              " The holistic approach of Neutralise Naturals has totally
              transformed my skin health. Their diet tips, wellness advice, and
              amazing products have given me the perfect tools to manage my
              psoriasis effectively. I'm so grateful for this Ayurvedic miracle!
              It's like having a personal skin guru. Highly recommended for
              anyone struggling with skin issues."
            </p>
          </div>
        </div>
        <div class="card card-4">
          <div class="heading">
            <div class="img-wrapper">
              <div class="border"></div>
              <img
                src="https://raw.githubusercontent.com/khatri2002/testimonials-grid-section/refs/heads/main/images/image-patrick.jpg"
                alt="Patrick Abrams"
              />
            </div>
            <div class="text">
              <h1>Vikram Singh</h1>
              <h2>5 September, 2023</h2>
            </div>
          </div>
          <div class="main">
            <h3>★★★★★</h3>
          </div>
          <div class="desc">
            <p>
              I was very doubtful at first, but after using Neutralise Naturals
              for 3 months, I'm a true believer now. My psoriasis patches have
              reduced so much, and my skin feels so much more comfortable.
              Dhanyavaad, Neutralise Naturals!
            </p>
          </div>
        </div>
        <div class="card card-5">
          <div class="heading">
            <div class="img-wrapper">
              <div class="border"></div>
              <img
                src="https://raw.githubusercontent.com/khatri2002/testimonials-grid-section/refs/heads/main/images/image-kira.jpg"
                alt="Kira Whittle"
              />
            </div>
            <div class="text">
              <h1>Meera Reddy</h1>
              <h2>12 October, 2023</h2>
            </div>
          </div>
          <div class="main">
            <h3>★★★★★</h3>
          </div>
          <div class="desc">
            <p>
              "The Ayurvedic-inspired products from Neutralise Naturals match
              perfectly with my belief in natural healing. Not only has my skin
              improved, but I'm feeling more balanced overall. It's like a spa
              day for my skin every day!"
            </p>
          </div>
        </div>
      </div>
    </section>
    
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

    <section id="section-why-choose-us" class="full-width-flex-container">
  <div id="why-choose-us-container" class="content-max-width center-content">
    <div class="header-flex-container">
      <h1 id="why-choose-us-title" class="section-title text-purple">WHY CHOOSE US</h1>
      <div class="image-container">
        <img
          id="arrow-icon"
          src="./contents/aboutUs/image1.JPG"
          alt="Decorative Arrow"
          class="decorative-arrow-image"
        />
      </div>
    </div>
    

    <div id="stats-container" class="two-column-grid">
      <div class="stat-item text-center">
        <span class="stat-percentage text-purple-bold">100%</span>
        <p class="stat-description text-gray-light">NATURAL PRODUCTS.</p>
      </div>
      <div class="stat-item text-center">
        <!-- Changed icon to solid version -->
        <span class="stat-percentage text-purple-bold"><i class="fa-solid fa-headphones-simple"></i>
        </span>
        <p class="stat-description text-gray-light">Customer Support.</p>
      </div>
    </div>

    <div id="info-card-container" class="responsive-grid">
      <div class="info-card purple-card">
        <h2 class="card-title">CURATED PRODUCTS</h2>
        <p class="card-description">Handpicked natural ingredients like Wheat Grass, Coconut oil, specific herbs in making of wheatgrass products.</p>
      </div>
      <div class="info-card blue-card">
        <h2 class="card-title">HANDMADE PRODUCTS</h2>
        <p class="card-description">Crafted with passion in use of organic ingredients that supports for all skin types for natural results.</p>
      </div>
      <div class="info-card gray-card">
        <h2 class="card-title">SHIPPING</h2>
        <p class="card-description">To reach our customers at there door step. By serving at Pan India level.
        </p>
      </div>
    </div>
  </div>
</section>


     <!-- Youtube video and paragrphs over here -->
    <!-- Psoriasis Reversal Section -->
    <div class="psoriasis-container">
      <h2 class="psoriasis-main-title">
        Neutralise Naturals: Nature's Cure for Chronic Skin Conditions
      </h2>

      <!-- Left Section with YouTube Video -->
      <div class="psoriasis-left">
        <h3 class="psoriasis-subtitle">Customer Testimonial:</h3>
        <iframe
          class="psoriasis-video"
          width="560"
          height="315"
          src="https://www.youtube.com/embed/zcZoJl4h7mU?si=Oh0j0YV1rxJEGsVX"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; 
            encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        >
        </iframe>
      </div>

      <!-- Right Section with Text Content -->
      <div class="psoriasis-right">
        <p class="psoriasis-paragraph">
          Tired of psoriasis ruling your life? <br /><strong
            >Neutralise Naturals</strong
          >
          is your secret weapon. Our Ayurvedic-inspired skincare, powered by
          pure, hydroponic wheatgrass, is a game-changer. Nourish your skin from
          within and out, and watch psoriasis fade away.
        </p>
        <p class="psoriasis-paragraph">
          Say goodbye to flakes, itchiness, and self-doubt. It's time to reclaim
          your skin—and your confidence.
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