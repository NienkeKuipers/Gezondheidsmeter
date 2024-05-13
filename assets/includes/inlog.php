<?php
// Start session
session_start();

// Database connection
require_once 'assets/includes/dbconfig.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    $query = "SELECT id, username, pwd, is_admin FROM users WHERE username = ?";
    $stmt = mysqli_prepare($db_connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $db_username, $hashed_password, $is_admin);
        mysqli_stmt_fetch($stmt);

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, log in the user
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            
            // Redirect user based on role
            if ($is_admin == 1) {
                header("Location: assets/Admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            // Incorrect password
            $error_message = "Incorrect username or password.";
        }
    } else {
        // User not found
        $error_message = "Incorrect username or password.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index.php
    header("Location: index.php");
    exit;
}
?>
