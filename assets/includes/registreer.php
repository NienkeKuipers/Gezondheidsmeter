<?php
// Database connection
require_once '/assets/includes/dbconfig.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data (You need to implement this part)
    // For example, check if the username and email are not already in use, and if the password matches the confirmation

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Default value for is_admin
    $is_admin = 0;

    // Insert user into database
    $query = "INSERT INTO users (username, email, pwd, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db_connection, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hashed_password, $is_admin);
    mysqli_stmt_execute($stmt);

    // Check if user was successfully registered
    if (mysqli_stmt_affected_rows($stmt) == 1) {
        // Registration successful
        header("Location: inlog.php"); // Redirect to login page
        exit;
    } else {
        // Registration failed
        $error_message = "Registration failed. Please try again.";
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($db_connection);
}
?>
