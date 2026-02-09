<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cricket Betting App</title>
    <!-- Include your CSS and JavaScript files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Cricket Betting App</h1>
        <?php
        // Check if the user is logged in (you should have a user authentication mechanism in place)
        $userIsLoggedIn = true; // Replace with your actual authentication logic

        if ($userIsLoggedIn) {
            echo '<p>Hello, John Doe!</p>';
            echo '<p>Your current balance: $100.00</p>';
        } else {
            echo '<p>Join the excitement of cricket betting. Sign up or log in to get started.</p>';
            echo '<p><a href="register.php">Sign Up</a> or <a href="login.php">Log In</a></p>';
        }
        ?>
    </header>

    <main>
        <h2>Upcoming Matches</h2>
        <ul>
            <li><a href="match_details.php?match_id=1">Team A vs. Team B - October 31, 2023</a></li>
            <li><a href="match_details.php?match_id=2">Team C vs. Team D - November 3, 2023</a></li>
            <li><a href="match_details.php?match_id=3">Team E vs. Team F - November 5, 2023</a></li>
        </ul>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Cricket Betting App</p>
    </footer>
</body>
</html>
