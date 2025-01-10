<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['username'])) {
    header('Location: ../redirect'); // Redirect to login page if not logged in
    exit;
}

// Include database connection
include '../db/db.php';

// Make sure to start the session to get the logged-in user
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session.

// Fetch user's posts from the database
$query = "SELECT p.post_id, p.title, p.content, p.author_id, p.category_id, p.publication_date, u.username, c.category_name
          FROM posts p
          JOIN users u ON p.author_id = u.user_id
          JOIN categories c ON p.category_id = c.category_id
          WHERE p.author_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="posts.css">
    <link rel="stylesheet" href="/statics/index.css">
    <title>Your Posts</title>
</head>
<body>
<?php include "../statics/header.php";?>
<div class="posts-wrapper">
    <div class="container">
        <h2>Your Posts</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <h3 class="post-title"><?php echo $row['title']; ?></h3>
                <p class="post-excerpt"><?php echo substr($row['content'], 0, 50); ?>...</p>
                <div class="post-info">
                    <span class="post-username"><?php echo $row['username']; ?></span>
                    <span class="post-date"><?php echo date('F j, Y', strtotime($row['publication_date'])); ?></span>
                    <span class="post-category"><?php echo $row['category_name']; ?></span>
                    <a href="show_content.php?id=<?php echo $row['post_id']; ?>" class="read-more">Read More</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include "../statics/footer.html";?>

</body>
</html>
