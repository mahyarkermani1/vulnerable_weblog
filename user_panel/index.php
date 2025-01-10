
<?php
session_start();


if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['username'])) {
    header('Location: ../redirect'); // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Colorful Website</title>
</head>
<body>

<?php include "user_panel.php" ?>

</body>

</html>