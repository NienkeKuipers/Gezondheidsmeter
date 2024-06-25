<?php
// Start session
session_start();

// Check of de uitlogactie is geactiveerd
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['logout'])) {
    // Verwijder alle sessievariabelen
    $_SESSION = array();

    // Als het gewenst is om de sessie van de browsers te verwijderen
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Vernietig de sessie
    session_destroy();

    // Redirect naar index.php
    header("Location: ../../index.php");
    exit;
}
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
    <form id="logout-form" method="POST" action="">
        <input type="hidden" name="logout" value="1">
    </form>
    <script>
        // Automatically submit the form to trigger the POST request
        document.getElementById('logout-form').submit();
    </script>
</body>
</html>
