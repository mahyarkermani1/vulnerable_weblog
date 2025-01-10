


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/statics/index.css">
        <title>Home Page</title>
        
    </head>
    <body>
        <?php
            include "../statics/header_admin.php";
            echo "<h2 style='text-align: center'>Welcome " . $username_admin . " :)</h2>";
            include "../statics/footer.html";
    ?>

        
    </body>
</html>
