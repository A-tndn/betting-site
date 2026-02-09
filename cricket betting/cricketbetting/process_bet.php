<?php
// Start a PHP session to manage user authentication
session_start();

// Check if the user is not authenticated (not logged in); if so, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include your configuration, database connection, and necessary functions here.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get bet details from the form
    $matchId = $_POST["match_id"];
    $betAmount = $_POST["bet_amount"];

    // Ensure that the bet amount is a positive number (you can add more validation)
    if (!is_numeric($betAmount) || $betAmount <= 0) {
        echo "Invalid bet amount. Please enter a positive number.";
        exit();
    }

    // Retrieve match details for validation
    $matchDetails = getMatchDetails($matchId); // Implement this function

    if ($matchDetails) {
        // Perform the bet processing (insert the bet into the database)
        $betProcessed = processBet($_SESSION['user_id'], $matchId, $betAmount); // Implement this function

        if ($betProcessed) {
            echo "Bet placed successfully!";
        } else {
            echo "Failed to place the bet. Please try again.";
        }
    } else {
        echo "Match not found or has already started.";
    }
}
?>

<!-- Add HTML for the page (e.g., a back button, more information, etc.) -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Process Bet - Cricket Betting App</title>
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
            <h1>Process Bet</h1>

            <?php
            // Output any feedback message to the user
            if (isset($_SESSION['bet_message'])) {
                echo '<p>' . $_SESSION['bet_message'] . '</p>';
                unset($_SESSION['bet_message']); // Clear the session variable
            }
            ?>

            <p><a href="matches.php">Back to Matches</a></p>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>

<?php
// Include your database connection and configuration file

function getMatchDetails($matchId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the match ID to prevent SQL injection
    $matchId = $conn->real_escape_string($matchId);

    // Query to retrieve match details based on the provided match ID
    $query = "SELECT match_name, match_date FROM matches WHERE match_id = '$matchId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $matchDetails = $result->fetch_assoc();
    } else {
        $matchDetails = null;
    }

    // Close the database connection
    $conn->close();

    return $matchDetails;
}
?>
<?php
// Include your database connection and configuration file

function processBet($userId, $matchId, $betAmount) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs to prevent SQL injection (you may use prepared statements for enhanced security)
    $userId = $conn->real_escape_string($userId);
    $matchId = $conn->real_escape_string($matchId);
    $betAmount = $conn->real_escape_string($betAmount);

    // Query to insert the bet into the database (replace 'bets' with your actual table name)
    $query = "INSERT INTO bets (user_id, match_id, bet_amount) VALUES ('$userId', '$matchId', '$betAmount')";

    $result = $conn->query($query);

    // Close the database connection
    $conn->close();

    // Return true if the bet was successfully processed, or false if it failed
    return $result;
}
?>
