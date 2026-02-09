<?php
     // Set a default value
     session_start();
     include('db.php');
     include_once('config.php');
     
     
    if (isset($_POST['match_id'])) {
        

    // Include your database connection and configuration file
    global $mysqli; // Assuming $conn is your database connection

    // Get the match ID from the URL
    $matchId = $_POST['match_id']; // Ensure to sanitize and validate this input in your actual code

    // Initialize a database connection

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to retrieve odds for the selected match
    $query = "SELECT team_name, odds FROM odds WHERE match_id = $matchId";

    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo '<label for="bet_amount">Bet Amount (in USD):</label>';
        echo '<input type="number" id="bet_amount" name="bet_amount" required>';

        echo '<label for="team">Select Team:</label>';
        echo '<select id="team" name="team" required>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['team_name'] . '">' . $row['team_name'] . ' (Odds: ' . $row['odds'] . ')</option>';
        }

        echo '</select>';
    } else {
        echo '<p>No odds available for this match.</p>';
    }

    // Close the database connection
    $mysqli->close();
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

<form action="process_bet.php" method="post">
    <h2>Place Your Bet</h2>

    <input type="text" name="match_id" >
    <input type="submit" value="Place Bet">
</form>
</div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
