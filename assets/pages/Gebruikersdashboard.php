<?php
// Start session
session_start();

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index.php
    header("Location: /index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/css/style.css"> <!-- Include your style.css -->
</head>
<body>
    <h1>Welcome to User Dashboard</h1>
    <!-- Add log-out button -->
    <form action="Gebruikersdashboard.php" method="post">
        <button type="submit" name="logout">Log out</button>
    </form>
</body>
</html>
