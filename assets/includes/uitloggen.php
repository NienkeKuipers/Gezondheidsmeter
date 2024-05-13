<?php
// Start session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign out</title>
    <script>
        // Clear browser history to prevent back navigation
        window.location.replace("/index.php");
    </script>
</head>
<body>
    <p>Signing out...</p>
</body>
</html>
