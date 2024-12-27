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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 300,
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <h1>Manage Blogs</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <button class="add-blog-btn" onclick="toggleForm()">Add New Blog</button>

        <div id="blogForm" style="display: none;">
            <h2>Add New Blog Post</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle">
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" required></textarea>
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" required>
                </div>

                <div class="form-group">
                    <label for="excerpt">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" required></textarea>
                </div>

                <div class="form-group">
                    <label for="tags">Tags (comma-separated)</label>
                    <input type="text" id="tags" name="tags" required>
                </div>

                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="submit-btn">Create Blog Post</button>
            </form>
        </div>

        <div class="blog-list">
            <h2>Existing Blog Posts</h2>
            <table>
                <thead>
                    <tr>
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
                        <td><?php echo htmlspecialchars($blog['title']); ?></td>
                        <td><?php echo htmlspecialchars($blog['category']); ?></td>
                        <td><?php echo htmlspecialchars($blog['author']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($blog['post_date'])); ?></td>
                        <td>
                            <button onclick="editBlog(<?php echo $blog['id']; ?>)" class="edit-btn">Edit</button>
                            <button onclick="deleteBlog(<?php echo $blog['id']; ?>)" class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
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
            background-color: var(--green-bg-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .blog-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .blog-list th, .blog-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .blog-list th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #ffc107;
            color: #000;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 100px;
        }

        .submit-btn {
            background-color: var(--green-bg-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>

    <script>
        function toggleForm() {
            const form = document.getElementById('blogForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function deleteBlog(id) {
            if (confirm('Are you sure you want to delete this blog post?')) {
                window.location.href = `manage_blogs.php?delete=${id}`;
            }
        }

        function editBlog(id) {
            // Redirect to edit page or show edit form
            window.location.href = `edit_blog.php?id=${id}`;
        }
    </script>
</body>
</html> 