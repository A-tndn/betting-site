<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Cricket Betting App</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php 
    include('admin_header.php'); 
    include('admin_auth.php'); 
    // Include necessary files and perform authentication checks here
    
    // Include the header template
    //require_once 'header.php';
    $userIsAdmin = isAdmin();

    // Admin authentication check (ensure only admins can access this page)
    if (!$userIsAdmin) {
        header('Location:../login.php');
        exit();
    }
    ?>

    <main>
        <div class="container">
            <h1>Admin Panel</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($userIsAdmin) {
                echo '<h2>Admin Tasks</h2>';

                // Include various admin task options here
                echo '<ul>';
                echo '<li><a href="manage_users.php">Manage Users</a></li>';
                echo '<li><a href="manage_matches.php">Manage Matches</a></li>';
                echo '<li><a href="manage_odds.php">Manage Odds</a></li>';
                // Add more task links as needed
                echo '</ul>';
            } else {
                echo '<p>You do not have admin privileges to access this page.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
