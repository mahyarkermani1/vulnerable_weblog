<?php
// Assuming session and database connection is already established.

// Fetch the latest posts from the database

$dateFilter = null;

if (array_key_exists("date", $_GET)) {
    // Convert the incoming date (e.g., "October 27, 2024") to a format that can be used for SQL query
    $dateFilter = date('Y-m-d', strtotime($_GET["date"])); // Converts to YYYY-MM-DD
}


if (array_key_exists("author_id", $_GET)) {
    include "../db/db.php";
    $queryNew = "SELECT p.post_id, p.title, p.content, p.author_id, p.category_id, p.publication_date, u.username, c.category_name
    FROM posts p
    JOIN users u ON p.author_id = u.user_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.author_id = ?"; // Fetch the 5 most recent posts
    
    $stmtNew = $conn->prepare($queryNew);
    $stmtNew->bind_param("s", $_GET["author_id"]);
    $stmtNew->execute();
    $resultNew = $stmtNew->get_result();

} elseif (array_key_exists("category_id", $_GET)) {
    include "../db/db.php";
    $queryNew = "SELECT p.post_id, p.title, p.content, p.author_id, p.category_id, p.publication_date, u.username, c.category_name
    FROM posts p
    JOIN users u ON p.author_id = u.user_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.category_id = ?"; // Fetch the 5 most recent posts
    
    $stmtNew = $conn->prepare($queryNew);
    $stmtNew->bind_param("s", $_GET["category_id"]);
    $stmtNew->execute();
    $resultNew = $stmtNew->get_result();

}

else {
    
    // Prepare the base query
    $queryNew = "SELECT p.post_id, p.title, p.content, p.author_id, p.category_id, p.publication_date, u.username, c.category_name 
                 FROM posts p 
                 JOIN users u ON p.author_id = u.user_id 
                 JOIN categories c ON p.category_id = c.category_id";
    
    if ($dateFilter) {
        include "../db/db.php";
        $queryNew .= " WHERE DATE(p.publication_date) = ?";
        $stmtNew = $conn->prepare($queryNew);
        $stmtNew->bind_param("s", $dateFilter);
    } else {
        $queryNew .= " ORDER BY p.publication_date DESC LIMIT 5"; // Fetch the 5 most recent posts
        $stmtNew = $conn->prepare($queryNew);
    }

    $stmtNew->execute();
    $resultNew = $stmtNew->get_result();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./newest_posts.css">
    <link rel="stylesheet" href="../statics/index.css">
    <title>Newest Posts</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/statics/header_index.php";?>

<div class="newest-posts-wrapper">
    <div class="container">
        <h2>Newest Articles</h2>
        <?php while ($rowNew = $resultNew->fetch_assoc()): ?>
            <div class="post">
                <h3 class="post-title"><?php echo $rowNew['title']; ?></h3>
                <p class="post-excerpt"><?php echo substr($rowNew['content'], 0, 50); ?>...</p>
                <div class="post-info">
                    <span class="post-username"><a href="/my_posts/newest_posts.php?author_id=<?php echo $rowNew['author_id']; ?>"><?php echo $rowNew['username']; ?></a></span>
                    <span class="post-date"><a href="/my_posts/newest_posts.php?date=<?php echo urlencode(date('F j, Y', strtotime($rowNew['publication_date']))); ?>"><?php echo date('F j, Y', strtotime($rowNew['publication_date'])); ?></a></span>
                    <span class="post-category"><a href="/my_posts/newest_posts.php?category_id=<?php echo $rowNew['category_id']; ?>"><?php echo $rowNew['category_name']; ?></span>
                    <a href="/my_posts/show_content_all.php?id=<?php echo $rowNew['post_id']; ?>" class="read-more">Read More</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/statics/footer.html";?>

</body>
</html>
