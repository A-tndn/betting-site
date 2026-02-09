<?php
//session_start();
//include('db.php');
include_once('config.php');
require_once('functions.php'); // General utility functions


// Include your database connection and configuration file

function getUserDetails($userId) {
    // Initialize a database connection
    global $mysqli;

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs to prevent SQL injection (you may use prepared statements for enhanced security)
    $userId = $mysqli->real_escape_string($userId);

    // Query to retrieve user details (replace 'users' with your actual table name and adjust columns)
    $query = "SELECT user_id, username, email, balance, other_fields FROM users WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    // Check if the query was successful and fetch user details
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // User not found or query error
        $user = null;
    }

    // Close the database connection
    $mysqli->close();

    return $user;
}

// Example usage
$userId = 1; // Replace with the actual user ID
$userDetails = getUserDetails($userId);

if ($userDetails) {
    // User details found
    print_r($userDetails);
} else {
    // Handle the case when user details are not found
   // echo "User not found.";
}
?>

<?php


// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in
    $user_id = $_SESSION['user_id'];
    
    // Get user details
    $user = getUserDetails($user_id);
} else {
    // User is not logged in
    $user = null;
}

// Include the header template

// Display content based on user's login status
if ($user) {
    // User is logged in
    include('dashboard.php'); // User dashboard
} else {
    // User is not logged in
    include('login.php'); // Login form
}

// Include the footer template
//include('footer.php');
?>
