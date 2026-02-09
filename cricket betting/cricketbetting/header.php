<?php
require_once('functions.php');
//include('db.php');
$userIsLoggedIn = isUserLoggedIn();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cricket Betting App</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .main-menu {
    list-style-type: none;
    padding: 0;
}

.menu {
    background-color: #333;
    text-align: right;
}

.menu ul {
    list-style: none;
    padding: 0;
}

.menu li {
    display: inline;
    margin-right: 20px;
}

.menu a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

.main-menu li {
    display: inline-block;
    margin-right: 20px;
    position: relative;
}

.main-menu a {
    text-decoration: none;
    color: #333;
}

.submenu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
}

.main-menu li:hover .submenu {
    display: block;
}

.submenu li {
    background-color: #fff;
    border: 1px solid #ddd;
}

.submenu a {
    color: #333;
    display: block;
    padding: 5px 10px;
    text-decoration: none;
}

        </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">Cricket Betting App</a><br>
            </div>
            <div class="row" style="height: 100px;"></div>

            <nav>
               <div class="menu"> 
                <ul class="main-menu">
                <?php if ($userIsLoggedIn): ?>

                    <li><a href="index.php">Home</a></li>
                       
                        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="matches.php">Matches</a>
        <ul class="submenu">
        <li>
        <a href="add_match.php">Add Matches</a></li>
        <a href="upcoming_matches.php">Upcoming Matches</a></li>
                <li><a href="live_matches.php">Live Matches</a></li>
                <li><a href="match_results.php">Match Results</a></li>
                <li><a href="my_bets.php">My Bets</a></li>
            </ul>
        </li>
        <li><a href="betting.php">Betting</a>
        <ul class="submenu">
                <li><a href="place_bet.php">Place a Bet</a></li>
                <li><a href="bet_history.php">Bet History</a></li>
            </ul>
        </li>
        <li><a href="profile.php">My Profile</a>
        <ul class="submenu">
                <li><a href="view_profile.php">View Profile</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
                <li><a href="deposit_funds.php">Deposit Funds</a></li>
                <li><a href="withdraw_funds.php">Withdraw Funds</a></li>
                <li><a href="transaction_history.php">Transaction History</a></li>
            </ul>
        </li>
        <li><a href="logout.php">Logout</a></li>

                    <?php else: ?>
                        <li><a href="register.php">Sign Up</a></li>
                        <li><a href="login.php">Log In</a></li>
                    <?php endif; ?>
                </ul>
                    </div>
            </nav>
        </div>
    </header>
