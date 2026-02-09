<?php
// Include your configuration and database connection files
include 'config.php';
include 'db.php';

// Function to check if a user is an admin
function isAdmin($userId) {
    global $mysqli;

    // Sanitize user input
    $userId = $mysqli->real_escape_string($userId);

    // Query to check if the user is an admin (adjust the table and column names as per your database schema)
    $query = "SELECT is_admin FROM users WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return (bool)$user['is_admin'];
    }

    return false;
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if the logged-in user is an admin
    if (!isAdmin($userId)) {
        // Redirect non-admin users to a different page or display an error message
        header('Location: access_denied.php');
        exit();
    }
} else {
    // Redirect unauthenticated users to the login page
    header('Location: ../login.php');
    exit();
}
?>
