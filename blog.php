<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="blog-container">
        <div class="blog-header">
            <h1>Our Blog</h1>
            <p>Discover natural remedies and insights for skin health</p>
        </div>

        <div class="blog-content">
            <main class="blog-posts">
                <?php include('connection.php');
                $where_clause = "1=1";
                $params = [];
                $types = "";

                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $where_clause .= " AND category = ?";
                    $params[] = $_GET['category'];
                    $types .= "s";
                }

                if (isset($_GET['tag']) && !empty($_GET['tag'])) {
                    $where_clause .= " AND tags LIKE ?";
                    $params[] = "%{$_GET['tag']}%";
                    $types .= "s";
                }

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $where_clause .= " AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ?)";
                    $search_term = "%{$_GET['search']}%";
                    $params[] = $search_term;
                    $params[] = $search_term;
                    $params[] = $search_term;
                    $types .= "sss";
                }

                $query = "SELECT * FROM blogs WHERE $where_clause ORDER BY post_date DESC LIMIT 5";
                $stmt = $con->prepare($query);

                if (!empty($params)) {
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0):
                    while ($blog = $result->fetch_assoc()):
                ?>
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="contents/blog/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="blog-category">
                                <i class="fas fa-folder"></i>
                                <?php echo htmlspecialchars($blog['category']); ?>
                            </span>
                            <span class="blog-date">
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M d, Y', strtotime($blog['post_date'])); ?>
                            </span>
                            <span class="blog-author">
                                <i class="fas fa-user"></i>
                                <?php echo htmlspecialchars($blog['author']); ?>
                            </span>
                        </div>
                        <h2 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                        <?php if (!empty($blog['subtitle'])): ?>
                            <h3 class="blog-subtitle"><?php echo htmlspecialchars($blog['subtitle']); ?></h3>
                        <?php endif; ?>
                        <p class="blog-excerpt"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                        <div class="blog-tags">
                            <?php
                            $tags = explode(',', $blog['tags']);
                            foreach ($tags as $tag):
                                $tag = trim($tag);
                            ?>
                            <a href="?tag=<?php echo urlencode($tag); ?>" class="tag">
                                <i class="fas fa-tag"></i>
                                <?php echo htmlspecialchars($tag); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <a href="blog_post.php?id=<?php echo $blog['id']; ?>" class="read-more">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                <?php 
                    endwhile;
                else:
                ?>
                <div class="no-posts">
                    <i class="fas fa-newspaper"></i>
                    <h2>No Posts Found</h2>
                    <p>We couldn't find any blog posts matching your criteria. Try adjusting your search or browse our categories.</p>
                </div>
                <?php
                endif;
                $stmt->close();
                ?>
            </main>

            <aside class="blog-sidebar">
                <div class="sidebar-widget search-widget">
                    <h3>Search Posts</h3>
                    <form action="" method="GET" class="search-form">
                        <div class="search-input">
                            <input type="text" name="search" placeholder="Search blogs..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="sidebar-widget categories-widget">
                    <h3>Categories</h3>
                    <ul class="category-list">
                        <?php
                        $categories_query = "SELECT DISTINCT category, COUNT(*) as count FROM blogs GROUP BY category ORDER BY category";
                        $categories_result = $con->query($categories_query);
                        while ($category = $categories_result->fetch_assoc()):
                            $active = isset($_GET['category']) && $_GET['category'] === $category['category'];
                        ?>
                        <li class="<?php echo $active ? 'active' : ''; ?>">
                            <a href="?category=<?php echo urlencode($category['category']); ?>">
                                <?php echo htmlspecialchars($category['category']); ?>
                                <span class="count"><?php echo $category['count']; ?></span>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <div class="sidebar-widget tags-widget">
                    <h3>Popular Tags</h3>
                    <div class="tag-cloud">
                        <?php
                        $tags_query = "SELECT tags FROM blogs";
                        $tags_result = $con->query($tags_query);
                        $tag_counts = [];
                        
                        while ($row = $tags_result->fetch_assoc()) {
                            $post_tags = explode(',', $row['tags']);
                            foreach ($post_tags as $tag) {
                                $tag = trim($tag);
                                if (!empty($tag)) {
                                    $tag_counts[$tag] = isset($tag_counts[$tag]) ? $tag_counts[$tag] + 1 : 1;
                                }
                            }
                        }
                        
                        arsort($tag_counts);
                        $top_tags = array_slice($tag_counts, 0, 15, true);
                        
                        foreach ($top_tags as $tag => $count):
                            $active = isset($_GET['tag']) && $_GET['tag'] === $tag;
                        ?>
                        <a href="?tag=<?php echo urlencode($tag); ?>" class="tag <?php echo $active ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($tag); ?>
                            <span class="count"><?php echo $count; ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <?php include 'footer.php'; ?>

