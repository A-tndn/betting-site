<?php
// Include your database connection and configuration file

function getMatches() {
    // Initialize a database connection
    $conn = new mysqli("localhost", "username", "password", "your_database");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve the list of cricket matches
    $query = "SELECT match_id, team1, team2, match_date FROM matches";

    $result = $conn->query($query);

    $matches = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $matches[] = array(
                'match_id' => $row['match_id'],
                'team1' => $row['team1'],
                'team2' => $row['team2'],
                'match_date' => $row['match_date']
            );
        }
    }

    // Close the database connection
    $conn->close();

    return $matches;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Matches - Cricket Betting Admin Panel</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the admin header template -->
    <?php include('admin_header.php'); ?>

    <main>
        <div class="container">
            <h1>Manage Matches</h1>

            <?php
            // Check if the user is an admin (You may use a different method to check admin privileges)

            if ($isAdmin) {
                // Include your database connection and configuration file

                // Retrieve the list of cricket matches from the database
                $matches = getMatches(); // Implement this function

                if ($matches) {
                    echo '<table>';
                    echo '<tr><th>Match ID</th><th>Team 1</th><th>Team 2</th><th>Date</th><th>Actions</th></tr>';

                    foreach ($matches as $match) {
                        echo '<tr>';
                        echo '<td>' . $match['match_id'] . '</td>';
                        echo '<td>' . $match['team1'] . '</td>';
                        echo '<td>' . $match['team2'] . '</td>';
                        echo '<td>' . $match['match_date'] . '</td>';
                        echo '<td><a href="edit_match.php?id=' . $match['match_id'] . '">Edit</a> | <a href="delete_match.php?id=' . $match['match_id'] . '">Delete</a></td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo '<p>No matches found.</p>';
                }
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
