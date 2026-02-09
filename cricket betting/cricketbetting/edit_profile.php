<!DOCTYPE html>
<?php
// Include your database connection and configuration file

function getUserProfile($userId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user profile information from the 'users' table
    $query = "SELECT username, email FROM users WHERE user_id = '$userId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $userProfile = $result->fetch_assoc();
    } else {
        $userProfile = null;
    }

    // Close the database connection
    $conn->close();

    return $userProfile;
}
?>
<?php
// Include your database connection and configuration file

function updateUserProfile($userId, $newUsername, $newEmail) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user inputs to prevent SQL injection
    $userId = $conn->real_escape_string($userId);
    $newUsername = $conn->real_escape_string($newUsername);
    $newEmail = $conn->real_escape_string($newEmail);

    // Query to update user profile information in the 'users' table
    $query = "UPDATE users SET username = '$newUsername', email = '$newEmail' WHERE user_id = '$userId'";

    $updateResult = $conn->query($query);

    // Close the database connection
    $conn->close();

    return $updateResult;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Edit Profile</h1>

            <?php
            // Include your database connection and configuration file

            // Check if the user is authenticated and their ID is available in the session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Check if the form has been submitted
                if (isset($_POST['submit'])) {
                    // Retrieve and sanitize the user's input
                    $newUsername = $_POST['new_username'];
                    $newEmail = $_POST['new_email'];

                    // Update user profile information in the database
                    $updateResult = updateUserProfile($userId, $newUsername, $newEmail); // Implement this function

                    if ($updateResult) {
                        echo '<p>Profile updated successfully.</p>';
                    } else {
                        echo '<p>Profile update failed.</p>';
                    }
                }

                // Get user profile information from the database
                $userProfile = getUserProfile($userId); // Implement this function

                if ($userProfile) {
                    echo '<form action="edit_profile.php" method="post">';
                    echo '<label for="new_username">New Username:</label>';
                    echo '<input type="text" id="new_username" name="new_username" value="' . $userProfile['username'] . '" required>';

                    echo '<label for="new_email">New Email:</label>';
                    echo '<input type="email" id="new_email" name="new_email" value="' . $userProfile['email'] . '" required>';

                    echo '<input type="submit" name="submit" value="Update Profile">';
                    echo '</form>';
                } else {
                    echo '<p>User profile not found.</p>';
                }
            } else {
                echo '<p>You must be logged in to edit your profile.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
