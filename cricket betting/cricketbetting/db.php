<?php
// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'cricketbetting'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a MySQLi database connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Set UTF-8 character set for proper encoding
if (!$mysqli->set_charset('utf8')) {
    die('Error loading character set utf8: ' . $mysqli->error);
}

// Function to safely execute SQL queries
function executeQuery($sql) {
    global $mysqli;
    
    $result = $mysqli->query($sql);
    
    if (!$result) {
        // Handle query execution errors
        die('Query execution failed: ' . $mysqli->error);
    }
    
    return $result;
}
?>
