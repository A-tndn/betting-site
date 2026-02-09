<?php
// Include your configuration, database connection, and authentication checks here

session_start();
include('db.php');
include_once('config.php');


function updateBalance($userId, $newBalance) {
    global $mysqli; // Assuming $conn is your database connection

    // Sanitize inputs to prevent SQL injection
    $userId = $mysqli->real_escape_string($userId);
    $newBalance = $mysqli->real_escape_string($newBalance);

    // Query to update the user's balance in the database
    $query = "UPDATE users SET balance = '$newBalance' WHERE user_id = '$userId'";

    $result = $mysqli->query($query);

    // Check if the update was successful
    if ($result) {
        // Update successful
        return true;
    } else {
        // Update failed
        return false;
    }
}

// Initialize variables for error handling
$depositError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the deposit form submission

    // Validate and sanitize the deposit amount
    $depositAmount = filter_input(INPUT_POST, 'deposit_amount', FILTER_SANITIZE_NUMBER_FLOAT);

    if ($depositAmount > 0) {
        // Perform the deposit operation in your database
        // You should implement a function to update the user's balance, e.g., updateBalance

        if (updateBalance($_SESSION['user_id'], $depositAmount)) {
            // Deposit successful
            echo '<p class="success">Funds deposited successfully.</p>';
        } else {
            // Deposit failed
            $depositError = "Deposit failed. Please try again.";
        }
    } else {
        $depositError = "Invalid deposit amount. Please enter a positive amount.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Deposit Funds - Cricket Betting App</title>
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
            <h1>Deposit Funds</h1>

            <form method="post" action="deposit_funds.php">
                <label for="deposit_amount">Deposit Amount:</label>
                <input type="number" step="0.01" id="deposit_amount" name="deposit_amount" required>

                <button type="submit">Deposit</button>
            </form>

            <p class="error"><?php echo $depositError; ?></p>
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
