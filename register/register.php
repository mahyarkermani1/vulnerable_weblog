<?php



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../db/db.php";

    session_start();
    session_regenerate_id(true);

    // Escape inputs to prevent SQL injection
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Initialize an array to store any error messages
    $errorMessages = [];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $errorMessages[] = 'Username is already taken.';
    }

    // Check if the email already exists
    $stmt->close(); // Close the previous statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errorMessages[] = 'Email is already taken.';
    }

    // If there are any error messages, display them and stop execution
    if (!empty($errorMessages)) {
        $message = implode('\n', $errorMessages);
        echo "<script>alert('$message'); window.history.go(-1);</script>";
        exit; // Prevent further execution
    }

    // Now try to insert the new user since there are no duplicates
    $stmt->close(); // Close the previous statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, password_hash($password, PASSWORD_DEFAULT), $email); // Hash password before saving

    // Try to execute the statement
    try {
        if ($stmt->execute()) {

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $user_id = $row['user_id'];

                // Successfully inserted, set cookies and redirect
                $_SESSION["user_id"] = $user_id;
                $_SESSION["is_logged"] = true;
                $_SESSION["username"] = $username;
                header("Location: ../user_panel");
                exit; // Always good to exit after a redirection
            }



        }
    } catch (mysqli_sql_exception $e) {
        // Handle unexpected errors
        echo "<script>alert('An error occurred: " . $e->getMessage() . "'); window.history.go(-1);</script>";
    }

    // Close statement
    $stmt->close();
}
?>


<script>
    const sessionUsername = '<?php echo $username; ?>'; // Pass username to JavaScript
</script>