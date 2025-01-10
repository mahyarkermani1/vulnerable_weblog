
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getUserProfileImage($username) {
    $usernameHash = md5($username);
    $uploads_dir = __DIR__ . '/../statics/images/';

    $pngImagePath =  $uploads_dir . $usernameHash . '.png';
    $jpgImagePath = $uploads_dir . $usernameHash . '.jpg';
    $jpegImagePath = $uploads_dir . $usernameHash . '.jpeg';

    // Check if image exists
    if (file_exists($pngImagePath)) {
        return ['type' => 'image/png', 'path' => '/statics/images/' . $usernameHash . '.png'];
    } elseif (file_exists($jpgImagePath)) {
        return ['type' => 'image/jpeg', 'path' => '/statics/images/' . $usernameHash . '.jpg'];
    } elseif (file_exists($jpegImagePath)) {
        return ['type' => 'image/jpeg', 'path' => '/statics/images/' . $usernameHash . '.jpeg'];
    }


    return null; // Return null if the images don't exist
}

function getDefaultProfileImage() {
    return ['type' => 'image/png', 'path' => '/statics/images/default_profile.png'];
}

// Attempting to get user profile image or default image
$imageData = isset($_SESSION['username']) ? getUserProfileImage($_SESSION['username']) : getDefaultProfileImage();

// Check if user image data is null and fallback to default if necessary
if ($imageData === null) {
    $imageData = getDefaultProfileImage();
}

$imageType = $imageData['type'];
$imagePath = $imageData['path'];
?>




<header>
    <h1>Welcome To the Mahyar's Website</h1>
    <nav>
        <ul>
        <li class="profile-pic-container">

                <img class="profile-pic" src="<?php echo $imagePath; ?>" width="50" height="50">
            </li>
            <li><a href="/">Home</a></li>
            <li><a href="../user_panel/">Panel</a></li>
            <li><a href="../write_post">Write</a></li>
            <li><a href="../my_posts">My Posts</a></li>
            <li><a href="../settings">Settings</a></li>
            <li><a id="logout" href="../statics/logout.php">Logout <?php if (isset($_SESSION['username'])) echo "( " . $_SESSION['username'] . " )"; ?> </a></li>


        </ul>
    </nav>

    <style>
        .profile-pic {
            border-radius: 50%; /* This will make the image circular */
            object-fit: cover; /* Ensures the image covers the entire area */
        }
    </style>

</header>

