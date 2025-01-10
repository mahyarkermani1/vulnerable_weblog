<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] !== true || !isset($_SESSION['username'])) {
    header('Location: ../redirect'); // Redirect to login page if not logged in
    exit;
}

// Connect to your database
include "../db/db.php";
// Initialize variables for user data
$username = $email = $first_name = $last_name = $bio = '';

// Fetch user data from the database
if ($stmt = $conn->prepare("SELECT username, email, first_name, last_name, bio FROM users WHERE username = ?")) {
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($username, $email, $first_name, $last_name, $bio);
    $stmt->fetch();
    $stmt->close();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and assign posted values
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $bio = trim($_POST['bio']);
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Declare a variable to hold error messages
    $error = '';

    // Check for duplicates in username and email
    if ($new_username !== $username) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $error .= "Username already exists \\n";
        }
    }

    if ($new_email !== $email) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $new_email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $error .= "Email already exists";
        }
    }

    // If no errors, proceed to update data
    if (empty($error)) {
        if ($stmt = $conn->prepare("UPDATE users SET username=?, email=?, first_name=?, last_name=?, bio=? WHERE username=?")) {
            $stmt->bind_param("ssssss", $new_username, $new_email, $first_name, $last_name, $bio, $_SESSION['username']);
            $stmt->execute();

            // Check if the password fields were filled
            if (!empty($new_password) && $new_password === $confirm_password) {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password=? WHERE username=?");
                $stmt->bind_param("ss", $hashed_password, $new_username);
                $stmt->execute();
            }

            // Update session variable
            $_SESSION['username'] = $new_username;
            // Redirect or display a success message
            echo "<script>alert('Settings updated successfully!');</script>";
        }
    } else {
        // Display error messages
        echo "<script>alert('{$error}');</script>";
    }
}
$conn->close();
?>

<?php include "../statics/header.php" ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="settings.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="../statics/index.css">
    <script src="../statics/functions.js"></script>

    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return false;
            }
            return true;
        }

        function clearForm() {
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('first_name').value = '';
            document.getElementById('last_name').value = '';
            document.getElementById('bio').value = '';
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
    }


    </script>
</head>
<body>
    

    <div class="login-wrapper">
        <div class="container">
            <h2>User Settings</h2>
            <form action="" method="POST" id="settingsForm" onsubmit="return validatePassword();">
                <div class="form-group">
                    <img class="circle-image" src="<?php echo $imagePath; ?>" width="100" height="100"><br>
                </div>

                <div class="form-group">
                    <div class="upload-container">
                        <input type="file" id="imageInput" accept="image/.jpg,.jpeg,.png">
                        <p id="uploadStatus"></p>
                        <progress id="uploadProgress" value="0" max="100" style="display: none;"></progress>
                        
                    </div>
                </div> 

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                </div>
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($bio); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
                <div class="button-group">
                    <button type="submit">Update</button>
                    <button type="button" id="clearButton" onclick="clearForm();">Clear</button>
                </div>

            </form>
        </div>
    </div>
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="image_handle.js"></script>

    
    <script>filter_image();</script>

</script>

    
</body>
</html>

<?php include "../statics/footer.html" ?>

