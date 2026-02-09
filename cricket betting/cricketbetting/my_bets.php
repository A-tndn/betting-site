<?php
session_start();
include('db.php');
include_once('config.php');
// Include your configuration, database connection, and authentication checks here

// Retrieve a list of the user's betting history from the database
// You should implement a function to get user's betting history, e.g., getUserBettingHistory
$userBettingHistory = getUserBettingHistory($_SESSION['user_id']);

// Include the header template
function getUserBettingHistory($userId) {
    global $mysqli; // Assuming $conn is your database connection

    // Query to retrieve the user's betting history from the database
    $query = "SELECT * FROM user_bets WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    $bettingHistory = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add betting history data to the bettingHistory array
            $bettingHistory[] = $row;
        }

        // Close the result set
      //  $result->close();
    }

    return $bettingHistory;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Bets - Cricket Betting App</title>
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
            <h1>My Betting History</h1>

            <?php
            if (!empty($userBettingHistory)) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Match</th>';
                echo '<th>Bet Amount</th>';
                echo '<th>Selected Team</th>';
                echo '<th>Result</th>';
                // Add more table headers for additional details
                echo '</tr>';
                
                foreach ($userBettingHistory as $bet) {
                    echo '<tr>';
                    echo '<td>' . $bet['match_name'] . '</td>';
                    echo '<td>' . $bet['bet_amount'] . '</td>';
                    echo '<td>' . $bet['selected_team'] . '</td>';
                    echo '<td>' . $bet['result'] . '</td>';
                    // Add more table cells for additional details
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No betting history available.</p>';
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
