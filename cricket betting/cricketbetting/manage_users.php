<?php
// Include your database connection and configuration file

function getUsers() {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve the list of users
    $query = "SELECT user_id, username, email FROM users";

    $result = $conn->query($query);

    $users = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = array(
                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'email' => $row['email']
            );
        }
    }

    // Close the database connection
    $conn->close();

    return $users;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Cricket Betting Admin Panel</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php include('admin_header.php'); ?>

    <main>
        <div class="container">
            <h1>Manage Users</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($isAdmin) {
                // Include your database connection and configuration file

                // Retrieve the list of users from the database
                $users = getUsers(); // Implement this function

                if ($users) {
                    echo '<table>';
                    echo '<tr><th>User ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>';

                    foreach ($users as $user) {
                        echo '<tr>';
                        echo '<td>' . $user['user_id'] . '</td>';
                        echo '<td>' . $user['username'] . '</td>';
                        echo '<td>' . $user['email'] . '</td>';
                        echo '<td><a href="edit_user.php?id=' . $user['user_id'] . '">Edit</a> | <a href="delete_user.php?id=' . $user['user_id'] . '">Delete</a></td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo '<p>No users found.</p>';
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
