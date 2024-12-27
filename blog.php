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
</head>

<body>
   <?php include 'header.php';?>



<?php
// Database connection
include('connection.php');




// Check if a category is selected via the URL
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Check if a tag is selected via the URL
$tag_filter = isset($_GET['tag']) ? $_GET['tag'] : '';

// Check if a search term is entered
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Base query for fetching blogs
$sql = "SELECT * FROM blogs WHERE 1";

// Apply category filter
if ($category_filter) {
    $sql .= " AND category = '$category_filter'";
}

// Apply tag filter (assuming tags are stored as comma-separated values)
if ($tag_filter) {
    $sql .= " AND FIND_IN_SET('$tag_filter', tags) > 0";
}


// Apply search term filter
if ($search_term) {
    $sql .= " AND (title LIKE '%$search_term%' OR excerpt LIKE '%$search_term%')";
}

// Order the results by post date
$sql .= " ORDER BY post_date DESC";

// Execute the query
$result = $con->query($sql);
$blogs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
} else {
    echo "No blog posts found for this filter.";
}

// Fetch categories for sidebar
$category_sql = "SELECT DISTINCT category FROM blogs";
$category_result = $con->query($category_sql);
$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Fetch tags for sidebar
$tag_sql = "SELECT DISTINCT tags FROM blogs";
$tag_result = $con->query($tag_sql);
$tags = [];
while ($row = $tag_result->fetch_assoc()) {
    $tags[] = explode(',', $row['tags']);  // Split comma-separated tags
}

?>









     <main class="blog-main">
        <h1 class="blog-title">Neutralise Naturals Blog</h1>
        <p class="blog-subtitle">Natural Solutions for Chronic Skin Conditions</p>

        <div class="blog-content">
            <div class="blog-grid">
                <?php foreach ($blogs as $blog): ?>
                <article class="blog-post<?php echo $blog['category'] == 'Psoriasis' ? ' featured-post' : ''; ?>">
                    <img src="contents/blog/<?php echo $blog['image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-image">
                    <div class="post-content">
                        <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                        <p class="post-meta"><?php echo date("F j, Y", strtotime($blog['post_date'])); ?> | by <?php echo htmlspecialchars($blog['author']); ?></p>
                        <p class="blog-excerpt"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                        <a href="post.php?id=<?php echo $blog['id']; ?>" class="read-more">Read More</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <aside class="blog-sidebar">
                <!-- Search Widget -->
                <div class="search-widget">
            <h3>Search</h3>
            <form class="search-form" method="GET" action="">
                <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

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
                        <?php foreach ($blogs as $blog): ?>
                        <li><a href="post.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a></li>
                        <?php endforeach; ?>
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