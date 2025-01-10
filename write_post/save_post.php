<?php


session_start();

include "../db/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $content = $_POST["content"];
    $author_id = $_SESSION["user_id"];
    $category_id = $_POST["category"];

    $stmt = $conn->prepare("INSERT INTO posts (title, content, author_id, category_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $author_id, $category_id); // Hash password before saving

    // Try to execute the statement
    try {
        if ($stmt->execute()) {
            // Successfully inserted, set cookies and redirect
            header("Location: ../my_posts");
            exit; // Always good to exit after a redirection
        }
    } catch (mysqli_sql_exception $e) {
        // Handle unexpected errors
        echo "<script>alert('An error occurred: " . $e->getMessage() . "'); window.history.go(-1);</script>";
    }

}

?>