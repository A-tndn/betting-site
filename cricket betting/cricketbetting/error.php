<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Cricket Betting</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Error</h1>

            <?php
            if (isset($_GET['message'])) {
                $errorMessage = htmlspecialchars($_GET['message']);
                echo '<p>' . $errorMessage . '</p>';
            } else {
                echo '<p>An unknown error occurred.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
