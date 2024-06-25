<?php
require_once '../includes/dbconfig.php';
session_start(); 


if (!isset($_SESSION['user_id'])) {
    die("User not logged in"); 
}

$userId = $_SESSION['user_id']; // Verkrijg de gebruikers-ID van de ingelogde gebruiker

// Controleer of het reset-formulier is ingediend
if (isset($_POST['reset_data'])) {
    // SQL-commando om de antwoorden van de gebruiker te verwijderen
    $resetQuery = "DELETE FROM user_responses WHERE user_id = ?";
    $resetStmt = $pdo->prepare($resetQuery);
    $resetStmt->execute([$userId]);

    // Reset de vraag index in de sessie
    unset($_SESSION['current_question_id']);
}

// Haal de notificatievoorkeur van de gebruiker op
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications'];

// Controleer of het notificatieformulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simple-toggle'])) {
    // Wijzig de notificatievoorkeur van de gebruiker
    $newNotifPref = $userNotifPref ? 0 : 1;
    $updateQuery = "UPDATE users SET receive_notifications = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$newNotifPref, $userId]);
    $userNotifPref = $newNotifPref;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikerinstellingen</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/rocker.css">
    <link rel="stylesheet" href="../../css/button.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/account.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        // Verkrijg de gebruikersnaam of zet 'Guest' als er geen gebruikersnaam is
        $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
    ?>

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
                <h1>Gebruikersinstellingen</h1>
            </div>
        </div>
        <div class="notification-settings">
            <h2>Notificaties staan:</h2>
            <label class="rocker rocker-small">
                <input type="checkbox" id="notif-toggle" <?php if ($userNotifPref) { echo 'checked'; } ?>>
                <span class="switch-left">Aan</span>
                <span class="switch-right">Uit</span>
            </label>
        </div>

        <div class="notification-settings">
        <h2>Gegevens resetten:</h2>
        <form action="gebruikersinstellingen.php" method="POST" onsubmit="return confirm('Weet je zeker dat je alle gegevens wilt resetten? Deze actie kan niet ongedaan worden gemaakt.');" class="delete-form">
            <input type="hidden" name="reset_data" value="1">
            <input type="submit" value="Reset" class="delete-button">
        </form>
            </div>
    </div>
    <div class="health-section">
            <div class="health-item">&nbsp;</div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notifToggle = document.getElementById('notif-toggle');

            if (notifToggle) {
                // Voeg een event listener toe voor wanneer de checkbox verandert
                notifToggle.addEventListener('change', function() {
                    var receiveNotifications = notifToggle.checked ? 1 : 0;
                    console.log('Checkbox changed, new value: ' + receiveNotifications);

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../includes/notification.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.status === 'success') {
                                        console.log(response.message);
                                    } else {
                                        console.error("Error: " + response.message);
                                        alert("Error: " + response.message);
                                    }
                                } catch (e) {
                                    console.error("Failed to parse JSON response. Error: " + e);
                                    alert("Failed to parse response.");
                                }
                            } else {
                                console.error("Failed to update notification preference. Status: " + xhr.status);
                                alert("Failed to update notification preference. Status: " + xhr.status);
                            }
                        }
                    };
                    // Stuur de nieuwe notificatievoorkeur naar de server
                    xhr.send("receive_notifications=" + receiveNotifications);
                });
            } else {
                console.error('Checkbox element not found');
            }
            console.log("Notification script loaded. Path to notification.php: ../includes/notification.php");
        });
    </script>
</body>
</html>
