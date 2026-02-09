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
    <?php 
    include('admin_header.php');
    //include('admin_navigation.php');
     ?>

        <!-- Include your admin panel header or navigation menu here -->
    </header>

    <main>
        <div class="container" style="height: 300px;">
            <h1>Welcome to the Admin Panel</h1>

            <!-- Display relevant statistics or data -->
            <div class="admin-stats">
            </div>

            <!-- Provide navigation links to various admin functions -->
        </div>
    </main>

    <footer>
    <?php include('admin_footer.php'); ?>
    </footer>
</body>
</html>
