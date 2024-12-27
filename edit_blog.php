<?php
include 'connection.php';

// Get blog post data
if (!isset($_GET['id'])) {
    header('Location: manage_blogs.php');
    exit();
}

$blog_id = $_GET['id'];
$query = "SELECT * FROM blogs WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    header('Location: manage_blogs.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <h1>Edit Blog Post</h1>

        <form action="manage_blogs.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($blog['subtitle']); ?>">
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($blog['author']); ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($blog['category']); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" required><?php echo htmlspecialchars($blog['excerpt']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="tags">Tags (comma-separated)</label>
                <input type="text" id="tags" name="tags" value="<?php echo htmlspecialchars($blog['tags']); ?>" required>
            </div>

            <div class="form-group">
                <label>Current Image</label>
                <img src="contents/blog/<?php echo $blog['image']; ?>" alt="Current blog image" style="max-width: 200px; display: block; margin: 10px 0;">
                <label for="image">Change Image (leave empty to keep current image)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div class="button-group">
                <button type="submit" class="submit-btn">Update Blog Post</button>
                <a href="manage_blogs.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
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

        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .submit-btn, .cancel-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .submit-btn {
            background-color: var(--green-bg-color);
            color: white;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #5a6268;
        }
    </style>
</body>
</html> 