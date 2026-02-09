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
//require_once 'header.php';


?>
<?php
// Include your database connection and configuration file
include('db.php');
include_once('config.php');

function isUsernameTaken($username) {
    global $mysqli; // Add this line to access the database connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize the username to prevent SQL injection (You may use prepared statements for enhanced security)
    $username = $mysqli->real_escape_string($username);

    // Query to check if the username already exists in the database
    $query = "SELECT user_id FROM users WHERE username = '$username'";

    $result = $mysqli->query($query);

    // Close the database connection
    //$mysqli->close();

    // Check if any rows are returned (i.e., if the username is taken)
    return $result->num_rows > 0;
}
?>
<?php
// Include your database connection and configuration file

function isEmailTaken($email) {
    global $mysqli; // Add this line to access the database connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize the email to prevent SQL injection (You may use prepared statements for enhanced security)
    $email = $mysqli->real_escape_string($email);

    // Query to check if the email already exists in the database
    $query = "SELECT user_id FROM users WHERE email = '$email'";

    $result = $mysqli->query($query);

    // Close the database connection
   // $mysqli->close();

    // Check if any rows are returned (i.e., if the email is taken)
    return $result->num_rows > 0;
}
?>
<?php
// Include your database connection and configuration file

function registerUser($username, $email, $password) {
    global $mysqli; // Add this line to access the database connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize user inputs to prevent SQL injection (You may use prepared statements for enhanced security)
    $username = $mysqli->real_escape_string($username);
    $email = $mysqli->real_escape_string($email);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security

    // Query to insert a new user into the database
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

    // Perform the insertion
    $result = $mysqli->query($query);

    // Close the database connection
    //$mysqli->close();

    // Return true if registration was successful, or false if it failed
    return $result;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - Cricket Betting App</title>
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
            <h1>Register</h1>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Process registration form submission
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Check if the provided username or email is already in use
                if (isUsernameTaken($username) || isEmailTaken($email)) { // Implement these functions
                    echo '<p class="error">Username or email already in use. Please choose another.</p>';
                } else {
                    // Register the new user
                    $registrationSuccessful = registerUser($username, $email, $password); // Implement this function

                    if ($registrationSuccessful) {
                        echo '<p class="success">Registration successful. You can now <a href="login.php">log in</a>.</p>';
                    } else {
                        echo '<p class="error">Registration failed. Please try again.</p>';
                    }
                }
            }
            ?>

            <form method="post" action="register.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Register</button>
            </form>

            <p>Already have an account? <a href="login.php">Log in here</a></p>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
