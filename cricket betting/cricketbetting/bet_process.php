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

    // Validate the bet amount
    if (!is_numeric($betAmount) || $betAmount <= 0) {
        echo "Invalid bet amount. Please enter a positive number.";
        exit();
    }

    // Retrieve user details for balance calculation
    $userDetails = getUserDetails($_SESSION['user_id']); // Implement this function

    if ($userDetails) {
        $userId = $userDetails['user_id'];
        $currentBalance = $userDetails['balance'];

        // Check if the user has enough balance for the bet
        if ($currentBalance >= $betAmount) {
            // Perform the bet processing (insert the bet into the database)
            $betProcessed = processBet($userId, $matchId, $betAmount); // Implement this function

            if ($betProcessed) {
                // Calculate the new balance
                $newBalance = $currentBalance - $betAmount;

                // Update the user's balance in the database
                $balanceUpdated = updateBalance($userId, $newBalance); // Implement this function

                if ($balanceUpdated) {
                    echo "Bet placed successfully. Your new balance is: $newBalance";
                } else {
                    echo "Failed to update balance. Please contact support.";
                }
            } else {
                echo "Failed to place the bet. Please try again.";
            }
        } else {
            echo "Insufficient balance. Your current balance is: $currentBalance";
        }
    } else {
        echo "User not found. Please log in again.";
    }
}
?>
<?php
// Include your database connection and configuration file

function getUserDetails($userId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user details based on the provided user ID
    $query = "SELECT user_id, username, balance FROM users WHERE user_id = '$userId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $userDetails = $result->fetch_assoc();
    } else {
        $userDetails = null;
    }

    // Close the database connection
    $conn->close();

    return $userDetails;
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
<?php
// Include your database connection and configuration file

function updateBalance($userId, $newBalance) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs to prevent SQL injection (you may use prepared statements for enhanced security)
    $userId = $conn->real_escape_string($userId);
    $newBalance = $conn->real_escape_string($newBalance);

    // Query to update the user's balance in the database (replace 'users' with your actual table name)
    $query = "UPDATE users SET balance = '$newBalance' WHERE user_id = '$userId'";

    $result = $conn->query($query);

    // Close the database connection
    $conn->close();

    // Return true if the balance was successfully updated, or false if it failed
    return $result;
}
?>


<!-- Add HTML for the page (e.g., a back button, more information, etc.) -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bet Processing - Cricket Betting App</title>
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
            <h1>Bet Processing</h1>

            <?php
            // Output the feedback message based on the bet processing result
            if (isset($_SESSION['bet_result'])) {
                echo '<p>' . $_SESSION['bet_result'] . '</p>';
                unset($_SESSION['bet_result']); // Clear the session variable
            } else {
                echo '<p>Invalid request or bet processing failed.</p>';
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
