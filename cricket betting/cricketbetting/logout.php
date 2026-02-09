<?php
// Start a PHP session to manage user authentication
session_start();

// Check if the user is not authenticated (not logged in); if so, there's no need to log out
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Destroy the session to log the user out
session_destroy();

// Redirect the user to the login page after logging out
header('Location: login.php');
exit();
?>
