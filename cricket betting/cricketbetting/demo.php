<?php
// Include your configuration, database connection, and authentication checks here
session_start();
include('db.php');
include_once('config.php');

// Include the header template
function getUserBalance($userId) {
    global $mysqli; // Assuming $conn is your database connection

    // Sanitize input to prevent SQL injection
    $userId = $mysqli->real_escape_string($userId);

    // Query to retrieve the user's balance from the database
    $query = "SELECT balance FROM users WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $balance = $row['balance'];

        // Close the result set
        $result->close();

        return $balance;
    }

    // Return 0 if the user is not found or if there is an error
    return 0;
}
function updateBalance($userId, $newBalance) {
    global $mysqli; // Assuming $conn is your database connection

    // Sanitize inputs to prevent SQL injection
    $userId = $mysqli->real_escape_string($userId);
    $newBalance = $mysqli->real_escape_string($newBalance);

    // Query to update the user's balance in the database
    $query = "UPDATE users SET balance = '$newBalance' WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    if ($result) {
        // Update successful
        return true;
    } else {
        // Update failed
        return false;
    }
}

// Initialize variables for error handling
$withdrawError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the withdrawal form submission

    // Validate and sanitize the withdrawal amount
    $withdrawAmount = filter_input(INPUT_POST, 'withdraw_amount', FILTER_SANITIZE_NUMBER_FLOAT);

    if ($withdrawAmount > 0) {
        // Check if the user has sufficient balance for withdrawal
        // You should implement a function to check the balance, e.g., getUserBalance

        $userBalance = getUserBalance($_SESSION['user_id']);

        if ($userBalance >= $withdrawAmount) {
            // Perform the withdrawal operation in your database
            // You should implement a function to update the user's balance, e.g., updateBalance

            if (updateBalance($_SESSION['user_id'], $userBalance - $withdrawAmount)) {
                // Withdrawal successful
                echo '<p class="success">Funds withdrawn successfully.</p>';
            } else {
                // Withdrawal failed
                $withdrawError = "Withdrawal failed. Please try again.";
            }
        } else {
            $withdrawError = "Insufficient balance for withdrawal.";
        }
    } else {
        $withdrawError = "Invalid withdrawal amount. Please enter a positive amount.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Withdraw Funds - Cricket Betting App</title>
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
            <h1>Withdraw Funds</h1>

            <form method="post" action="withdraw_funds.php">
                <label for="withdraw_amount">Withdrawal Amount:</label>
                <input type="number" step="0.01" id="withdraw_amount" name="withdraw_amount" required>

                <button type="submit">Withdraw</button>
            </form>

        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
