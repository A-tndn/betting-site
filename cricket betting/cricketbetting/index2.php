<?php
// Start a PHP session to manage user authentication
session_start();

// Check if the user is authenticated (you should replace this with your actual authentication logic)
$userIsLoggedIn = isset($_SESSION['user_id']);

// If the user is logged in, retrieve user details from the session or database
if ($userIsLoggedIn) {
    $username = $_SESSION['username']; // Replace with your user data retrieval logic
    $balance = 100.00; // Replace with the actual user's balance
}

// Include your configuration, database connection, and necessary functions here.

// Include the header template
include('header.php');
?>

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
        <div class="container">
            <div class="logo">
                <a href="index.php">Cricket Betting App</a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if ($userIsLoggedIn): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="register.php">Sign Up</a></li>
                        <li><a href="login.php">Log In</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>Welcome to the Cricket Betting App</h1>
            <?php if ($userIsLoggedIn): ?>
                <p>Hello, <?php echo $username; ?>!</p>
                <p>Your current balance: $<?php echo $balance; ?></p>
            <?php else: ?>
                <p>Join the excitement of cricket betting. Sign up or log in to get started.</p>
                <p><a href="register.php">Sign Up</a> or <a href="login.php">Log In</a></p>
            <?php endif; ?>

            <h2>Upcoming Matches</h2>
            <ul>
                <?php
                // Retrieve and display upcoming matches from the database
                $upcomingMatches = getUpcomingMatches(); // Implement this function
                foreach ($upcomingMatches as $match) {
                    echo '<li>';
                    echo '<a href="match_details.php?match_id=' . $match['match_id'] . '">';
                    echo $match['team_a'] . ' vs. ' . $match['team_b'] . ' on ' . $match['match_date'];
                    echo '</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </main>

<?php
// Include the footer template
include('footer.php');
?>
