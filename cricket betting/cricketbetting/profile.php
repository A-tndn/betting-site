<?php
// Start a PHP session to manage user authentication
session_start();
include('db.php');
include_once('config.php');


// Check if the user is authenticated (you should replace this with your actual authentication logic)
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header('Location: login.php');
    exit();
}


?>
<?php
// Include your database connection and configuration file

function getUserProfile($userId) {
    global $mysqli; // Add this line to access the database connection

    // Initialize an array to store user profile information
    $userProfile = array();

    // Establish a MySQL database connection

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to retrieve user profile information
    $sql = "SELECT username, email, balance FROM users WHERE user_id = $userId";

    $result = $mysqli->query($sql);

    if ($result->num_rows == 1) {
        // Fetch the user's profile data
        $row = $result->fetch_assoc();

        $userProfile['username'] = $row['username'];
        $userProfile['email'] = $row['email'];
        $userProfile['balance'] = $row['balance'];
    }

    // Close the database connection
    $mysqli->close();

    return $userProfile;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Profile - Cricket Betting App</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <!-- Include the header template to maintain consistency -->
        <?php include('header.php'); ?>
    </header>

    <main>
        <div class="container">
            <h1>Your Profile</h1>

            <?php
            // Retrieve and display the user's profile information from the database
            $userProfile = getUserProfile($_SESSION['user_id']); // Implement this function
            ?>

            <form method="post" action="update_profile.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $userProfile['username']; ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $userProfile['email']; ?>" readonly>

                <label for="balance">Account Balance:</label>
                <input type="text" id="balance" name="balance" value="$<?php echo $userProfile['balance']; ?>" readonly>

                <button type="button" id="editProfileButton">Edit Profile</button>
                <button type="submit" id="saveProfileButton" style="display: none;">Save Changes</button>
            </form>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
