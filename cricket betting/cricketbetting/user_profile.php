<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>
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
    $query = "SELECT username, email, balance FROM users WHERE user_id = '$userId'";

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

    <main>
        <div class="container">
            <h1>User Profile</h1>

            <?php
            // Include your database connection and configuration file

            // Check if the user is authenticated and their ID is available in the session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Get user profile information from the database
                $userProfile = getUserProfile($userId); // Implement this function

                if ($userProfile) {
                    echo '<h2>Welcome, ' . $userProfile['username'] . '</h2>';
                    echo '<p>Email: ' . $userProfile['email'] . '</p>';
                    echo '<p>Balance: $' . $userProfile['balance'] . '</p>';

                    // Include an option to edit the user profile
                    echo '<a href="edit_profile.php">Edit Profile</a>';
                } else {
                    echo '<p>User profile not found.</p>';
                }
            } else {
                echo '<p>You must be logged in to view your profile.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
