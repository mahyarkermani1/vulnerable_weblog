<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploads_dir = '../statics/images';
        
        
        $tmp_name = $_FILES['image']['tmp_name'];
        
        $name_org = $_FILES['image']['name'];
        $nam_ext = pathinfo($name_org, PATHINFO_EXTENSION);

        $name_output = md5($_SESSION["username"]) . "." . $nam_ext;

        $upload_file = "$uploads_dir/$name_output";

        if (move_uploaded_file($tmp_name, $upload_file)) {
            echo "File uploaded successfully: " . $name_org;
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or there was an error.";
    }
} else {
    echo "Invalid request.";
}
?>
