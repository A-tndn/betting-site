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

function getUpcomingMatches() {
    global $mysqli;
    // Initialize an array to store upcoming matches
    $upcomingMatches = array();

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to retrieve upcoming matches from the database (replace 'matches' with your actual table name)
    $sql = "SELECT match_id, match_name, match_date FROM matches WHERE match_date >= NOW()";

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $upcomingMatches[] = $row;
        }
    }

    // Close the database connection
    $mysqli->close();

    return $upcomingMatches;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Matches - Cricket Betting App</title>
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
            <h1>Upcoming Matches</h1>

            <?php
            // Retrieve and display the list of upcoming matches from the database
            $upcomingMatches = getUpcomingMatches(); // Implement this function

            if (!empty($upcomingMatches)) {
                echo '<table>';
                echo '<tr><th>Match Name</th><th>Date</th><th>Place Your Bet</th></tr>';
                foreach ($upcomingMatches as $match) {
                    echo '<tr>';
                    echo '<td>' . $match['match_name'] . '</td>';
                    echo '<td>' . $match['match_date'] . '</td>';
                    echo '<td><a href="place_bet.php?match_id=' . $match['match_id'] . '">Place Bet</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No upcoming matches available.</p>';
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
