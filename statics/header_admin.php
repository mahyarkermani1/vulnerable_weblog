
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username_admin = $_SERVER['PHP_AUTH_USER'];
?>




<header>
    <h1>Welcome To the Mahyar's Website</h1>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="all_users.php">All Users</a></li>
            <li><a href="download_db_bk.php">Database Backup</a></li>
        </ul>
    </nav>

</header>

