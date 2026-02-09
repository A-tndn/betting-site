<?php
include('db.php');
include_once('config.php');


// Include your configuration, database connection, and authentication checks here

// Retrieve the user's profile information from the database based on their user ID
// You should implement a getUserProfile function to fetch this data
session_start();

$userProfile = getUserProfile($_SESSION['user_id']);

// Include the header template
function getUserProfile($userId) {
    global $mysqli; // Assuming $conn is your database connection

    // Sanitize the user ID to prevent SQL injection
    $userId = $mysqli->real_escape_string($userId);

    // Query to retrieve the user's profile data from the database (replace 'users' with your actual table name)
    $query = "SELECT username, email FROM users WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        // Fetch the user's profile data as an associative array
        $userProfile = $result->fetch_assoc();

        // Close the result set
       // $result->close();

        return $userProfile;
    } else {
        // User not found or an error occurred
        return false;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile - Cricket Betting App</title>
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
            <h1>My Profile</h1>

            <div class="profile-info">
                <p><strong>Username:</strong> <?php echo $userProfile['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $userProfile['email']; ?></p>
                <!-- Include additional profile details here -->
            </div>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
