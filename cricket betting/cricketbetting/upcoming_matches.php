<?php
// Start a PHP session to manage user authentication
session_start();

// Check if the user is not authenticated (not logged in); if so, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


?>
<?php
// Include your database connection and configuration file
include('db.php');
include_once('config.php');
/*
function getUpcomingMatches() {
    // Initialize an array to store upcoming matches
    $upcomingMatches = array();
    global $mysqli; // Add this line to access the database connection


    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
    //$mysqli->close();

    return $upcomingMatches;
}
*/
function getUpcomingMatches() {
    global $mysqli; // Assuming $conn is your database connection

    // Query to retrieve upcoming matches from the database
    $query = "SELECT * FROM matches WHERE start_date > NOW()";

    $result = $mysqli->query($query);

    // Check if the query was successful
    if ($result) {
        // Check if there are upcoming matches
        if ($result->num_rows > 0) {
            $matches = array();

            // Fetch and store the upcoming matches data
            while ($row = $result->fetch_assoc()) {
                $matches[] = $row;
            }

            // Close the result set
            $result->close();

            return $matches;
        } else {
            // No upcoming matches found
            return array();
        }
    } else {
        // Handle the case where the query was not successful (e.g., database error)
        // You may log the error or return an error message
        return false;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upcoming Matches - Cricket Betting App</title>
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
