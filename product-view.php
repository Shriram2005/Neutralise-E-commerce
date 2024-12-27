<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login-Register.php"); // Redirect to login page if not logged in
    exit;
}

include('connection.php');

// If the product is added to the cart
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id']; // Logged-in user's ID

    // Check if the product is already in the cart for the logged-in user
    $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the product is not already in the cart, add it
    if ($result->num_rows == 0) {
        // Insert the product into the cart table
        $sql = "INSERT INTO cart (user_id, product_id) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    } else {
        // Optionally, you can return a message to the user that the item is already in the cart
        echo "Product already in your cart.";
    }
}



// Continue with adding to cart logic
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - Neutralise Naturals</title>
     <!-- <title><?php echo htmlspecialchars($product['name']); ?></title> -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/product-view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Jacques+Francois&display=swap"
        rel="stylesheet">
</head>

<body>
   <?php include 'header.php';?>



<?php
// Include database connection
include('connection.php');

// Get product ID from the URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 1; // Default to product ID 1

// Fetch product details from the database
$query = "SELECT * FROM products WHERE id = ? LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

// Parse size options, ingredients, and usage instructions
$ingredients = !empty($product['ingredients']) ? explode(',', $product['ingredients']) : [];
$usageInstructions = !empty($product['usage_instructions']) ? explode("\n", $product['usage_instructions']) : [];
$sizeOptions = json_decode($product['size_options'], true) ?: []; // Decoding JSON for size options
$basePrice = $product['price']; // Base price from the database
?>

<main class="product-view-container">
    <div class="product-breadcrumb">
        <a href="index.php">Home</a> / <a href="shop.php">Shop</a> / <span id="product-name"><?php echo htmlspecialchars($product['name']); ?></span>
    </div>

    <div class="product-showcase">
        <div class="product-gallery">
            <div class="gallery-main">
                <img id="main-product-image" src="contents/products/<?php echo htmlspecialchars($product['image1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <button class="zoom-btn"><i class="fas fa-search-plus"></i></button>
            </div>
            <div class="gallery-thumbnails">
                <?php
                // Display all available product images
                for ($i = 1; $i <= 3; $i++) {
                    $imageKey = 'image' . $i;
                    if (!empty($product[$imageKey])) {
                        echo "<img class='thumbnail' src='contents/products/" . htmlspecialchars($product[$imageKey]) . 
                             "' alt='Thumbnail' onclick='changeMainImage(this.src)'>";
                    }
                }
                ?>
            </div>
        </div>

        <div class="product-details">
            <h1 id="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="product-meta">
                <div class="product-rating">
                    <div class="stars">
                        <?php
                        $rating = isset($product['rating']) ? $product['rating'] : 0;
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5;
                        
                        for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                        if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                        $emptyStars = 5 - ceil($rating);
                        for ($i = 0; $i < $emptyStars; $i++) echo '<i class="far fa-star"></i>';
                        ?>
                    </div>
                    <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                    <a href="#reviews" class="review-count">(<?php echo isset($product['reviews_count']) ? $product['reviews_count'] : 0; ?> reviews)</a>
                </div>
                <span class="product-sku">SKU: <?php echo htmlspecialchars($product['sku'] ?: 'N/A'); ?></span>
            </div>
            <p id="product-price" class="price">₹<?php echo number_format($basePrice, 2); ?></p>
            <p id="product-short-description" class="product-short-description">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>
            <div class="product-options">
                <div class="option-group">
                    <label for="product-size">Size:</label>
                    <div class="size-options">
                        <?php 
                        if (!empty($sizeOptions)) {
                            foreach ($sizeOptions as $size => $value) : ?>
                                <button class="size-option" data-size="<?php echo htmlspecialchars($size); ?>" 
                                        data-value="<?php echo htmlspecialchars($value); ?>">
                                    <?php echo htmlspecialchars($size); ?> (<?php echo htmlspecialchars($value); ?>)
                                </button>
                            <?php endforeach;
                        } else {
                            echo '<p>Standard Size</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="option-group">
                    <label for="product-quantity">Quantity:</label>
                    <div class="quantity-selector">
                        <button type="button" class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                        <input type="number" id="product-quantity" value="1" min="1" max="99">
                        <button type="button" class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="product-actions">
                <button id="add-to-cart-btn" class="add-to-cart-btn" 
                        onclick="addToCart('<?php echo $product['id']; ?>', 
                                         '<?php echo addslashes($product['name']); ?>', 
                                         '<?php echo $product['price']; ?>', 
                                         '<?php echo $product['image1']; ?>')">
                    Add to Cart
                </button>
                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
            </div>
            <div class="product-benefits">
                    <div class="benefit">
                        <i class="fas fa-leaf"></i>
                        <span>100% Natural</span>
                    </div>
                    <div class="benefit">
                        <i class="fas fa-flask"></i>
                        <span>Scientifically Proven</span>
                    </div>
                    <div class="benefit">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Free Shipping</span>
                    </div>
                </div>
        </div>
    </div>

    <div class="product-information">
        <h2 class="section-title">Product Description</h2>
        <nav class="info-tabs">
            <button class="tab-btn active" data-tab="description" title="Description">
                <i class="fas fa-info-circle"></i>
            </button>
            <button class="tab-btn" data-tab="ingredients" title="Ingredients">
                <i class="fas fa-leaf"></i>
            </button>
            <button class="tab-btn" data-tab="how-to-use" title="How to Use">
                <i class="fas fa-hand-holding-medical"></i>
            </button>
            <button class="tab-btn" data-tab="reviews" title="Reviews">
                <i class="fas fa-star"></i>
            </button>
        </nav>
        <div class="tab-content">
            <div id="description" class="tab-pane active">
                <p id="full-description"><?php echo nl2br(htmlspecialchars($product['full_description'] ?: 'No description available.')); ?></p>
            </div>
            <div id="ingredients" class="tab-pane">
                <h3>Ingredients</h3>
                <ul id="ingredients-list">
                    <?php 
                    if (!empty($ingredients)) {
                        foreach ($ingredients as $ingredient) {
                            echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
                        }
                    } else {
                        echo '<li>Ingredients information not available.</li>';
                    }
                    ?>
                </ul>
            </div>
            <div id="how-to-use" class="tab-pane">
                <h3>How to Use</h3>
                <ol id="usage-instructions">
                    <?php 
                    if (!empty($usageInstructions)) {
                        foreach ($usageInstructions as $instruction) {
                            if (trim($instruction) !== '') {
                                echo '<li>' . htmlspecialchars(trim($instruction)) . '</li>';
                            }
                        }
                    } else {
                        echo '<li>Usage instructions not available.</li>';
                    }
                    ?>
                </ol>
            </div>
            <div id="reviews" class="tab-pane">
                <h3>Customer Reviews</h3>
                <div id="reviews-list">
                    <?php if (isset($product['reviews_count']) && $product['reviews_count'] > 0): ?>
                        <!-- Add your review display logic here -->
                        <p>Reviews coming soon!</p>
                    <?php else: ?>
                        <p>No reviews yet. Be the first to review this product!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Function to change main image when thumbnail is clicked
