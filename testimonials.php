<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials - Neutralise Naturals</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/testimonials.css">

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Jacques+Francois&display=swap" rel="stylesheet">
</head>

<body>
    <!-------- Navbar --------->
    <?php include 'header.php';?>

    <?php include('connection.php');

// Fetch testimonials from the database
// $sql = "SELECT * FROM testimonials ORDER BY date DESC";  // You can adjust the order as needed
$sql = "SELECT * FROM `testimonials` LIMIT 6";  // You can adjust the order as needed

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

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h1 class="section-title">What Our Customers Say</h1>
            <div class="testimonial-grid">
                <?php
        // Fetch testimonials from the database
        $result = mysqli_query($con, "SELECT imgSrc, name, date, message, rating FROM testimonials LIMIT 6");

        while ($testimonial = mysqli_fetch_assoc($result)):
            $imgSrc = "contents/products/" . $testimonial['imgSrc']; // Assuming the image is stored in this folder
            $name = htmlspecialchars($testimonial['name']);
            $date = htmlspecialchars($testimonial['date']);
            $message = nl2br(htmlspecialchars($testimonial['message'])); // Format multiline text
            $rating = (int) $testimonial['rating']; // Numeric rating (1-5)
        ?>
                <div class="testimonial-card" data-aos="fade-up">
                    <img src="<?php echo $imgSrc; ?>" alt="<?php echo $name; ?>" class="user-image">
                    <h3><?php echo $name; ?></h3>
                    <p class="user-location">New Delhi, India</p>
                    <div class="rating" style="font-size: 40px;">
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
                    <p class="testimonial-text"><?php echo '"' . $message . '"'; ?></p>
                </div>
            <?php endwhile; ?>
              
            </div>
        </div>
    </section>

    <!-- Video Testimonials Section -->
    <section class="video-testimonials">
        <div class="container">
            <h2 class="section-title">Video Testimonials</h2>
            <div class="video-grid">
                <div class="video-card" data-aos="zoom-in">
                    <iframe src="https://www.youtube.com/embed/iBvEMoXfSWk" frameborder="0" allowfullscreen></iframe>
                    <h3>23 Year Psoriasis Reversed in 8 months</h3>
                </div>
                <div class="video-card" data-aos="zoom-in" data-aos-delay="100">
                    <iframe src="https://www.youtube.com/embed/q6zfp4_2Omo" frameborder="0" allowfullscreen></iframe>
                    <h3>Full Body Psoriasis Reversed in 3 months</h3>
                </div>
                <div class="video-card" data-aos="zoom-in" data-aos-delay="200">
                    <iframe src="https://www.youtube.com/embed/QZmNVAUA22s" frameborder="0" allowfullscreen></iframe>
                    <h3>Psoriasis Complete Reversal Live Webinar Testimony</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
   <?php include('footer.php');?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 200
        });
    </script>
    <script src="./js/script.js" defer></script>
</body>

</html>