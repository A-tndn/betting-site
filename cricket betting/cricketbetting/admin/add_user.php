<?php
// Include your configuration file and perform admin authentication checks here
include('../config.php');
include('admin_auth.php'); // Implement admin authentication as needed

// Initialize variables to hold user input and messages
$username = $password = $email = $role = '';
$message = $error = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Establish a MySQLi database connection (replace with your actual database credentials)
    global $mysqli ;
    //= new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare an SQL query to insert a new user into the database
    $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";

    // Use a prepared statement for security
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters and execute the query
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

        if ($stmt->execute()) {
            $message = "User added successfully.";
        } else {
            $error = "Failed to add user. Please try again.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $error = "Error preparing the SQL statement.";
    }

    // Close the database connection
    $mysqli->close();
}

// Include the admin header, navigation, and other required files
include('admin_header.php');
include('admin_navigation.php');

// Your HTML and form for adding a user go here
?>
<!-- Your HTML form for adding a user -->
<h1>Add User</h1>
<?php
// Display success or error messages if applicable
if (!empty($message)) {
    echo '<div class="success">' . $message . '</div>';
}
if (!empty($error)) {
    echo '<div class="error">' . $error . '</div>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
    <?php 
    include('admin_header.php');
     ?>

        <!-- Include your admin panel header or navigation menu here -->
    </header>

    <main>
        <div class="container" style="height: 300px;">
            <h1>Add Users</h1>

            
<form method="post" action="add_user.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>

    <button type="submit">Add User</button>
</form>
<!-- Rest of your HTML content -->

            <!-- Provide navigation links to various admin functions -->
        </div>
    </main>

    <footer>
    <?php include('admin_footer.php'); ?>
    </footer>
</body>
</html>
