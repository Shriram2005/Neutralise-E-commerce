<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals - Shop</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/shop.css">
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
    <!-- Products Section -->
<?php
include('connection.php');

// Get the selected category, price range, and tag from URL or form (if any)
$selected_category = isset($_GET['category']) ? mysqli_real_escape_string($con, $_GET['category']) : '';
$selected_price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 400;
$selected_price_max = isset($_GET['price_max']) ? (float)$_GET['price_max'] : 15000;
$selected_tag = isset($_GET['tag']) ? mysqli_real_escape_string($con, $_GET['tag']) : '';

// Start the base query to get all products using prepared statement
$sql = "SELECT * FROM products WHERE price BETWEEN ? AND ?";
$params = [$selected_price_min, $selected_price_max];
$types = "dd"; // d for double

if ($selected_category != '' && $selected_category != 'all') {
    $sql .= " AND category = ?";
    $params[] = $selected_category;
    $types .= "s";
}

if ($selected_tag != '') {
    $sql .= " AND FIND_IN_SET(?, tags)";
    $params[] = $selected_tag;
    $types .= "s";
}

// Prepare and execute the statement
$stmt = $con->prepare($sql);
if ($stmt) {
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Error preparing statement: " . $con->error);
}

// Fetch categories and their product count for the filter section
$category_sql = "
    SELECT category, COUNT(*) AS product_count
    FROM products
    GROUP BY category
";
$category_result = $con->query($category_sql);

// Fetch all distinct tags across all products (tags are stored in a comma-separated format)
$tags_sql = "SELECT DISTINCT tags FROM products";
$tags_result = $con->query($tags_sql);

// Collect all unique tags across products
$all_tags = [];
while ($row = $tags_result->fetch_assoc()) {
    $tags = explode(',', $row['tags']);
    foreach ($tags as $tag) {
        if (!in_array(trim($tag), $all_tags)) {
            $all_tags[] = trim($tag);
        }
    }
}

?>

<div class="shop-container">
    <!-- Product Grid Section -->
    <div class="shop-products-section">
        <div class="shop-products-grid">
            <?php
            // Check if there are any products returned from the query
            if ($result->num_rows > 0) {
                while($product = $result->fetch_assoc()) {
                    // Fetch and display tags for the product
                    $tags = explode(',', $product['tags']); // Assuming tags are stored as a comma-separated list
                    $tags_display = implode(', ', $tags); // Display tags as a comma-separated list

                    // Display product card
                    echo '
                    <div class="shop-product-card">
                        <a href="product-view.php?id=' . $product['id'] . '" class="shop-product-link">
                            <div class="shop-product-image">
                                <img src="contents/products/' . $product['image1'] . '" loading="lazy" alt="' . $product['name'] . '" class="shop-product-img">
                                <div class="shop-product-overlay">
                                    <p>View Details</p>
                                </div>
                            </div>
                            <div class="shop-product-info">
                                <h3 class="shop-product-title">' . $product['name'] . '</h3>
                                <p class="shop-product-price">₹' . number_format($product['price'], 2) . '</p>
                                <div class="shop-product-tags">
                                    ' . $tags_display . '
                                </div>
                            </div>
                        </a>
                        <div class="shop-product-actions">
                            <button class="shop-buy-now-btn" data-product-id="' . $product['id'] . '">Buy Now</button>
                            <button class="shop-add-to-cart-btn" title="Add to Cart"
                                onclick="addToCart(\'' . $product['id'] . '\', \'' . $product['name'] . '\', \'' . $product['price'] . '\', \'' . $product['image1'] . '\')">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>';
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="shop-filter-section">
        <h2>Explore</h2>
        <div class="shop-filter-group">
            <ul>
                <li><a href="?category=all&price_min=<?php echo $selected_price_min; ?>&price_max=<?php echo $selected_price_max; ?>">All</a></li>
                <?php
                if ($category_result->num_rows > 0) {
                    while ($category = $category_result->fetch_assoc()) {
                        echo '<li><a href="?category=' . $category['category'] . '&price_min=' . $selected_price_min . '&price_max=' . $selected_price_max . '">' . $category['category'] . ' <span>(' . $category['product_count'] . ')</span></a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <h2>Price</h2>
        <div class="shop-filter-group">
            <div class="price-slider-container">
                <input type="range" min="400" max="15000" value="<?php echo $selected_price_min; ?>" class="shop-price-slider" id="priceSlider">
                <div class="price-range">
                    <span>₹400</span>
                    <span>₹15,000</span>
                </div>
            </div>
            <button class="shop-apply-filter-btn" onclick="applyPriceFilter()">Filter</button>
        </div>
        <h2>Product tags</h2>
        <div class="shop-filter-group">
            <div class="product-tags">
                <?php
                // Display all unique tags across products
                foreach ($all_tags as $tag) {
                    echo '<a href="?category=' . $selected_category . '&price_min=' . $selected_price_min . '&price_max=' . $selected_price_max . '&tag=' . urlencode($tag) . '" class="tag">' . $tag . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function applyPriceFilter() {
        var priceMin = document.getElementById('priceSlider').value;
        var priceMax = 15000; // You can make this dynamic if necessary
        window.location.href = '?category=' + '<?php echo $selected_category; ?>' + '&price_min=' + priceMin + '&price_max=' + priceMax;
    }
</script>

<?php $con->close(); ?>




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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyNowButtons = document.querySelectorAll('.shop-buy-now-btn');

            buyNowButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    window.location.href = `product-view.php?id=${productId}`;
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyNowButtons = document.querySelectorAll('.shop-buy-now-btn');
            buyNowButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    window.location.href = `product-view.php?id=${productId}`;
                });
            });
        });


    </script>



    <script src="./js/cart.js"></script>
    <script src="./js/script.js" defer></script>
</body>

</html>