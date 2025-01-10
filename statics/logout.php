<?php

session_start();

if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['username'])) {
    header('Location: ../redirect'); // Redirect to login page if not logged in
    exit;
}


$_SESSION = array();
session_destroy();
header("Location: /");
exit;
?>