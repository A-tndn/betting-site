<?php
// Database Configuration
define('DB_HOST', 'localhost'); // Database host
define('DB_USER', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password
define('DB_NAME', 'cricketbetting'); // Database name

// Site Configuration
define('SITE_URL', 'http://cricketbetting.com'); // Your website's URL

// Session Configuration

// Paths
define('ROOT_PATH', dirname(__FILE__) . '/'); // Root path of your project
define('INCLUDE_PATH', ROOT_PATH . 'includes/'); // Include path
define('CSS_PATH', SITE_URL . '/css/'); // CSS path
define('JS_PATH', SITE_URL . '/js/'); // JavaScript path
define('IMAGE_PATH', SITE_URL . '/images/'); // Image path

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Other Constants
define('DEFAULT_BALANCE', 1000); // Default user balance for new accounts

// Database Connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}
?>
