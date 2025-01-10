<?php
include "../statics/header.php";

// Redirect if the token is missing or empty
if (empty($_GET['token'])) {
    header('Location: ../forget_password');
    exit();
}

// If token is present, display the reset password form 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forget_password.css">
    <link rel="stylesheet" href="../statics/index.css">
    <title>Reset Password</title>
    <script>
        function validateForm(event) {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (newPassword !== confirmPassword) {
                alert("Passwords do not match.");
                event.preventDefault(); // Prevent form submission
            }
        }
    </script>
</head>
<body>
    
    <div class="login-wrapper">
        <div class="container">
            <h2>Create New Password</h2>
            <form action="update_password.php" method="POST" id="updatePasswordForm" onsubmit="validateForm(event);">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Reset My Password</button>
            </form>
            <button type="button" class="additional-button" onclick="window.location.href='forget_password.html';">Back to Forgot Password</button>
        </div>
    </div>
    
</body>
</html>

<?php include "../statics/footer.html"; ?>
