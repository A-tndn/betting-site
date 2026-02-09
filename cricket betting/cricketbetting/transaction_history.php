<?php
// Include your database connection and configuration file
session_start();
include('db.php');
include_once('config.php');

function getUserTransactionHistory($userId) {
    // Initialize a database connection
    global $mysqli; // Assuming $conn is your database connection

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Sanitize user input to prevent SQL injection
    $userId = $mysqli->real_escape_string($userId);

    // Query to retrieve the user's transaction history
    $query = "SELECT type, amount, date FROM transactions WHERE user_id = '$userId' ORDER BY date DESC";

    $result = $mysqli->query($query);

    $transactionHistory = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactionHistory[] = array(
                'type' => $row['type'],
                'amount' => $row['amount'],
                'date' => $row['date']
            );
        }
    }

    // Close the database connection
    $mysqli->close();

    return $transactionHistory;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Transaction History</h1>

            <?php
            // Include your database connection and configuration file

            // Check if the user is authenticated and their ID is available in the session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Retrieve the user's transaction history from the database
                $transactionHistory = getUserTransactionHistory($userId); // Implement this function

                if ($transactionHistory) {
                    echo '<table>';
                    echo '<tr><th>Transaction Type</th><th>Amount</th><th>Date</th></tr>';

                    foreach ($transactionHistory as $transaction) {
                        echo '<tr>';
                        echo '<td>' . $transaction['type'] . '</td>';
                        echo '<td>' . $transaction['amount'] . '</td>';
                        echo '<td>' . $transaction['date'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo '<p>No transaction history available.</p>';
                }
            } else {
                echo '<p>You must be logged in to view your transaction history.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
