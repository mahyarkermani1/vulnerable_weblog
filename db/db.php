<?php

$db_servername = "localhost";
$db_username = "mahyar";
$db_password = "mahyar123";
$db_database = "weblog_mahyar";


$conn = new mysqli($db_servername, $db_username, $db_password, $db_database);


if ($conn->connect_error) {
    die("Connection to the database failed: " . $conn->connect_error);
}


?>