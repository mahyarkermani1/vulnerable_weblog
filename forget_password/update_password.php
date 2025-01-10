<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include "../db/db.php";
    echo '<script src="/statics/functions.js"></script>';

    $new_password = $_POST['new_password'];
    $token = $_POST['token'];

    // Validate token and check expiration
    $query = $conn->prepare("SELECT * FROM users WHERE token = ? AND token_expires > UTC_TIMESTAMP()");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password and remove token
        $updateQuery = $conn->prepare("UPDATE users SET password = ?, token = NULL, token_expires = NULL WHERE token = ?");
        $updateQuery->bind_param("ss", $hashed_password, $token);
        $updateQuery->execute();

        echo "<script>alert('Your password has been reset successfully.')</script>";
        echo '
        <script type="text/javascript">
            redirectTo("../login");
        </script>
        ';
    } else {
        echo "<script>alert('Invalid or expired token.'); window.history.go(-1);</script>";
    }
    
    $conn->close();
}
?>
