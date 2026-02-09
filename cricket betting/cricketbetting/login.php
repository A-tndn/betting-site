<?php
// Start a PHP session to manage user authentication
session_start();

// Check if the user is already logged in; if yes, redirect them to the dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Include your configuration, database connection, and necessary functions here.

// Include the header template
//include('header.php');
include('db.php');
include_once('config.php');

?>
<?php
// Include your database connection and configuration file

function verifyLogin($username, $password) {
    // Initialize a database connection
    global $mysqli; // Add this line to access the database connection

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize the username to prevent SQL injection (You may use prepared statements for enhanced security)
    $username = $mysqli->real_escape_string($username);

    // Query to retrieve user information based on the provided username
    $query = "SELECT user_id, username, password FROM users WHERE username = '$username'";

    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the provided password against the stored hash
        if (password_verify($password, $row['password'])) {
            // Password is correct; create a user data array
            $user = array(
                'user_id' => $row['user_id'],
                'username' => $row['username']
            );

            // Close the database connection and return the user data
           // $mysqli->close();
            return $user;
        }
    }

    // Close the database connection and return null if login fails
    //$mysqli->close();
    return null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Cricket Betting App</title>
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
            <h1>Login</h1>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Process login form submission
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Verify the login credentials
                $user = verifyLogin($username, $password); // Implement this function

                if ($user) {
                    // Authentication successful; store user information in the session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];

                    // Redirect the user to the dashboard
                    header('Location: dashboard.php');
                    exit();
                } else {
                    // Display an error message
                    echo '<p class="error">Invalid username or password. Please try again.</p>';
                }
            }
            ?>

            <form method="post" action="login.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Log In</button>
            </form>

            <p>Don't have an account? <a href="register.php">Sign up here</a></p>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
