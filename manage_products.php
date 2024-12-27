<?php
// Start output buffering at the very beginning
ob_start();
include 'header.php';
include 'connection.php';

// Initialize message variables
$success_message = '';
$error_message = '';

// Handle form submission for adding/editing product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $price = (float)$_POST['price'];
            $category = mysqli_real_escape_string($con, $_POST['category']);
            $tags = mysqli_real_escape_string($con, $_POST['tags']);
            $sku = mysqli_real_escape_string($con, $_POST['sku']);
            $description = mysqli_real_escape_string($con, $_POST['description']);
            $full_description = mysqli_real_escape_string($con, $_POST['full_description']);
            $ingredients = mysqli_real_escape_string($con, $_POST['ingredients']);
            $usage_instructions = mysqli_real_escape_string($con, $_POST['usage_instructions']);
            
            // Handle size options
            $size_options = [];
            if (isset($_POST['size_names']) && isset($_POST['size_values'])) {
                $size_names = $_POST['size_names'];
                $size_values = $_POST['size_values'];
                for ($i = 0; $i < count($size_names); $i++) {
                    if (!empty($size_names[$i]) && !empty($size_values[$i])) {
                        $size_options[$size_names[$i]] = $size_values[$i];
                    }
                }
            }
            $size_options_json = json_encode($size_options);

            try {
                if ($_POST['action'] == 'add') {
                    // Handle file uploads for new product
                    $image1 = $_FILES['image1']['name'] ? $_FILES['image1']['name'] : '';
                    $image2 = $_FILES['image2']['name'] ? $_FILES['image2']['name'] : '';
                    $image3 = $_FILES['image3']['name'] ? $_FILES['image3']['name'] : '';

                    $sql = "INSERT INTO products (name, price, image1, image2, image3, category, tags, sku, description, 
                            full_description, size_options, ingredients, usage_instructions) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("sdsssssssssss", $name, $price, $image1, $image2, $image3, $category, $tags, $sku,
                                    $description, $full_description, $size_options_json, $ingredients, $usage_instructions);
                } else {
                    // For edit, first get existing product data
                    if (!isset($_POST['product_id'])) {
                        throw new Exception("Product ID is missing");
                    }
                    $id = (int)$_POST['product_id'];
                    
                    // Get existing product data
                    $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $existing_product = $result->fetch_assoc();
                    $stmt->close();

                    if (!$existing_product) {
                        throw new Exception("Product not found");
                    }

                    // Build the update query dynamically based on what's being updated
                    $updateFields = [
                        "name=?", "price=?", "category=?", "tags=?", "sku=?",
                        "description=?", "full_description=?", "size_options=?",
                        "ingredients=?", "usage_instructions=?"
                    ];
                    $params = [$name, $price, $category, $tags, $sku,
                             $description, $full_description, $size_options_json,
                             $ingredients, $usage_instructions];
                    $types = "sdssssssss";

                    // Only include images in update if new ones are uploaded
                    if (!empty($_FILES['image1']['name'])) {
                        $updateFields[] = "image1=?";
                        $params[] = $_FILES['image1']['name'];
                        $types .= "s";
                    }
                    if (!empty($_FILES['image2']['name'])) {
                        $updateFields[] = "image2=?";
                        $params[] = $_FILES['image2']['name'];
                        $types .= "s";
                    }
                    if (!empty($_FILES['image3']['name'])) {
                        $updateFields[] = "image3=?";
                        $params[] = $_FILES['image3']['name'];
                        $types .= "s";
                    }

                    // Add the ID parameter
                    $params[] = $id;
                    $types .= "i";

                    $sql = "UPDATE products SET " . implode(", ", $updateFields) . " WHERE id=?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param($types, ...$params);
                }

                if ($stmt->execute()) {
                    // Handle file uploads only for new images
                    $target_dir = "contents/products/";
                    if (!empty($_FILES['image1']['name'])) {
                        move_uploaded_file($_FILES['image1']['tmp_name'], $target_dir . $_FILES['image1']['name']);
                    }
                    if (!empty($_FILES['image2']['name'])) {
                        move_uploaded_file($_FILES['image2']['tmp_name'], $target_dir . $_FILES['image2']['name']);
                    }
                    if (!empty($_FILES['image3']['name'])) {
                        move_uploaded_file($_FILES['image3']['tmp_name'], $target_dir . $_FILES['image3']['name']);
                    }
                    
                    $success_message = "Product " . ($_POST['action'] == 'add' ? "added" : "updated") . " successfully!";
                    
                    // Clear the output buffer and redirect
                    ob_end_clean();
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                    exit();
                } else {
                    $error_message = "Error: " . $stmt->error;
                }
                $stmt->close();
            } catch (Exception $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        }
    }
}

