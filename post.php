
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/blog.css">
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">

    <style>
    /* General styling for blog posts */
/* General styling for blog posts */
.blog-post,
.filtered-blogs .blog-post {
    width: 100%; /* Full width on small screens */
    max-width: 600px; /* Max width for larger screens */
    height: auto; /* Allow height to adjust based on content */
    margin: 15px; /* Space between blog items */
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    overflow: hidden; /* Ensure content doesn't overflow */
    border: 1px solid #ddd; /* Optional: Add a border for better visibility */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    background-color: #fff; /* Background color */
}

/* Styling for blog images */
.blog-post .blog-image,
.filtered-blogs .blog-post .blog-image {
    width: 100%;
    height: 200px;
    object-fit: cover; /* Ensure the image covers the area without distortion */
    border-bottom: 1px solid #ddd; /* Border below the image */
}

/* Content area inside the blog post */
.blog-post .post-content,
.filtered-blogs .blog-post .post-content {
    padding: 10px;
    display: flex;
    flex-direction: column;
    height: auto; /* Remove fixed height to allow for dynamic content */
}

/* Title Styling */
.blog-post .post-content h2,
.filtered-blogs .blog-post .post-content h3 {
    font-size: 1.2rem; /* Adjust font size */
    margin: 10px 0;
    font-weight: bold;
    color: #333;
}

/* Blog metadata */
.blog-post .post-meta,
.filtered-blogs .blog-post .post-meta {
    font-size: 0.9rem;
    color: #777;
}

/* Excerpt styling */
.blog-post .blog-excerpt,
.filtered-blogs .blog-post .blog-excerpt {
    font-size: 1rem;
    color: #555;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit to 3 lines */
    -webkit-box-orient: vertical;
}

/* Read more button */
.blog-post .read-more,
.filtered-blogs .blog-post .read-more {
    margin-top: 10px;
    padding: 8px 15px;
    font-size: 0.9rem;
    color: #fff;
    background-color: #007BFF;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    text-align: center;
}

.blog-post .read-more:hover,
.filtered-blogs .blog-post .read-more:hover {
    background-color: #0056b3;
}

/* Grid layout for the filtered blogs */
.filtered-blogs .blog-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

/* Media Queries */

/* Small screens (Mobile devices) */
@media (max-width: 600px) {
    .blog-post,
    .filtered-blogs .blog-post {
        width: 100%; /* Full width on small screens */
        margin: 10px 0; /* Reduce margin to fit content better */
    }
    .blog-post .post-content,
    .filtered-blogs .blog-post .post-content {
        padding: 5px; /* Less padding for small screens */
    }
    .blog-post .post-content h2,
    .filtered-blogs .blog-post .post-content h3 {
        font-size: 1rem; /* Smaller font size */
    }
    .blog-post .blog-excerpt,
    .filtered-blogs .blog-post .blog-excerpt {
        font-size: 0.9rem; /* Adjust font size for readability */
    }
}

/* Medium screens (Tablets) */
@media (min-width: 601px) and (max-width: 1024px) {
    .blog-post,
    .filtered-blogs .blog-post {
        width: 48%; /* Two columns layout for medium screens */
        height: auto;
    }
    .blog-post .post-content,
    .filtered-blogs .blog-post .post-content {
        padding: 10px; /* Default padding */
    }
    .blog-post .post-content h2,
    .filtered-blogs .blog-post .post-content h3 {
        font-size: 1.1rem; /* Adjust font size for medium screens */
    }
    .blog-post .blog-excerpt,
    .filtered-blogs .blog-post .blog-excerpt {
        font-size: 1rem;
    }
}

/* Large screens (Desktops) */
@media (min-width: 1025px) {
    .blog-post,
    .filtered-blogs .blog-post {
        width: 100%; /* Three columns layout for large screens */
        height: auto;
    }
    .blog-post .post-content,
    .filtered-blogs .blog-post .post-content {
        padding: 15px; /* More padding for larger screens */
    }
    .blog-post .post-content h2,
    .filtered-blogs .blog-post .post-content h3 {
        font-size: 1.2rem; /* Larger font size for desktops */
    }
    .blog-post .blog-excerpt,
    .filtered-blogs .blog-post .blog-excerpt {
        font-size: 1.1rem; /* Adjust font size for larger screens */
    }
}

</style>
</head>

<body>
    <?php include 'header.php';?>

<?php
// Include database connection
include('connection.php');

// Initialize variables
$blog = null;
$where_clause = '';

// Check if a specific blog post ID is provided
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']); // Sanitize input
    $sql = "SELECT * FROM blogs WHERE id = $post_id LIMIT 1";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        die("Post not found.");
    }
}

