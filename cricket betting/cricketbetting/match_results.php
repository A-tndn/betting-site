<?php
session_start();
include('db.php');
include_once('config.php');
// Include your configuration, database connection, and authentication checks here

// Retrieve a list of completed match results from the database
// You should implement a function to get match results, e.g., getMatchResults
$matchResults = getMatchResults();

function getMatchResults() {
    global $mysqli; // Assuming $conn is your database connection

    // Query to retrieve completed match results from the database
    $query = "SELECT * FROM match_results";

    $result = $mysqli->query($query);

    $matchResults = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add match result data to the matchResults array
            $matchResults[] = $row;
        }

        // Close the result set
        $result->close();
    }

    return $matchResults;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Match Results - Cricket Betting App</title>
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
            <h1>Match Results</h1>

            <?php
            if (!empty($matchResults)) {
                echo '<ul class="match-list">';
                foreach ($matchResults as $result) {
                    echo '<li>';
                    echo '<h2>' . $result['match_name'] . '</h2>';
                    echo '<p>Teams: ' . $result['team1'] . ' vs. ' . $result['team2'] . '</p>';
                    echo '<p>Winner: ' . $result['winner'] . '</p>';
                    echo '<p>Score: ' . $result['score'] . '</p>';
                    // Add more match result details here
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No match results available.</p>';
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