<style>
.blog-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.blog-header {
    text-align: center;
    margin-bottom: 40px;
}

.blog-header h1 {
    font-family: var(--font-heading);
    font-size: 2.5rem;
    color: var(--text-color);
    margin-bottom: 10px;
}

.blog-header p {
    color: #666;
    font-size: 1.1rem;
}

.blog-content {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
}

.blog-posts {
    display: grid;
    gap: 30px;
}

.blog-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
}

.blog-image {
    height: 250px;
    overflow: hidden;
}

.blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-image img {
    transform: scale(1.05);
}

.blog-content {
    padding: 25px;
}

.blog-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.blog-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.blog-meta i {
    color: var(--green-bg-color);
}

.blog-title {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    color: var(--text-color);
    margin-bottom: 10px;
}

.blog-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 15px;
}

.blog-excerpt {
    color: #444;
    line-height: 1.6;
    margin-bottom: 20px;
}

.blog-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    background: #f8f9fa;
    color: #495057;
    border-radius: 20px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.tag i {
    color: var(--green-bg-color);
}

.tag:hover {
    background: var(--green-bg-color);
    color: white;
}

.tag:hover i {
    color: white;
}

.tag.active {
    background: var(--green-bg-color);
    color: white;
}

.tag.active i {
    color: white;
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green-bg-color);
    text-decoration: none;
    font-weight: 500;
    transition: gap 0.3s ease;
}

.read-more:hover {
    gap: 12px;
}

.blog-sidebar {
    position: sticky;
    top: 20px;
    align-self: start;
}

.sidebar-widget {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.sidebar-widget h3 {
    font-family: var(--font-heading);
    font-size: 1.3rem;
    color: var(--text-color);
    margin-bottom: 20px;
}

.search-input {
    position: relative;
}

.search-input input {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input input:focus {
    outline: none;
    border-color: var(--green-bg-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.search-input button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    padding: 10px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.search-input button:hover {
    color: var(--green-bg-color);
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    margin-bottom: 10px;
}

.category-list li:last-child {
    margin-bottom: 0;
}

.category-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background: #f8f9fa;
    color: #444;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.category-list a:hover {
    background: var(--green-bg-color);
    color: white;
}

.category-list .active a {
    background: var(--green-bg-color);
    color: white;
}

.count {
    background: rgba(0, 0, 0, 0.1);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.no-posts {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.no-posts i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 20px;
}

.no-posts h2 {
    font-family: var(--font-heading);
    font-size: 1.8rem;
    color: var(--text-color);
    margin-bottom: 10px;
}

.no-posts p {
    color: #666;
    max-width: 500px;
    margin: 0 auto;
}

@media (max-width: 1024px) {
    .blog-content {
        grid-template-columns: 1fr;
    }

    .blog-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .blog-header h1 {
        font-size: 2rem;
    }

    .blog-image {
        height: 200px;
    }

    .blog-meta {
        flex-wrap: wrap;
        gap: 10px;
    }

    .blog-title {
        font-size: 1.3rem;
    }
}

@media (max-width: 480px) {
    .blog-container {
        margin: 20px auto;
    }

    .blog-header {
        margin-bottom: 20px;
    }

    .blog-posts {
        gap: 20px;
    }

    .blog-content {
        padding: 20px;
    }
}
</style>

</body>
</html>