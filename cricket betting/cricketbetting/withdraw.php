<?php
// Include your database connection and configuration file

function getUserProfile($userId) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user profile information from the 'users' table
    $query = "SELECT username, email, balance FROM users WHERE user_id = '$userId'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $userProfile = $result->fetch_assoc();
    } else {
        $userProfile = null;
    }

    // Close the database connection
    $conn->close();

    return $userProfile;
}
?>
<?php
// Include your database connection and configuration file

function withdrawFunds($userId, $withdrawalAmount) {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user inputs to prevent SQL injection
    $userId = $conn->real_escape_string($userId);
    $withdrawalAmount = floatval($withdrawalAmount);

    // Check if the withdrawal amount is greater than zero
    if ($withdrawalAmount > 0) {
        // Retrieve the user's current balance from the database
        $query = "SELECT balance FROM users WHERE user_id = '$userId'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $currentBalance = $row['balance'];

            // Check if the user has a sufficient balance for the withdrawal
            if ($currentBalance >= $withdrawalAmount) {
                // Calculate the new balance after withdrawal
                $newBalance = $currentBalance - $withdrawalAmount;

                // Update the user's balance in the database
                $updateQuery = "UPDATE users SET balance = $newBalance WHERE user_id = '$userId'";
                $updateResult = $conn->query($updateQuery);

                if ($updateResult) {
                    // Close the database connection
                    $conn->close();
                    return $newBalance; // Return the new balance after the withdrawal
                }
            }
        }
    }

    // Close the database connection
    $conn->close();
    return false; // Return false if the withdrawal fails
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Funds - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Withdraw Funds</h1>

            <?php
            // Include your database connection and configuration file

            // Check if the user is authenticated and their ID is available in the session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                // Check if the form has been submitted
                if (isset($_POST['withdraw'])) {
                    // Retrieve and sanitize the user's input for the withdrawal amount
                    $withdrawalAmount = floatval($_POST['withdrawal_amount']);

                    if ($withdrawalAmount > 0) {
                        // Check if the user has sufficient balance for the withdrawal
                        $userProfile = getUserProfile($userId); // Implement this function

                        if ($userProfile && $userProfile['balance'] >= $withdrawalAmount) {
                            // Update the user's balance in the database
                            $withdrawResult = withdrawFunds($userId, $withdrawalAmount); // Implement this function

                            if ($withdrawResult) {
                                echo '<p>Withdrawal successful. Your new balance is $' . $withdrawResult . '</p>';
                            } else {
                                echo '<p>Withdrawal failed.</p>';
                            }
                        } else {
                            echo '<p>You do not have sufficient balance for this withdrawal.</p>';
                        }
                    } else {
                        echo '<p>Please enter a valid withdrawal amount.</p>';
                    }
                }

                echo '<form action="withdraw.php" method="post">';
                echo '<label for="withdrawal_amount">Withdrawal Amount (USD):</label>';
                echo '<input type="number" id="withdrawal_amount" name="withdrawal_amount" step="0.01" required>';
                echo '<input type="submit" name="withdraw" value="Withdraw">';
                echo '</form>';
            } else {
                echo '<p>You must be logged in to withdraw funds.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
