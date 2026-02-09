<?php
// Include your database connection and configuration file

function getLiveMatches() {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve live match details
    $query = "SELECT team1, team2, status, score FROM live_matches";

    $result = $conn->query($query);

    $liveMatches = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $liveMatches[] = array(
                'team1' => $row['team1'],
                'team2' => $row['team2'],
                'status' => $row['status'],
                'score' => $row['score']
            );
        }
    }

    // Close the database connection
    $conn->close();

    return $liveMatches;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Updates - Cricket Betting</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- You may also include JavaScript for live updates here -->
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Live Updates</h1>

            <?php
            // Include your PHP code to fetch live updates or scores
            // Implement a function to retrieve live match data

            $liveMatches = getLiveMatches(); // Implement this function

            if (!empty($liveMatches)) {
                foreach ($liveMatches as $match) {
                    echo '<div class="live-match">';
                    echo '<h2>' . $match['team1'] . ' vs ' . $match['team2'] . '</h2>';
                    echo '<p>Status: ' . $match['status'] . '</p>';
                    echo '<p>Score: ' . $match['score'] . '</p>';
                    // You can display more details as needed
                    echo '</div>';
                }
            } else {
                echo '<p>No live matches currently.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
