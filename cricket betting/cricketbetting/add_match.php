<?php
// Include your configuration, database connection, and authentication checks here
session_start();
include('db.php');
include_once('config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Matches - Cricket Betting App</title>
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
            <h1>Add Matches</h1>

            <form action="process_match.php" method="post">
            <label for="team1">Team 1:</label>
            <input type="text" name="team1" required>
        
            <label for="team2">Team 2:</label>
            <input type="text" name="team2" required>
        
            <label for="match_date">Match Date and Time:</label>
            <input type="datetime-local" name="match_date" required>
        
            <label for="venue">Venue:</label>
            <input type="text" name="venue" required>
        
            <button type="submit">Add Match</button>
        </form>
        
        </div>
    </main>

    <footer>
        <!-- Include the footer template to maintain consistency -->
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <!-- Include your admin panel header or navigation menu here -->
    </header>

    <main>
        <div class="container">
            <h1>Welcome to the Admin Panel</h1>

            <!-- Display relevant statistics or data -->
            <div class="admin-stats">
                <div class="admin-stat-box">
                    <h2>Total Users</h2>
                    <p>500</p>
                </div>
                <div class="admin-stat-box">
                    <h2>Recent Transactions</h2>
                    <ul>
                        <li>Transaction 1</li>
                        <li>Transaction 2</li>
                        <li>Transaction 3</li>
                    </ul>
                </div>
                <!-- Add more statistics as needed -->
            </div>

            <!-- Provide navigation links to various admin functions -->
            <div class="admin-options">
                <h2>Admin Options</h2>
                <ul>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="manage_matches.php">Manage Matches</a></li>
                    <li><a href="manage_odds.php">Manage Odds</a></li>
                    <!-- Add more options for managing different parts of the system -->
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <!-- Include your admin panel footer if needed -->
    </footer>
</body>
</html>
    </footer>
</body>
</html>
