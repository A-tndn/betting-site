<?php
// Start a PHP session to manage user authentication
session_start();

// Include your configuration, database connection, and necessary functions here.

// Include the header template
include('header.php');

// Check if a match ID is provided in the query string
if (isset($_GET['match_id'])) {
    $matchId = $_GET['match_id'];
    $matchDetails = getMatchDetails($matchId); // Implement this function

    if ($matchDetails) {
        $matchName = $matchDetails['match_name'];
        $matchDate = $matchDetails['match_date'];

        // Retrieve odds for this match
        $matchOdds = getMatchOdds($matchId); // Implement this function

        // Include a bet form
        include('bet_form.php'); // Create a separate bet_form.php for the form

        // Display match details
        echo '<div class="container">';
        echo '<h1>' . $matchName . '</h1>';
        echo '<p>Date: ' . $matchDate . '</p>';

        // Display odds
        echo '<h2>Odds</h2>';
        if ($matchOdds) {
            echo '<ul>';
            foreach ($matchOdds as $odd) {
                echo '<li>' . $odd['team_name'] . ': ' . $odd['odds'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No odds available.</p>';
        }

        echo '</div>';
    } else {
        echo '<p>Match not found.</p>';
    }
} else {
    echo '<p>Match ID not provided.</p>';
}
?>
<?php
// Include your database connection and configuration file

function getMatchDetails($matchId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the match ID to prevent SQL injection
    $matchId = $conn->real_escape_string($matchId);

    // Query to retrieve match details from the 'matches' table
    $query = "SELECT * FROM matches WHERE match_id = '$matchId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $matchDetails = $result->fetch_assoc();
    } else {
        $matchDetails = null;
    }

    // Close the database connection
    $conn->close();

    return $matchDetails;
}
?>
<?php
// Include your database connection and configuration file

function getMatchOdds($matchId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the match ID to prevent SQL injection
    $matchId = $conn->real_escape_string($matchId);

    // Query to retrieve odds for the match from the 'odds' table
    $query = "SELECT team_name, odds FROM odds WHERE match_id = '$matchId'";

    $result = $conn->query($query);

    $matchOdds = array();

    while ($row = $result->fetch_assoc()) {
        $matchOdds[] = $row;
    }

    // Close the database connection
    $conn->close();

    return $matchOdds;
}
?>

<!-- Add HTML for the page (e.g., a back button, more information, etc.) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <?php
            // Check if match details are available
            if ($matchDetails) {
                echo '<h1>' . $matchDetails['match_name'] . '</h1>';
                echo '<p>Date: ' . $matchDetails['match_date'] . '</p>';

                // Display odds for the match
                echo '<h2>Odds</h2>';
                if ($matchOdds) {
                    echo '<ul>';
                    foreach ($matchOdds as $odd) {
                        echo '<li>' . $odd['team_name'] . ': ' . $odd['odds'] . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No odds available for this match.</p>';
                }

                // Include the bet placement form
                include('bet_form.php');
            } else {
                echo '<p>Match details not found.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>


<?php
// Include the footer template
include('footer.php');
?>
