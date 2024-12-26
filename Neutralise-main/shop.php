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
$selected_price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0;
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
                <input type="range" min="0" max="15000" value="<?php echo $selected_price_min; ?>" class="shop-price-slider" id="priceSlider">
                <div class="price-range">
                    <span id="selectedMinPrice">₹<?php echo number_format($selected_price_min, 2); ?></span>
                    <span class="price-separator">to</span>
                    <span id="selectedMaxPrice">₹<?php echo number_format($selected_price_max, 2); ?></span>
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

<!-- Floating Go to Cart Button -->
<div class="floating-cart-btn" onclick="goToCart()">
    <i class="fas fa-shopping-cart"></i>
    <span>Go to Cart</span>
    <span class="cart-count" id="floatingCartCount">0</span>
</div>

<style>
.price-slider-container {
    padding: 5px 0;
    width: 100%;
}

.price-range {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
    font-size: 0.9rem;
    color: #666;
    flex-wrap: wrap;
    gap: 5px;
}

.price-range span {
    display: inline-block;
    min-width: 60px;
    text-align: center;
    font-size: 0.85rem;
}

.price-separator {
    min-width: auto !important;
    padding: 0 5px;
}

.shop-price-slider {
    width: 100%;
    margin: 5px 0;
    height: 4px;
    -webkit-appearance: none;
    background: #ddd;
    border-radius: 2px;
    outline: none;
}

.shop-price-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 15px;
    height: 15px;
    background: var(--green-bg-color);
    border-radius: 50%;
    cursor: pointer;
}

.shop-price-slider::-moz-range-thumb {
    width: 15px;
    height: 15px;
    background: var(--green-bg-color);
    border-radius: 50%;
    cursor: pointer;
    border: none;
}

.shop-apply-filter-btn {
    margin-top: 10px;
    padding: 5px 15px;
    background: var(--green-bg-color);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background 0.3s ease;
}

.shop-apply-filter-btn:hover {
    background: var(--hover-color);
}

@media (max-width: 768px) {
    .price-range {
        font-size: 0.8rem;
    }
    
    .price-range span {
        min-width: 50px;
    }
    
    .shop-price-slider {
        height: 3px;
    }
    
    .shop-price-slider::-webkit-slider-thumb {
        width: 12px;
        height: 12px;
    }
    
    .shop-price-slider::-moz-range-thumb {
        width: 12px;
        height: 12px;
    }
}

@media (max-width: 480px) {
    .price-slider-container {
        padding: 3px 0;
    }
    
    .price-range {
        justify-content: center;
        gap: 8px;
    }
    
    .shop-apply-filter-btn {
        width: 100%;
        padding: 8px;
    }
}

/* Floating Cart Button Styles */
.floating-cart-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--green-bg-color);
    color: white;
    padding: 12px 20px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    z-index: 1000;
}

.floating-cart-btn:hover {
    background: var(--hover-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.floating-cart-btn i {
    font-size: 1.2rem;
}

.cart-count {
    background: white;
    color: var(--green-bg-color);
    padding: 2px 8px;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: bold;
}

@media (max-width: 768px) {
    .floating-cart-btn {
        bottom: 15px;
        right: 15px;
        padding: 10px 15px;
    }
    
    .floating-cart-btn span:not(.cart-count) {
        display: none; /* Hide "Go to Cart" text on mobile */
    }
    
    .cart-count {
        padding: 2px 6px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price slider functionality
    const priceSlider = document.getElementById('priceSlider');
    const selectedMinPrice = document.getElementById('selectedMinPrice');
    const selectedMaxPrice = document.getElementById('selectedMaxPrice');

    // Update price display when slider moves
    priceSlider.addEventListener('input', function() {
        selectedMinPrice.textContent = '₹' + parseFloat(this.value).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    });

    // Update floating cart count
    function updateFloatingCartCount() {
        fetch('cart_actions.php?action=count')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('floatingCartCount');
            if (cartCount) {
                cartCount.textContent = data.count || 0;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
    }
    
    // Initial cart count update
    updateFloatingCartCount();
    
    // Update cart count every time a product is added
    const addToCartButtons = document.querySelectorAll('.shop-add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            setTimeout(updateFloatingCartCount, 1000); // Update after add to cart action
        });
    });

    // Buy Now button functionality
    const buyNowButtons = document.querySelectorAll('.shop-buy-now-btn');
    buyNowButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            window.location.href = `product-view.php?id=${productId}`;
        });
    });
});

function applyPriceFilter() {
    var priceMin = document.getElementById('priceSlider').value;
    var priceMax = 15000; // You can make this dynamic if necessary
    window.location.href = '?category=' + '<?php echo $selected_category; ?>' + '&price_min=' + priceMin + '&price_max=' + priceMax;
}
</script>

<script src="./js/cart.js"></script>
<script src="./js/script.js" defer></script>
</body>
</html>