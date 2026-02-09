<?php
// Start a PHP session to manage user authentication
session_start();
//include('sidebar.php');
include('db.php');
include_once('config.php');



// Check if the user is authenticated (you should replace this with your actual authentication logic)
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header('Location: login.php');
    exit();
}
$userID = $_SESSION['user_id'];

// Get the user's balance from the database
$balance = getUserBalance($userID); // You would need to implement this function


// Include the header template
function getUserBalance($userID) {
    global $mysqli;

    // Sanitize the user ID to prevent SQL injection
    $userID = $mysqli->real_escape_string($userID);

    // Query to fetch the user's balance from the database
    $query = "SELECT balance FROM users WHERE user_id = '$userID'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        // Fetch the balance from the result set
        $row = $result->fetch_assoc();
        $balance = $row['balance'];

        // Close the result set
        $result->close();

        return $balance;
    } else {
        // Handle the case where the user ID is not found or an error occurs
        return false;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Cricket Betting App</title>
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
            <h1>Dashboard</h1>

            <!-- User Information -->
            <h2>Your Information</h2>
            <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
            <p>Your current balance: $<?php echo $balance; ?></p>

            <!-- Betting History -->
            <h2>Your Betting History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Bet Type</th>
                        <th>Bet Amount</th>
                        <th>Bet Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display the user's betting history from the database
                    $bettingHistory = getUserBettingHistory($_SESSION['user_id']); // Implement this function
                    foreach ($bettingHistory as $bet) {
                        echo '<tr>';
                        echo '<td>' . $bet['match_name'] . '</td>';
                        echo '<td>' . $bet['bet_type'] . '</td>';
                        echo '<td>$' . $bet['bet_amount'] . '</td>';
                        echo '<td>' . $bet['bet_result'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
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

function getUserBettingHistory($userId) {
    global $mysqli;
    $bettingHistory = array();

    // Establish a MySQL database connection

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to retrieve the user's betting history
    $sql = "SELECT matches.match_name, bets.bet_type, bets.bet_amount, bets.bet_result
            FROM bets
            INNER JOIN matches ON bets.match_id = matches.match_id
            WHERE bets.user_id = $userId";

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bettingHistory[] = $row;
        }
    }

    // Close the database connection
    $mysqli->close();

    return $bettingHistory;
}
?>

