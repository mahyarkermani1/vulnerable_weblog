

<?php




include "../db/db.php";




$stmt = $conn->prepare("SELECT * FROM users");

$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);

}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="/statics/index.css">
    <link rel="stylesheet" href="/login/login.css">
</head>
<body>

<?php include "../statics/header_admin.php"; ?>


<main>
    <?php foreach ($rows as $row): ?>
    <section>
    <h2><a href="."><?php echo $row['username']; ?></a></h2>
    <button type="button" onclick="redirect('detail_users.php?operation=detail&user_id=<?php echo $row['user_id']; ?>');">Detail</button>
    <button type="button" onclick="#">Edit</button>
    <button type="button" onclick="redirect('detail_users.php?operation=delete&user_id=<?php echo $row['user_id']; ?>');">Delete</button>
    </section>
    <?php endforeach; ?>

</main>

<script>
        function redirect(url) {
            window.location.href = url; // Change to your desired URL
        }
    </script>

<?php include "../statics/footer.html";?>


</body>

</html>