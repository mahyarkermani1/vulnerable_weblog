
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true && isset($_SESSION['username'])) {
    header('Location: ../settings'); // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Page</title>
        <link rel="stylesheet" href="register.css">
        <link rel="stylesheet" href="/statics/index.css">
        <script src="/statics/functions.js"></script>
    </head>
    <body>

    <?php
    
    if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true) {
        
        include "../statics/header_index.php";
    } else {
        include "../statics/header.php";
    }
        
        include "register.html";
        include "../statics/footer.html";
    ?>
    </body>
</html>
    