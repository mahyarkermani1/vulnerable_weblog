<?php



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    session_start();
    session_regenerate_id(true);

    include "../db/db.php";

    // Use prepared statements to avoid SQL injection
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to get the user's password
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind parameter

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username exists
    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set cookies for the user
            $_SESSION['user_id'] = $user_id;
            $_SESSION["is_logged"] = true;
            $_SESSION["username"] = $username;


            // Redirect to a welcome page or dashboard (not provided here)
            header("Location: ../");
            exit; // Good practice to exit after a redirection
        } else {
            // Show an alert if the password is wrong
            echo "<script>alert('username or password is wrong'); window.history.go(-1);</script>";
        }
    } else {
        // Show an alert if the username does not exist
        echo "<script>alert('username or password is wrong');window.history.go(-1)</script>";

    }

    // Close statement
    $stmt->close();
}
?>


<script>
    const sessionUsername = '<?php echo $username; ?>'; // Pass username to JavaScript
</script>




<!-- <?php



// Check if the form was submitted
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     include "../db/db.php";

//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

//     $result = mysqli_query($conn, $sql);

//     // Check if the credentials match

//     if ($result && mysqli_num_rows($result) == 1) {
//         $row = mysqli_fetch_assoc($result);
//         // Set cookies for the user
//         setcookie('is_logged', 'true', time() + (86400 * 30), "/"); // Cookie valid for 30 days
//         setcookie('username', $row["username"], time() + (86400 * 30), "/"); // Cookie valid for 30 days

//         // Redirect to a welcome page or dashboard (not provided here)
//         header("Location: ../");

//     } else {
//         // Show an alert if credentials are wrong
//         echo "<script>alert('Username or password is wrong'); window.history.go(-1);</script>";

//     }
// }
?> -->