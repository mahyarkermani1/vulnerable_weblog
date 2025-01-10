<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include "../db/db.php";
    echo '<script src="/statics/functions.js"></script>';

    $identifier = $_POST['identifier'];
    
    // Check if identifier is an email
    $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $query = $conn->prepare("SELECT * FROM users WHERE $field = ?");
    $query->bind_param("s", $identifier);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if the user has a valid token
        date_default_timezone_set('UTC');
        $current_time = date('Y-m-d H:i:s');
        if (!empty($user['token']) && $user['token_expires'] > $current_time) {
            echo "<script>alert('We recently sent you the password recovery link.\\nCheck your email or try again in a few minutes.'); window.history.go(-1);</script>";
        } else {
            // Create a reset password link
            $random_string = $user['username'] . date('Y/m/d H:i:s') . uniqid();
            $token = md5($random_string);
            
            // Set token expiration time (10 minutes from now)
            
            $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Store token and expiration time in the database
            $updateQuery = $conn->prepare("UPDATE users SET token = ?, token_expires = ? WHERE user_id = ?");
            $updateQuery->bind_param("ssi", $token, $expires_at, $user['user_id']);
            $updateQuery->execute();

            // Send reset password email (example)
            echo "<script>console.log('http://" . $_SERVER['SERVER_NAME'] . "/forget_password/reset_password.php?token=$token');</script>";
            echo "<script>alert('Reset link has been sent to your email.')</script>";
            echo '
            <script type="text/javascript">
                redirectTo("../login");
            </script>
            ';
        }
    } else {
        echo "<script>alert('No user found with that username or email.'); window.history.go(-1);</script>";
    }
    
    $conn->close();
}
?>
