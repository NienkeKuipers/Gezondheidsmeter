<?php
session_start();
require_once 'dbconfig.php';

function checkExistingUser($email, $username, $pdo) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    return $stmt->fetchColumn();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    if (checkExistingUser($email, $username, $pdo)) {
        die('Username or email already in use.');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, pwd, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password, $is_admin]);
        if ($stmt->rowCount() == 1) {
            header("Location: ../pages/inlogpagina.php");
            exit;
        } else {
            echo "Registration failed. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
