<?php
// Include your configuration, database connection, and authentication checks here
session_start();
include('db.php');
include_once('config.php');

?><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted match details
    $team1 = $_POST["team1"];
    $team2 = $_POST["team2"];
    $match_date = $_POST["match_date"];
    $venue = $_POST["venue"];

    // Include your database connection and execute an SQL query to insert the data
    global $mysqli;

    // SQL query to insert match details
    $query = "INSERT INTO matches (team1, team2, match_date, venue) VALUES ('$team1', '$team2', '$match_date', '$venue')";

    if ($mysqli->query($query)) {
        // Match details added successfully
        header("Location: matches.php"); // Redirect to a page that lists matches or a success page
        exit();
    } else {
        // Handle the error, such as displaying an error message or redirecting to an error page
        echo "Error: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
