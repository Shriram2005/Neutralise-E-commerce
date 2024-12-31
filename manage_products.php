<?php
// Start output buffering at the very beginning
ob_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: var(--text-color);
            margin: 0;
        }

        .add-product-btn {
            background: var(--green-bg-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .add-product-btn:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .product-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: none;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-header h2 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            margin: 0;
            color: var(--text-color);
        }

        .close-form-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #666;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .close-form-btn:hover {
            color: #333;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--green-bg-color);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .size-options {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .size-options input {
            flex: 1;
        }

        .remove-size-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-size-btn {
            background: var(--green-bg-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .cancel-btn,
        .submit-btn {
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .cancel-btn {
            background: none;
            border: 1px solid #ddd;
            color: #666;
        }

        .submit-btn {
            background: var(--green-bg-color);
            border: none;
            color: white;
        }

        .cancel-btn:hover {
            background: #f8f9fa;
            border-color: #ccc;
        }

        .submit-btn:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .products-table-wrapper {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th,
        .products-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .products-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #444;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .edit-btn,
        .delete-btn {
            background: none;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-btn {
            color: #4CAF50;
        }

        .delete-btn {
            color: #dc3545;
        }

        .edit-btn:hover {
            background: #4CAF50;
            color: white;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: white;
        }

        .image-preview {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .add-product-btn {
                width: 100%;
                justify-content: center;
            }

            .products-table-wrapper {
                padding: 15px;
            }

            .products-table th,
            .products-table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <div class="page-header">
            <h1>Manage Products</h1>
            <button class="add-product-btn" onclick="showProductForm()">
                <i class="fas fa-plus"></i> Add New Product
            </button>
        </div>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form class="product-form" method="POST" enctype="multipart/form-data" id="productForm">
            <div class="form-header">
                <h2 id="formTitle">Add New Product</h2>
                <button type="button" class="close-form-btn" onclick="hideProductForm()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <input type="hidden" name="action" value="add" id="formAction">
            <input type="hidden" name="product_id" value="" id="productId">

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Product Name*</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price (₹)*</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="category">Category*</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="COMBO">COMBO</option>
                        <option value="BODY">BODY</option>
                        <option value="SKIN">SKIN</option>
                        <option value="FACE">FACE</option>
                        <option value="HAIR">HAIR</option>
                        <option value="BATH">BATH</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sku">SKU*</label>
                    <input type="text" id="sku" name="sku" required>
                </div>

                <div class="form-group">
                    <label for="tags">Tags (comma-separated)</label>
                    <input type="text" id="tags" name="tags" placeholder="e.g., organic, natural, ayurvedic">
                </div>

                <div class="form-group">
                    <label>Size Options</label>
                    <div id="sizeOptionsContainer">
                        <div class="size-options">
                            <input type="text" name="size_names[]" placeholder="Size Name (e.g., Small)">
                            <input type="text" name="size_values[]" placeholder="Size Value (e.g., 100ml)">
                            <button type="button" class="remove-size-btn" onclick="removeSize(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="add-size-btn" onclick="addSizeOption()">
                        <i class="fas fa-plus"></i> Add Size Option
                    </button>
                </div>

                <div class="form-group full-width">
                    <label for="description">Short Description*</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="full_description">Full Description*</label>
                    <textarea id="full_description" name="full_description" required></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="ingredients">Ingredients*</label>
                    <textarea id="ingredients" name="ingredients" required></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="usage_instructions">Usage Instructions*</label>
                    <textarea id="usage_instructions" name="usage_instructions" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image1">Main Image*</label>
                    <input type="file" id="image1" name="image1" accept="image/*" onchange="previewImage(this, 'preview1')" required>
                    <div class="image-preview" id="preview1"></div>
                </div>

                <div class="form-group">
                    <label for="image2">Additional Images</label>
                    <input type="file" id="image2" name="image2" accept="image/*" onchange="previewImage(this, 'preview2')">
                    <div class="image-preview" id="preview2"></div>
                    <input type="file" id="image3" name="image3" accept="image/*" onchange="previewImage(this, 'preview3')">
                    <div class="image-preview" id="preview3"></div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="hideProductForm()">Cancel</button>
                <button type="submit" class="submit-btn" id="submitBtn">Add Product</button>
            </div>
        </form>

        <div class="products-table-wrapper">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <img src="contents/products/<?php echo $product['image1']; ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-image">
                        </td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>₹<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td><?php echo htmlspecialchars($product['sku']); ?></td>
                        <td class="action-buttons">
                            <button class="edit-btn" onclick='editProduct(<?php echo json_encode($product); ?>)' title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(<?php echo $product['id']; ?>)" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function showProductForm() {
            document.getElementById('productForm').style.display = 'block';
            document.getElementById('formTitle').textContent = 'Add New Product';
            document.getElementById('formAction').value = 'add';
            document.getElementById('productId').value = '';
            document.getElementById('submitBtn').textContent = 'Add Product';
            document.getElementById('productForm').reset();
            clearImagePreviews();
        }

        function hideProductForm() {
            document.getElementById('productForm').style.display = 'none';
            document.getElementById('productForm').reset();
            clearImagePreviews();
        }

        function editProduct(product) {
            document.getElementById('productForm').style.display = 'block';
            document.getElementById('formTitle').textContent = 'Edit Product';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('productId').value = product.id;
            document.getElementById('submitBtn').textContent = 'Update Product';

            // Fill form fields
            document.getElementById('name').value = product.name;
            document.getElementById('price').value = product.price;
            document.getElementById('category').value = product.category;
            document.getElementById('tags').value = product.tags;
            document.getElementById('sku').value = product.sku;
            document.getElementById('description').value = product.description;
            document.getElementById('full_description').value = product.full_description;
            document.getElementById('ingredients').value = product.ingredients;
            document.getElementById('usage_instructions').value = product.usage_instructions;

            // Handle size options
            const sizeOptions = JSON.parse(product.size_options || '{}');
            const container = document.getElementById('sizeOptionsContainer');
            container.innerHTML = '';
            
            if (Object.keys(sizeOptions).length > 0) {
                for (const [name, value] of Object.entries(sizeOptions)) {
                    addSizeOption(name, value);
                }
            } else {
                addSizeOption();
            }

            // Show existing images
            if (product.image1) {
                showExistingImage('preview1', product.image1);
            }
            if (product.image2) {
                showExistingImage('preview2', product.image2);
            }
            if (product.image3) {
                showExistingImage('preview3', product.image3);
            }

            // Make image1 not required when editing
            document.getElementById('image1').removeAttribute('required');
        }

        function showExistingImage(previewId, imageName) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = `
                <img src="contents/products/${imageName}" 
                     alt="Product image" 
                     class="preview-image">
            `;
        }

        function clearImagePreviews() {
            document.getElementById('preview1').innerHTML = '';
            document.getElementById('preview2').innerHTML = '';
            document.getElementById('preview3').innerHTML = '';
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Image preview" 
                             class="preview-image">
                    `;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addSizeOption(name = '', value = '') {
            const container = document.getElementById('sizeOptionsContainer');
            const div = document.createElement('div');
            div.className = 'size-options';
            div.innerHTML = `
                <input type="text" name="size_names[]" placeholder="Size Name (e.g., Small)" value="${name}">
                <input type="text" name="size_values[]" placeholder="Size Value (e.g., 100ml)" value="${value}">
                <button type="button" class="remove-size-btn" onclick="removeSize(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function removeSize(button) {
            button.parentElement.remove();
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = `delete_product.php?id=${id}`;
            }
        }

        // Hide success message after 3 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html> 