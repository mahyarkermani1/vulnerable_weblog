<?php

include "../db/db.php";
include "./DatabaseBackup.php";

new DatabaseBackup($db_username, $db_password, $db_database, "db_bk/")

?>