// Check if a specific category is requested
if (isset($_GET['category'])) {
    $category = $con->real_escape_string($_GET['category']);
    $where_clause = "WHERE category = '$category'";
}

// Check if a specific tag is requested
if (isset($_GET['tag'])) {
    $tag = $con->real_escape_string($_GET['tag']);
    $where_clause = "WHERE FIND_IN_SET('$tag', tags)";
}

// Fetch blogs based on category or tag filter
if (!empty($where_clause)) {
    $sql = "SELECT * FROM blogs $where_clause ORDER BY post_date DESC";
    $filtered_blogs_result = $con->query($sql);
}

// Query to fetch categories for sidebar
$category_sql = "SELECT DISTINCT category FROM blogs";
$category_result = $con->query($category_sql);
$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Query to fetch all tags for sidebar
$tag_sql = "SELECT DISTINCT tags FROM blogs";
$tag_result = $con->query($tag_sql);
$tags = [];
while ($row = $tag_result->fetch_assoc()) {
    $tags[] = explode(',', $row['tags']); // Split comma-separated tags
}
?>


    <main class="blog-main">
        <div class="blog-content">
            <!-- Blog Post -->
             <?php if (isset($blog)): ?>
        <!-- Display a specific blog post -->
        <div class="blog-post">
            <img src="contents/blog/<?php echo $blog['image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-image">
            <div class="post-content">
                <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                <p class="post-meta"><?php echo date("F j, Y", strtotime($blog['post_date'])); ?> | by <?php echo htmlspecialchars($blog['author']); ?></p>
                <div class="blog-excerpt">
                    <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
                </div>
            </div>
        </div>
    <?php elseif (!empty($where_clause)): ?>
        <!-- Display filtered blogs by category or tag -->
        <div class="filtered-blogs">
            <h2>
                <?php
                if (isset($_GET['category'])) {
                    echo "Blogs in Category: " . htmlspecialchars($_GET['category']);
                } elseif (isset($_GET['tag'])) {
                    echo "Blogs Tagged: " . htmlspecialchars($_GET['tag']);
                }
                ?>
            </h2>
            <div class="blog-grid">
                <?php while ($filtered_blog = $filtered_blogs_result->fetch_assoc()): ?>
                    <article class="blog-post">
                        <img src="contents/blog/<?php echo $filtered_blog['image']; ?>" alt="<?php echo htmlspecialchars($filtered_blog['title']); ?>" class="blog-image">
                        <div class="post-content">
                            <h3><?php echo htmlspecialchars($filtered_blog['title']); ?></h3>
                            <p class="post-meta"><?php echo date("F j, Y", strtotime($filtered_blog['post_date'])); ?> | by <?php echo htmlspecialchars($filtered_blog['author']); ?></p>
                            <p class="blog-excerpt"><?php echo htmlspecialchars($filtered_blog['excerpt']); ?></p>
                            <a href="post.php?id=<?php echo $filtered_blog['id']; ?>" class="read-more">Read More</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Display a message if no post or filter matches -->
        <div class="no-results">
            <h2>No blog posts found.</h2>
            <p>Try exploring different categories or tags.</p>
        </div>
    <?php endif; ?>

            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <!-- Categories Widget -->
                 <div class="sidebar-widget">
                <h3>Categories</h3>
                <ul class="blog-categories">
                    <?php foreach ($categories as $category): ?>
                        <li><a href="post.php?category=<?php echo urlencode($category); ?>"><?php echo htmlspecialchars($category); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

                <!-- Recent Posts Widget -->
                <div class="sidebar-widget">
                <h3>Recent Posts</h3>
                <ul class="recent-posts">
                    <?php
                    // Fetch recent posts
                    $recent_sql = "SELECT * FROM blogs ORDER BY post_date DESC LIMIT 5";
                    $recent_result = $con->query($recent_sql);
                    while ($recent_post = $recent_result->fetch_assoc()):
                    ?>
                        <li><a href="post.php?id=<?php echo $recent_post['id']; ?>"><?php echo htmlspecialchars($recent_post['title']); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>

                <!-- Tags Widget -->
                 <div class="sidebar-widget">
                <h3>Tags</h3>
                <div class="tag-cloud">
                    <?php foreach ($tags as $tag_group): ?>
                        <?php foreach ($tag_group as $tag): ?>
                            <a href="post.php?tag=<?php echo urlencode(trim($tag)); ?>"><?php echo htmlspecialchars(trim($tag)); ?></a>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            </aside>
        </div>
    </main>



   <?php include('footer.php');?>

    <script src="./js/script.js" defer></script>
</body>

</html>