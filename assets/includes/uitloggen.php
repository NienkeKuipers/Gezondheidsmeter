<?php
// Start session
session_start();

// Unset all session variables
$_SESSION = array();

// If it's desired to clear the session from the browsers
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: ../../index.php");
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign out</title>
</head>
<body>
    <p>Signing out...</p>
</body>
</html>
