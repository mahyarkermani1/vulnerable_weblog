<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forget Password</title>
</head>
<body>
    <div class="login-wrapper">
        <div class="container">
            <h2>Reset Password</h2>
            <form action="send_reset_link.php" method="POST" id="resetRequestForm">
                <div class="form-group">
                    <label for="identifier">Username or Email:</label>
                    <input type="text" id="identifier" name="identifier" value="" required>
                </div>
                <button type="submit">Send Code</button>
                <button type="button" class="additional-button" onclick="redirectTo('../login');">Back to Login</button>
            </form>
        </div>
    </div>
</body>
</html>
