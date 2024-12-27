<?php
include 'connection.php';

// Handle blog deletion
if (isset($_GET['delete'])) {
    $blog_id = $_GET['delete'];
    // First delete the associated image
    $image_query = "SELECT image FROM blogs WHERE id = ?";
    $stmt = $con->prepare($image_query);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $image_path = "contents/blog/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Then delete the blog post
    $delete_query = "DELETE FROM blogs WHERE id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $blog_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Blog post deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting blog post.";
    }
    header('Location: manage_blogs.php');
    exit();
}

// Handle blog creation/update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $excerpt = $_POST['excerpt'];
    $tags = $_POST['tags'];
    $post_date = date('Y-m-d');

    if (isset($_POST['blog_id'])) {
        // Update existing blog
        $blog_id = $_POST['blog_id'];
        $query = "UPDATE blogs SET title=?, subtitle=?, content=?, author=?, category=?, excerpt=?, tags=?, post_date=? WHERE id=?";
        
        if ($_FILES['image']['name']) {
            // Handle new image upload
            $image = $_FILES['image']['name'];
            $target = "contents/blog/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            
            $query = "UPDATE blogs SET title=?, subtitle=?, content=?, author=?, category=?, excerpt=?, tags=?, post_date=?, image=? WHERE id=?";
        }
        
        $stmt = $con->prepare($query);
        if ($_FILES['image']['name']) {
            $stmt->bind_param("sssssssssi", $title, $subtitle, $content, $author, $category, $excerpt, $tags, $post_date, $image, $blog_id);
        } else {
            $stmt->bind_param("ssssssssi", $title, $subtitle, $content, $author, $category, $excerpt, $tags, $post_date, $blog_id);
        }
    } else {
        // Create new blog
        $image = $_FILES['image']['name'];
        $target = "contents/blog/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        
        $query = "INSERT INTO blogs (title, subtitle, content, author, category, excerpt, tags, post_date, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssssss", $title, $subtitle, $content, $author, $category, $excerpt, $tags, $post_date, $image);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = isset($_POST['blog_id']) ? "Blog updated successfully!" : "Blog created successfully!";
    } else {
        $_SESSION['error'] = "Error " . (isset($_POST['blog_id']) ? "updating" : "creating") . " blog post.";
    }
    header('Location: manage_blogs.php');
    exit();
}

