<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cricket Betting</title>
    <!-- Include your CSS styles here -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header template -->
    <?php include('header.php'); ?>

    <main>
        <div class="container">
            <h1>Contact Us</h1>

            <p>If you have any questions, feedback, or need assistance, please feel free to reach out to us. We're here to help you.</p>

            <h2>Contact Information</h2>

            <address>
                <p>Email: <a href="mailto:contact@cricketbetting.com">contact@cricketbetting.com</a></p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Address: 123 Betting Street, Cricket City, Sportsland</p>
            </address>

            <h2>Contact Form</h2>

            <form action="contact_process.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>

    <!-- Include the footer template -->
    <?php include('footer.php'); ?>
</body>
</html>
