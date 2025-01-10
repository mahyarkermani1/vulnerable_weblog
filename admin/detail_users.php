<?php
include "../db/db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (array_key_exists('operation', $_GET)) {
    $op = $_GET['operation'];

    if ($op == "detail" and array_key_exists('user_id', $_GET)) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $_GET['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result || $result->num_rows == 1) {
            $row = $result->fetch_assoc();

        }
    }

    
    elseif ($op == "delete" and array_key_exists('user_id', $_GET)) {

            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->bind_param("s", $_GET['user_id']);
            $stmt->execute();


            header("Location: ./all_users.php");
            exit();
    
        }

}



?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User <?php echo $row['username']; ?></title>
    <link rel="stylesheet" href="/statics/index.css">
    <link rel="stylesheet" href="/login/login.css">
</head>
<body>

<?php include "../statics/header_admin.php"; ?>


<main>
<section>
    <h2><a href="."><?php echo $row['username']; ?></a></h2>

    <div class="item-row">
        <h3>User ID:</h3>
        <h4><?php echo $row['user_id']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Username:</h3>
        <h4><?php echo $row['username']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Email:</h3>
        <h4><?php echo $row['email']; ?></h4>
    </div>
    <div class="item-row">
        <h3>First Name:</h3>
        <h4><?php echo $row['first_name']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Bio:</h3>
        <h4><?php echo $row['bio']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Password:</h3>
        <h4><?php echo $row['password']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Token Expires:</h3>
        <h4><?php echo $row['token']; ?></h4>
    </div>
    <div class="item-row">
        <h3>User ID:</h3>
        <h4><?php echo $row['token_expires']; ?></h4>
    </div>
    <div class="item-row">
        <h3>Registration Date:</h3>
        <h4><?php echo $row['registration_date']; ?></h4>
    </div>

    <button type="button" onclick="redirect('./all_users.php');">Back To The All Users</button>
</section>


</main>


<style>

section {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center items within the section */
}

.item-row {
    display: flex; /* Use flex to align h3 and h4 in a row */
    align-items: center; /* Vertically center the h3 and h4 */
}

.item-row h3 {
    margin-right: 10px; /* Spacing between h3 and h4 */
}


</style>

<script>
        function redirect(url) {
            window.location.href = url; // Change to your desired URL
        }
    </script>

<?php include "../statics/footer.html";?>


</body>

</html>