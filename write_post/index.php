<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['username'])) {
    header('Location: ../redirect'); // Redirect to login page if not logged in
    exit;
}

include "../db/db.php";

// Prepare the SQL statement to get the user's password
$stmt = $conn->prepare("SELECT category_id, category_name FROM categories");

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if the username exists
if ($result) {
    $data_category = $result->fetch_all();
}


?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Post</title>
    <link rel=></link>
    <link rel="stylesheet" href="./write_post.css"></link>
    <link rel="stylesheet" href="/statics/index.css">
</head>
<body>

<?php
include "../statics/header.php";
include "./write_post.php";
include "../statics/footer.html";

?>

</body>

</html>
