<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Include database connection
include '../db/db.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch full post content from the database
    $query = "SELECT p.post_id, p.title, p.content, p.author_id, p.publication_date, u.username
              FROM posts p
              JOIN users u ON p.author_id = u.user_id
                WHERE p.post_id = ?";


    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
} else {
    // Redirect if no ID is provided
    header('Location: posts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="posts.css">
    <link rel="stylesheet" href="/statics/index.css">
    <title><?php echo $post['title']; ?></title>
</head>
<body>
<?php include "../statics/header.php";?>
<div class="posts-wrapper">
    <div class="container">
    <?php if ($post): ?>
            <h2><?php echo htmlspecialchars($post['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <p>Posted by: <strong><?php echo htmlspecialchars($post['username']); ?></strong> on <?php echo date('F j, Y', strtotime($post['publication_date'])); ?></p>
            <a href="../" class="back-button">Back to Posts</a>
        <?php else: ?>
            <h2>No Post Found</h2>
            <a href="../" class="back-button">Back to Posts</a>
        <?php endif; ?>
    </div>
</div>
</body>

<?php include "../statics/footer.html";?>

</html>
