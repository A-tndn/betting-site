<?php
// Include your database connection and configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is an admin (You may use a different method to check admin privileges)

    if ($isAdmin) {
        // Check if the required fields are set in the POST data
        if (isset($_POST['match_id']) && isset($_POST['team1']) && isset($_POST['team2']) && isset($_POST['match_date'])) {
            // Sanitize and validate the input data (You can add more validation as needed)
            $matchId = $_POST['match_id'];
            $team1 = htmlspecialchars($_POST['team1']);
            $team2 = htmlspecialchars($_POST['team2']);
            $matchDate = htmlspecialchars($_POST['match_date']);

            // Include your database connection and configuration file

            // Initialize a database connection
            $conn = new mysqli("localhost", "username", "password", "your_database");

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Update the match details in the database
            $query = "UPDATE matches SET team1 = '$team1', team2 = '$team2', match_date = '$matchDate' WHERE match_id = '$matchId'";

            if ($conn->query($query) === true) {
                // Match details updated successfully
                header("Location: manage_matches.php");
                exit();
            } else {
                echo "Error updating match details: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "Required fields are not set.";
        }
    } else {
        echo "You do not have admin privileges to update match details.";
    }
}
?>
