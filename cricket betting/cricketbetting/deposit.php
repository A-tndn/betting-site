<?php
// Include your database connection and configuration file

function depositFunds($userId, $depositAmount) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user inputs to prevent SQL injection
    $userId = $conn->real_escape_string($userId);
    $depositAmount = floatval($depositAmount);

    // Check if the deposit amount is greater than zero
    if ($depositAmount > 0) {
        // Retrieve the user's current balance from the database
        $query = "SELECT balance FROM users WHERE user_id = '$userId'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $currentBalance = $row['balance'];

            // Calculate the new balance after deposit
            $newBalance = $currentBalance + $depositAmount;

            // Update the user's balance in the database
            $updateQuery = "UPDATE users SET balance = $newBalance WHERE user_id = '$userId'";
            $updateResult = $conn->query($updateQuery);

            if ($updateResult) {
                // Close the database connection
                $conn->close();
                return $newBalance; // Return the new balance after the deposit
            }
        }
    }

    // Close the database connection
    $conn->close();
    return false; // Return false if the deposit fails
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Funds - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Deposit Funds</h1>

            <?php
            // Include your database connection and configuration file

            // Check if the user is authenticated and their ID is available in the session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Check if the form has been submitted
                if (isset($_POST['deposit'])) {
                    // Retrieve and sanitize the user's input for the deposit amount
                    $depositAmount = floatval($_POST['deposit_amount']);

                    if ($depositAmount > 0) {
                        // Update the user's balance in the database
                        $depositResult = depositFunds($userId, $depositAmount); // Implement this function

                        if ($depositResult) {
                            echo '<p>Deposit successful. Your new balance is $' . $depositResult . '</p>';
                        } else {
                            echo '<p>Deposit failed.</p>';
                        }
                    } else {
                        echo '<p>Please enter a valid deposit amount.</p>';
                    }
                }

                echo '<form action="deposit.php" method="post">';
                echo '<label for="deposit_amount">Deposit Amount (USD):</label>';
                echo '<input type="number" id="deposit_amount" name="deposit_amount" step="0.01" required>';
                echo '<input type="submit" name="deposit" value="Deposit">';
                echo '</form>';
            } else {
                echo '<p>You must be logged in to deposit funds.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
