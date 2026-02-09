<?php
// Start a PHP session to manage user authentication
session_start();
include('db.php');
include_once('config.php');

// Check if the user is not authenticated (not logged in); if so, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<?php
// Include your database connection and configuration file

function getMatchDetails($matchId) {
    // Initialize a database connection
    global $mysqli ;
    
    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the match ID to prevent SQL injection
    $matchId = $mysqli->real_escape_string($matchId);

    // Query to retrieve match details based on the provided match ID
    $query = "SELECT match_name, match_date FROM matches WHERE match_id = '$matchId'";

    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $matchDetails = $result->fetch_assoc();
    } else {
        $matchDetails = null;
    }

    // Close the database connection
    $mysqli->close();

    return $matchDetails;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Place Bet - Cricket Betting App</title>
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
            <h1>Place Bet</h1>

            <?php
            // Check if a match_id is provided in the query string
            if (isset($_GET['match_id'])) {
                $matchId = $_GET['match_id'];
                $matchDetails = getMatchDetails($matchId); // Implement this function

                if ($matchDetails) {
                    echo '<h2>' . $matchDetails['match_name'] . '</h2>';
                    echo '<p>Date: ' . $matchDetails['match_date'] . '</p>';

                    // Display the bet form
                    echo '<form method="post" action="process_bet.php">';
                    echo '<input type="hidden" name="match_id" value="' . $matchId . '">';
                    echo '<label for="bet_amount">Bet Amount:</label>';
                    echo '<input type="text" id="bet_amount" name="bet_amount" required>';
                    echo '<button type="submit">Place Bet</button>';
                    echo '</form>';
                } else {
                    echo '<p>Match not found.</p>';
                }
            } else {
                echo '<p>Match ID not provided.</p>';
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
