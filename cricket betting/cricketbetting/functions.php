<?php
// Include your database connection code here (e.g., require_once 'db.php')

// Custom Functions

// Function to safely escape user inputs to prevent SQL injection
/*function sanitizeInput($input) {
    // Use your database connection object for escaping (e.g., $mysqli->real_escape_string())
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
*/
// Function to check if a user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get the current user's ID if logged in
function getCurrentUserId() {
    if (isUserLoggedIn()) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

// Function to display a user-friendly date
function formatUserDate($date) {
    return date('F j, Y, g:i a', strtotime($date));
}

// Function to redirect to another page
function redirectTo($page) {
    header("Location: $page");
    exit();
}

// Function to display a success message
function showSuccessMessage($message) {
    echo '<div class="alert alert-success">' . $message . '</div>';
}

// Function to display an error message
function showErrorMessage($message) {
    echo '<div class="alert alert-danger">' . $message . '</div>';
}

?>
