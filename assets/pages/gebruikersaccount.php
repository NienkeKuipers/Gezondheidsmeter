<?php
require_once '../includes/dbconfig.php'; // Laad databaseconfiguratie
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    die("User not logged in"); // Als niet ingelogd, stop het script
}

$userId = $_SESSION['user_id']; // Haal de gebruikers-ID op

// Haal gebruikersdetails op (notificatie voorkeur en e-mail)
$notifQuery = "SELECT receive_notifications, email FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userDetails = $notifStmt->fetch(PDO::FETCH_ASSOC); // Sla details op

$userNotifPref = $userDetails['receive_notifications']; // Notificatie voorkeur
$userEmail = $userDetails['email']; 
$message = ""; // Variabele voor meldingen

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Controleer of het formulier is verstuurd
    if (isset($_POST['update_email'])) { // Als het e-mail bijwerken formulier is verstuurd
        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $newEmail = $_POST['email'];
            $updateEmailQuery = "UPDATE users SET email = ? WHERE id = ?";
            $updateEmailStmt = $pdo->prepare($updateEmailQuery);
            $updateEmailStmt->execute([$newEmail, $userId]); // Update e-mail in de database

            // Update e-mail in de sessie
            $_SESSION['email'] = $newEmail;
            $message = "E-mail succesvol bijgewerkt!"; 
        } else {
            $message = "Ongeldig e-mailadres!"; 
        }
    }

    if (isset($_POST['update_password'])) { // Als het wachtwoord bijwerken formulier is verstuurd
        if (isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
            $currentPassword = $_POST['current_password']; // Huidig wachtwoord
            $newPassword = $_POST['new_password']; // Nieuw wachtwoord
            $confirmPassword = $_POST['confirm_password']; // Bevestig nieuw wachtwoord

            // Controleer het huidige wachtwoord
            $passwordQuery = "SELECT pwd FROM users WHERE id = ?";
            $passwordStmt = $pdo->prepare($passwordQuery);
            $passwordStmt->execute([$userId]);
            $storedPassword = $passwordStmt->fetch(PDO::FETCH_ASSOC)['pwd'];

            if (password_verify($currentPassword, $storedPassword)) { // Als het huidige wachtwoord klopt
                if ($newPassword === $confirmPassword) { // Als de nieuwe wachtwoorden overeenkomen
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updatePasswordQuery = "UPDATE users SET pwd = ? WHERE id = ?";
                    $updatePasswordStmt = $pdo->prepare($updatePasswordQuery);
                    $updatePasswordStmt->execute([$hashedPassword, $userId]); // Update wachtwoord in de database
                    $message = "Wachtwoord succesvol bijgewerkt!"; // Succes bericht
                } else {
                    $message = "Nieuwe wachtwoorden komen niet overeen!"; // Foutmelding
                }
            } else {
                $message = "Huidig wachtwoord is onjuist!"; // Foutmelding
            }
        } else {
            $message = "Vul alle wachtwoordvelden in!"; // Foutmelding
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikersaccount</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/account.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
</head>
<body>
<div class="green-top">
        <div class="header">
            <div class="profile-section">
            </div>
        </div>
    </div> 
    <div id="app" class="mobile-layout">
        <div class="header">
            <div class="profile-section">
            <div class="back-button" onclick="location.href='gebruikersdashboard.php'">
                <i class="fa fa-arrow-left"></i>
            </div>
                <h1>Account Beheer</h1>
            </div>
        </div>
        <div class="content">
            <?php if ($message): ?> 
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <div class="form-group">
                <button id="change-email-button">E-mail wijzigen</button> 
            </div>
            <form action="gebruikersaccount.php" method="POST" class="email-form" id="email-form">
                <div class="form-group">
                    <label for="email">Nieuwe e-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? $userEmail); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_email">E-mail bijwerken</button> 
                </div>
            </form>

            <div class="form-group">
                <button id="change-password-button">Wachtwoord wijzigen</button> 
            </div>
            <form action="gebruikersaccount.php" method="POST" class="password-form" id="password-form">
                <div class="form-group">
                    <label for="current_password">Huidig wachtwoord:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nieuw wachtwoord:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Bevestig nieuw wachtwoord:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_password">Wachtwoord bijwerken</button> 
                </div>
            </form>
            <div class="bmi-link">
                <a href="bmi_score.php" class="menu-item">
                    <img src="../images/bmi.png" alt="BMI Calculator">
                    <p>BMI Berekenaar</p>
                </a>
            </div>
        </div>
    </div>
    <div class="health-section">
            <div class="health-item">&nbsp;</div>
    </div>
    <script>
        // Event listener om het e-mail wijzigingsformulier te tonen/verbergen
        document.getElementById('change-email-button').addEventListener('click', function() {
            var emailForm = document.getElementById('email-form');
            if (emailForm.style.display === 'none' || emailForm.style.display === '') {
                emailForm.style.display = 'block'; 
            } else {
                emailForm.style.display = 'none'; 
            }
        });

        // Event listener om het wachtwoord wijzigingsformulier te tonen/verbergen
        document.getElementById('change-password-button').addEventListener('click', function() {
            var passwordForm = document.getElementById('password-form');
            if (passwordForm.style.display === 'none' || passwordForm.style.display === '') {
                passwordForm.style.display = 'block'; 
            } else {
                passwordForm.style.display = 'none'; 
            }
        });
    </script>
</body>
</html>
