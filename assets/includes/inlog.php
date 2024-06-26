<?php
session_start();

require_once 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, username, pwd, is_admin FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['pwd'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            if ($user['is_admin'] == 1) {
                header("Location: ../Admin/dashboard.php");
            } else {
                header("Location: ../pages/gebruikersdashboard.php");
            }
            exit;
        } else {
            // Foutmelding instellen als de inloggegevens onjuist zijn
            // $error_message = "Incorrect username or password.";
            $_SESSION['error_message'] = "Incorrect username or password.";
            // Redirect naar inlogpagina.php
            header("Location: ../pages/inlogpagina.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