// Get all blog posts
$blogs = $con->query("SELECT * FROM blogs ORDER BY post_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <div class="page-header">
            <h1>Manage Blogs</h1>
            <button class="add-blog-btn" onclick="toggleForm()">
                <i class="fas fa-plus"></i> Add New Blog
            </button>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div id="blogForm" class="blog-form" style="display: none;">
            <div class="form-header">
                <h2>Add New Blog Post</h2>
                <button type="button" class="close-btn" onclick="toggleForm()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle">
                    </div>

                    <div class="form-group">
                        <label for="author">Author*</label>
                        <input type="text" id="author" name="author" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category*</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Psoriasis">Psoriasis</option>
                            <option value="Vitiligo">Vitiligo</option>
                            <option value="Eczema">Eczema</option>
                            <option value="Ayurvedic Wisdom">Ayurvedic Wisdom</option>
                            <option value="Natural Remedies">Natural Remedies</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Content*</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('bold')" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" onclick="formatText('italic')" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" onclick="formatText('underline')" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <button type="button" onclick="insertList('ul')" title="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" onclick="insertList('ol')" title="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>
                        <button type="button" onclick="addHeading()" title="Add Heading">
                            <i class="fas fa-heading"></i>
                        </button>
                    </div>
                    <textarea id="content" name="content" required rows="12"></textarea>
                </div>

                <div class="form-group">
                    <label for="excerpt">Excerpt* (Brief summary)</label>
                    <textarea id="excerpt" name="excerpt" required rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="tags">Tags* (comma-separated)</label>
                    <input type="text" id="tags" name="tags" required placeholder="e.g., psoriasis, natural remedies, ayurveda">
                </div>

                <div class="form-group">
                    <label for="image">Featured Image*</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*" required>
                        <div class="file-preview"></div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="toggleForm()">Cancel</button>
                    <button type="submit" class="submit-btn">Create Blog Post</button>
                </div>
            </form>
        </div>

        <div class="blog-list">
            <h2>Existing Blog Posts</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($blog = $blogs->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <img src="contents/blog/<?php echo $blog['image']; ?>" alt="Blog thumbnail" class="blog-thumbnail">
                            </td>
                            <td>
                                <div class="blog-title-cell">
                                    <strong><?php echo htmlspecialchars($blog['title']); ?></strong>
                                    <span class="blog-subtitle"><?php echo htmlspecialchars($blog['subtitle']); ?></span>
                                </div>
                            </td>
                            <td><span class="category-badge"><?php echo htmlspecialchars($blog['category']); ?></span></td>
                            <td><?php echo htmlspecialchars($blog['author']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($blog['post_date'])); ?></td>
                            <td class="action-buttons">
                                <button onclick="editBlog(<?php echo htmlspecialchars(json_encode($blog)); ?>)" class="edit-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteBlog(<?php echo $blog['id']; ?>)" class="delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

<style>
.admin-container {
    max-width: 1200px;
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

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert i {
    font-size: 1.2rem;
}

.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.add-blog-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: var(--green-bg-color);
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.add-blog-btn:hover {
    background-color: var(--dark-green-color);
    transform: translateY(-2px);
}

.blog-form {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
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

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #666;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #333;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
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

.editor-toolbar {
    display: flex;
    gap: 5px;
    padding: 8px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}

.editor-toolbar button {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #444;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.editor-toolbar button:hover {
    background: #e9ecef;
    color: #000;
}

#content {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.file-input-wrapper {
    position: relative;
}

.file-preview {
    margin-top: 10px;
    max-width: 200px;
}

.file-preview img {
    width: 100%;
    border-radius: 4px;
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
    background-color: var(--green-bg-color);
    border: none;
    color: white;
}

.cancel-btn:hover {
    background-color: #f8f9fa;
    border-color: #ccc;
}

.submit-btn:hover {
    background-color: var(--dark-green-color);
    transform: translateY(-2px);
}

.blog-list {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.blog-list h2 {
    font-family: var(--font-heading);
    font-size: 1.8rem;
    margin: 0 0 20px;
    color: var(--text-color);
}

.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #444;
}

.blog-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.blog-title-cell {
    display: flex;
    flex-direction: column;
}

.blog-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-top: 4px;
}

.category-badge {
    display: inline-block;
    padding: 4px 12px;
    background-color: #e9ecef;
    color: #495057;
    border-radius: 20px;
    font-size: 0.9rem;
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
    background-color: #4CAF50;
    color: white;
}

.delete-btn:hover {
    background-color: #dc3545;
    color: white;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .add-blog-btn {
        width: 100%;
        justify-content: center;
    }

    .blog-form {
        padding: 20px;
    }

    .blog-list {
        padding: 20px;
    }

    th, td {
        padding: 10px;
    }
}
</style>

<script>
function toggleForm() {
    const form = document.getElementById('blogForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function formatText(command) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let formattedText = '';
    switch(command) {
        case 'bold':
            formattedText = `<strong>${selectedText}</strong>`;
            break;
        case 'italic':
            formattedText = `<em>${selectedText}</em>`;
            break;
        case 'underline':
            formattedText = `<u>${selectedText}</u>`;
            break;
    }
    
    textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
}

function insertList(type) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    
    const listTemplate = type === 'ul' ? 
        '<ul>\n  <li>Item 1</li>\n  <li>Item 2</li>\n  <li>Item 3</li>\n</ul>' :
        '<ol>\n  <li>Item 1</li>\n  <li>Item 2</li>\n  <li>Item 3</li>\n</ol>';
    
    textarea.value = textarea.value.substring(0, start) + '\n' + listTemplate + '\n' + textarea.value.substring(start);
}

function addHeading() {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    const headingText = `<h2>${selectedText || 'Heading'}</h2>`;
    textarea.value = textarea.value.substring(0, start) + headingText + textarea.value.substring(end);
}

function editBlog(blog) {
    document.getElementById('blogForm').style.display = 'block';
    document.getElementById('title').value = blog.title;
    document.getElementById('subtitle').value = blog.subtitle;
    document.getElementById('content').value = blog.content;
    document.getElementById('author').value = blog.author;
    document.getElementById('category').value = blog.category;
    document.getElementById('excerpt').value = blog.excerpt;
    document.getElementById('tags').value = blog.tags;
    
    // Add hidden input for blog ID
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'blog_id';
    hiddenInput.value = blog.id;
    document.querySelector('form').appendChild(hiddenInput);
    
    // Update form title and button text
    document.querySelector('.form-header h2').textContent = 'Edit Blog Post';
    document.querySelector('.submit-btn').textContent = 'Update Blog Post';
}

function deleteBlog(id) {
    if (confirm('Are you sure you want to delete this blog post?')) {
        window.location.href = `?delete=${id}`;
    }
}

// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.file-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html> 