function changeMainImage(src) {
    document.getElementById('main-product-image').src = src;
}

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked button and corresponding pane
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Quantity selector functionality
    const quantityInput = document.getElementById('product-quantity');
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');

    minusBtn.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updatePrice();
        }
    });

    plusBtn.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < 99) {
            quantityInput.value = currentValue + 1;
            updatePrice();
        }
    });

    // Size selection functionality
    const sizeButtons = document.querySelectorAll('.size-option');
    sizeButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all size buttons
            sizeButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');
            updatePrice();
        });
    });
});

// Function to update price based on quantity and size
function updatePrice() {
    const basePrice = <?php echo $basePrice; ?>;
    const quantity = parseInt(document.getElementById('product-quantity').value);
    const activeSize = document.querySelector('.size-option.active');
    
    let totalPrice = basePrice;
    if (activeSize) {
        // If there's an active size selection, factor it into the price
        const sizeValue = activeSize.getAttribute('data-value');
        // Add any size-specific price modifications here if needed
    }
    
    totalPrice *= quantity;
    document.getElementById('product-price').textContent = '₹' + totalPrice.toFixed(2);
}
</script>

<?php include('footer.php'); ?>

    <!-- Add to Cart Modal -->
    <div id="add-to-cart-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <p id="modal-message">Product added to cart!</p>
            <button class="modal-ok-btn" onclick="closeModal()">Okay</button>
            <button class="modal-go-to-cart-btn" onclick="goToCart() && closeModal()">Go to Cart</button>
        </div>
    </div>

    <script src="./js/product-view.js"></script>
    <script src="./js/cart.js"></script>
    <script src="./js/script.js" defer></script>
</body>

</html>





<script type="">
    
</script>






    