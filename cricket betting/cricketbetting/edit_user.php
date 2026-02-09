<?php
// Include your database connection and configuration file

function getUserDetails($userId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user details
    $query = "SELECT user_id, username, email FROM users WHERE user_id = '$userId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Close the database connection
        $conn->close();

        return $user;
    }

    // Close the database connection
    $conn->close();

    return false; // User not found
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Cricket Betting Admin Panel</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php include('admin_header.php'); ?>

    <main>
        <div class="container">
            <h1>Edit User</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($isAdmin) {
                // Include your database connection and configuration file

                // Check if a user ID is provided in the query string
                if (isset($_GET['id'])) {
                    $userId = $_GET['id'];

                    // Retrieve user details from the database
                    $user = getUserDetails($userId); // Implement this function

                    if ($user) {
                        // Display a form to edit user details
                        echo '<form action="update_user.php" method="post">';
                        echo '<input type="hidden" name="user_id" value="' . $user['user_id'] . '">';
                        echo '<label for="username">Username:</label>';
                        echo '<input type="text" name="username" value="' . $user['username'] . '">';
                        echo '<label for="email">Email:</label>';
                        echo '<input type="text" name="email" value="' . $user['email'] . '">';
                        echo '<button type="submit">Update User</button>';
                        echo '</form>';
                    } else {
                        echo '<p>User not found.</p>';
                    }
                } else {
                    echo '<p>No user ID provided.</p>';
                }
            } else {
                echo '<p>You do not have admin privileges to access this page.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