// Check for success message in URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Operation completed successfully!";
}

// Fetch existing products
$products = $con->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .product-form {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-group textarea {
            min-height: 100px;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 0.5rem;
        }
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        .btn-danger {
            background: #f44336;
            color: white;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        .products-table th,
        .products-table td {
            padding: 0.75rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        .products-table th {
            background: #f5f5f5;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        .alert-success {
            background: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .alert-danger {
            background: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Manage Products</h1>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form class="product-form" method="POST" enctype="multipart/form-data" id="productForm">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="price">Price (₹)</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" required>
            </div>
            
            <div class="form-group">
                <label for="tags">Tags (comma-separated)</label>
                <input type="text" id="tags" name="tags">
            </div>
            
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku">
            </div>
            
            <div class="form-group">
                <label for="description">Short Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="full_description">Full Description</label>
                <textarea id="full_description" name="full_description"></textarea>
            </div>
            
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea id="ingredients" name="ingredients"></textarea>
            </div>
            
            <div class="form-group">
                <label for="usage_instructions">Usage Instructions</label>
                <textarea id="usage_instructions" name="usage_instructions"></textarea>
            </div>
            
            <div class="form-group">
                <label>Size Options</label>
                <div id="size-options-container">
                    <div class="size-option-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <input type="text" name="size_names[]" placeholder="Size (e.g., Small)" style="flex: 1;">
                        <input type="text" name="size_values[]" placeholder="Value (e.g., 100ml)" style="flex: 1;">
                        <button type="button" class="btn btn-danger remove-size" onclick="removeSizeOption(this)" style="flex: 0 0 auto;">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addSizeOption()" style="margin-top: 10px;">Add Size Option</button>
            </div>
            
            <div class="form-group">
                <label for="image1">Main Image</label>
                <input type="file" id="image1" name="image1" accept="image/*" <?php echo ($_POST['action'] == 'add' ? 'required' : ''); ?>>
                <div id="current_image1"></div>
            </div>
            
            <div class="form-group">
                <label for="image2">Additional Image 1</label>
                <input type="file" id="image2" name="image2" accept="image/*">
                <div id="current_image2"></div>
            </div>
            
            <div class="form-group">
                <label for="image3">Additional Image 2</label>
                <input type="file" id="image3" name="image3" accept="image/*">
                <div id="current_image3"></div>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <h2>Existing Products</h2>
        <div style="overflow-x: auto;">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>₹<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                                <button class="btn btn-primary" onclick="editProduct(<?php echo htmlspecialchars(json_encode($product)); ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function editProduct(product) {
        // Fill the form with product data
        document.querySelector('input[name="action"]').value = 'edit';
        document.querySelector('input[name="product_id"]').value = product.id;
        document.querySelector('input[name="name"]').value = product.name;
        document.querySelector('input[name="price"]').value = product.price;
        document.querySelector('input[name="category"]').value = product.category;
        document.querySelector('input[name="tags"]').value = product.tags || '';
        document.querySelector('input[name="sku"]').value = product.sku || '';
        document.querySelector('textarea[name="description"]').value = product.description || '';
        document.querySelector('textarea[name="full_description"]').value = product.full_description || '';
        document.querySelector('textarea[name="ingredients"]').value = product.ingredients || '';
        document.querySelector('textarea[name="usage_instructions"]').value = product.usage_instructions || '';
        
        // Handle size options
        const sizeContainer = document.getElementById('size-options-container');
        sizeContainer.innerHTML = ''; // Clear existing size options
        
        try {
            const sizeOptions = JSON.parse(product.size_options || '{}');
            if (Object.keys(sizeOptions).length === 0) {
                // Add one empty row if no size options exist
                addSizeOption();
            } else {
                Object.entries(sizeOptions).forEach(([name, value]) => {
                    const row = document.createElement('div');
                    row.className = 'size-option-row';
                    row.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
                    row.innerHTML = `
                        <input type="text" name="size_names[]" value="${name}" placeholder="Size (e.g., Small)" style="flex: 1;">
                        <input type="text" name="size_values[]" value="${value}" placeholder="Value (e.g., 100ml)" style="flex: 1;">
                        <button type="button" class="btn btn-danger remove-size" onclick="removeSizeOption(this)" style="flex: 0 0 auto;">Remove</button>
                    `;
                    sizeContainer.appendChild(row);
                });
            }
        } catch (e) {
            console.error('Error parsing size options:', e);
            addSizeOption();
        }
        
        // Show current images
        for (let i = 1; i <= 3; i++) {
            const imageDiv = document.getElementById(`current_image${i}`);
            const imageName = product[`image${i}`];
            if (imageName) {
                imageDiv.innerHTML = `
                    <div style="margin: 10px 0;">
                        <p>Current image: ${imageName}</p>
                        <img src="contents/products/${imageName}" alt="Current Image ${i}" style="max-width: 100px; margin: 5px 0;">
                        <p style="color: #666; font-size: 0.9em;">Upload a new image only if you want to change it</p>
                    </div>
                `;
            } else {
                imageDiv.innerHTML = '';
            }
        }
        
        // Remove required attribute from image1 when editing
        document.getElementById('image1').removeAttribute('required');
        
        // Change submit button text
        document.querySelector('.product-form .btn-primary').textContent = 'Update Product';
        
        // Scroll to form
        document.querySelector('.product-form').scrollIntoView({ behavior: 'smooth' });
    }

    function addSizeOption() {
        const container = document.getElementById('size-options-container');
        const row = document.createElement('div');
        row.className = 'size-option-row';
        row.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
        row.innerHTML = `
            <input type="text" name="size_names[]" placeholder="Size (e.g., Small)" style="flex: 1;">
            <input type="text" name="size_values[]" placeholder="Value (e.g., 100ml)" style="flex: 1;">
            <button type="button" class="btn btn-danger remove-size" onclick="removeSizeOption(this)" style="flex: 0 0 auto;">Remove</button>
        `;
        container.appendChild(row);
    }

    function removeSizeOption(button) {
        const container = document.getElementById('size-options-container');
        if (container.children.length > 1) {
            button.parentElement.remove();
        }
    }

    // Add form submit handler to convert size options to JSON
    document.querySelector('.product-form').addEventListener('submit', function(e) {
        // Remove the default e.preventDefault() to allow normal form submission
        // We don't need to handle JSON conversion in JavaScript anymore
        // as it's now handled in PHP
        
        // Validate that at least one size option is filled
        const sizeNames = [...document.getElementsByName('size_names[]')].map(input => input.value.trim());
        const sizeValues = [...document.getElementsByName('size_values[]')].map(input => input.value.trim());
        
        let hasValidSize = false;
        for (let i = 0; i < sizeNames.length; i++) {
            if (sizeNames[i] && sizeValues[i]) {
                hasValidSize = true;
                break;
            }
        }
        
        if (!hasValidSize) {
            e.preventDefault();
            alert('Please add at least one size option for the product.');
            return false;
        }
    });

    // Add form reset handler
    document.getElementById('productForm').addEventListener('reset', function() {
        // Reset action to 'add' and clear product_id
        document.querySelector('input[name="action"]').value = 'add';
        document.querySelector('input[name="product_id"]').value = '';
        // Reset button text
        document.querySelector('.product-form .btn-primary').textContent = 'Add Product';
        // Clear current images
        for (let i = 1; i <= 3; i++) {
            document.getElementById(`current_image${i}`).innerHTML = '';
        }
        // Reset size options to default
        const sizeContainer = document.getElementById('size-options-container');
        sizeContainer.innerHTML = '';
        addSizeOption();
        // Make image1 required again
        document.getElementById('image1').setAttribute('required', 'required');
    });

    // Add a clear form button
    const formButtons = document.querySelector('.product-form .btn-primary').parentElement;
    const clearButton = document.createElement('button');
    clearButton.type = 'button';
    clearButton.className = 'btn btn-danger';
    clearButton.textContent = 'Clear Form';
    clearButton.onclick = function() {
        if(confirm('Are you sure you want to clear the form?')) {
            document.getElementById('productForm').reset();
        }
    };
    formButtons.appendChild(clearButton);
    </script>

    <?php include('footer.php'); ?>
</body>
</html> 