<?php
// Include your database connection and configuration file

function getMatchesForOdds() {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve matches for odds management
    $query = "SELECT match_id, team1, team2, team1_odds, team2_odds, draw_odds FROM matches";

    $result = $conn->query($query);

    $matches = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $matches[] = array(
                'match_id' => $row['match_id'],
                'team1' => $row['team1'],
                'team2' => $row['team2'],
                'team1_odds' => $row['team1_odds'],
                'team2_odds' => $row['team2_odds'],
                'draw_odds' => $row['draw_odds']
            );
        }
    }

    // Close the database connection
    $conn->close();

    return $matches;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odds Management - Cricket Betting Admin Panel</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php include('admin_header.php'); ?>

    <main>
        <div class="container">
            <h1>Odds Management</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($isAdmin) {
                // Include your database connection and configuration file

                // Retrieve the list of matches for which odds can be set
                $matches = getMatchesForOdds(); // Implement this function

                if ($matches) {
                    echo '<form action="update_odds.php" method="post">';
                    echo '<table>';
                    echo '<tr><th>Match</th><th>Team 1 Odds</th><th>Team 2 Odds</th><th>Draw Odds</th></tr>';

                    foreach ($matches as $match) {
                        echo '<tr>';
                        echo '<td>' . $match['team1'] . ' vs ' . $match['team2'] . '</td>';
                        echo '<td><input type="text" name="team1_odds[' . $match['match_id'] . ']" value="' . $match['team1_odds'] . '"></td>';
                        echo '<td><input type="text" name="team2_odds[' . $match['match_id'] . ']" value="' . $match['team2_odds'] . '"></td>';
                        echo '<td><input type="text" name="draw_odds[' . $match['match_id'] . ']" value="' . $match['draw_odds'] . '"></td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                    echo '<button type="submit">Update Odds</button>';
                    echo '</form>';
                } else {
                    echo '<p>No matches found.</p>';
                }
            } else {
                echo '<p>You do not have admin privileges to access this page.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
