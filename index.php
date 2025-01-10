
<?php

include "db/db.php";
session_start();




?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="my_posts/newest_posts.css">
        <title>Home Page</title>
        
    </head>
    <body>
        <?php include "my_posts/newest_posts.php";?>
    </body>
</html>
