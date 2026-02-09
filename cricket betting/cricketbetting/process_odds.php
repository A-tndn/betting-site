<?php
session_start();
include('db.php');
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted odds details
    $match_id = $_POST["match_id"];
    $team_name = $_POST["team_name"];
    $odds = $_POST["odds"];

    // Include your database connection and execute an SQL query to insert the data
    global $mysqli;

    // SQL query to insert odds details
    $query = "INSERT INTO odds (match_id, team_name, odds) VALUES ('$match_id', '$team_name', '$odds')";

    if ($mysqli->query($query)) {
        // Odds details added successfully
        header("Location: odds.php"); // Redirect to a page that lists odds or a success page
        exit();
    } else {
        // Handle the error, such as displaying an error message or redirecting to an error page
        echo "Error: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
