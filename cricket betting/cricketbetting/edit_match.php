<?php
// Include your database connection and configuration file

function getMatchDetails($matchId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input to prevent SQL injection
    $matchId = $conn->real_escape_string($matchId);

    // Query to retrieve match details
    $query = "SELECT match_id, team1, team2, match_date FROM matches WHERE match_id = '$matchId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $match = $result->fetch_assoc();

        // Close the database connection
        $conn->close();

        return $match;
    }

    // Close the database connection
    $conn->close();

    return false; // Match not found
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Match - Cricket Betting Admin Panel</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php include('admin_header.php'); ?>

    <main>
        <div class="container">
            <h1>Edit Match</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($isAdmin) {
                // Include your database connection and configuration file

                // Check if a match ID is provided in the query string
                if (isset($_GET['id'])) {
                    $matchId = $_GET['id'];

                    // Retrieve match details from the database
                    $match = getMatchDetails($matchId); // Implement this function

                    if ($match) {
                        // Display a form to edit match details
                        echo '<form action="update_match.php" method="post">';
                        echo '<input type="hidden" name="match_id" value="' . $match['match_id'] . '">';
                        echo '<label for="team1">Team 1:</label>';
                        echo '<input type="text" name="team1" value="' . $match['team1'] . '">';
                        echo '<label for="team2">Team 2:</label>';
                        echo '<input type="text" name="team2" value="' . $match['team2'] . '">';
                        echo '<label for="match_date">Match Date:</label>';
                        echo '<input type="text" name="match_date" value="' . $match['match_date'] . '">';
                        echo '<button type="submit">Update Match</button>';
                        echo '</form>';
                    } else {
                        echo '<p>Match not found.</p>';
                    }
                } else {
                    echo '<p>No match ID provided.</p>';
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
