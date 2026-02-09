<?php
// Include your database connection and configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is an admin (You may use a different method to check admin privileges)

    if ($isAdmin) {
        // Check if the required fields are set in the POST data
        if (isset($_POST['team1_odds']) && isset($_POST['team2_odds']) && isset($_POST['draw_odds'])) {
            // Sanitize and validate the input data (You can add more validation as needed)
            $team1Odds = $_POST['team1_odds'];
            $team2Odds = $_POST['team2_odds'];
            $drawOdds = $_POST['draw_odds'];

            // Include your database connection and configuration file

            // Initialize a database connection
            $conn = new mysqli("localhost", "username", "password", "your_database");

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Update the odds for each match in the database
            foreach ($team1Odds as $matchId => $odds) {
                // Sanitize the input
                $matchId = $conn->real_escape_string($matchId);
                $odds = $conn->real_escape_string($odds);

                // Update the odds in the database
                $query = "UPDATE matches SET team1_odds = '$odds' WHERE match_id = '$matchId'";
                $conn->query($query);
            }

            foreach ($team2Odds as $matchId => $odds) {
                // Sanitize the input
                $matchId = $conn->real_escape_string($matchId);
                $odds = $conn->real_escape_string($odds);

                // Update the odds in the database
                $query = "UPDATE matches SET team2_odds = '$odds' WHERE match_id = '$matchId'";
                $conn->query($query);
            }

            foreach ($drawOdds as $matchId => $odds) {
                // Sanitize the input
                $matchId = $conn->real_escape_string($matchId);
                $odds = $conn->real_escape_string($odds);

                // Update the odds in the database
                $query = "UPDATE matches SET draw_odds = '$odds' WHERE match_id = '$matchId'";
                $conn->query($query);
            }

            // Close the database connection
            $conn->close();

            // Redirect back to the odds management page
            header("Location: odds_management.php");
            exit();
        } else {
            echo "Required fields are not set.";
        }
    } else {
        echo "You do not have admin privileges to update odds.";
    }
}
?>
