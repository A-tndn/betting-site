<?php
session_start();
include('db.php');
include_once('config.php');
// Include your configuration, database connection, and authentication checks here

// Retrieve a list of live matches from the database
// You should implement a function to get live matches, e.g., getLiveMatches
$liveMatches = getLiveMatches();


function getLiveMatches() {
    global $mysqli; // Assuming $conn is your database connection

    // Query to retrieve live matches from the database
    $query = "SELECT * FROM matches WHERE start_time < NOW() AND end_time > NOW()";

    $result = $mysqli->query($query);

    $liveMatches = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add match data to the liveMatches array
            $liveMatches[] = $row;
        }

        // Close the result set
      //  $result->close();
    }

    return $liveMatches;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Live Matches - Cricket Betting App</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <!-- Include the header template to maintain consistency -->
        <?php include('header.php'); ?>
    </header>

    <main>
        <div class="container">
            <h1>Live Matches</h1>

            <?php
            if (!empty($liveMatches)) {
                echo '<ul class="match-list">';
                foreach ($liveMatches as $match) {
                    echo '<li>';
                    echo '<h2>' . $match['match_name'] . '</h2>';
                    echo '<p>Teams: ' . $match['team1'] . ' vs. ' . $match['team2'] . '</p>';
                    echo '<p>Start Time: ' . $match['start_time'] . '</p>';
                    // Add more match information here
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No live matches available at the moment.</p>';
            }
            ?>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
