<?php
require_once '../includes/dbconfig.php'; 
session_start(); 

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$userId = $_SESSION['user_id'];
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simple-toggle'])) {
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/rocker.css"> <!-- Voeg een aparte CSS-bestand toe voor de rocker switch -->
    <link rel="stylesheet" href="../../css/button.css"> <!-- Voeg een aparte CSS-bestand toe voor de nieuwe knop -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Voor de iconen -->
</head>
<body>
    <?php
        $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
    ?>
    <div id="app" class="mobile-layout">
        <div class="header">
            <div class="profile-section">
                <h2>Welkom <?php echo $username; ?></h2>
            </div>
        </div>
        <div class="health-section">
            <div class="health-item">Steps<br>10,000</div>
            <div class="health-item">Calories Burned<br>500</div>
            <div class="health-item">Water Intake<br>2L</div>
        </div>
        <div class="notification-settings">
            <p>Notificaties staan:</p>
            <label class="rocker rocker-small">
                <input type="checkbox" id="notif-toggle" <?php if ($userNotifPref) { echo 'checked'; } ?>>
                <span class="switch-left">Aan</span>
                <span class="switch-right">Uit</span>
            </label>
        </div>
        <div class="button-container">
            <a class="button" href="#" role="button">
                <span>remove</span>
                <div class="icon">
                    <i class="fa fa-remove"></i>
                    <i class="fa fa-check"></i>
                </div>
            </a>
        </div>
       

        <h2>Gegevens Resetten</h2>
        <form action="gebruikersinstellingen.php" method="POST" onsubmit="return confirm('Weet je zeker dat je alle gegevens wilt resetten? Deze actie kan niet ongedaan worden gemaakt.');">
            <input type="hidden" name="reset_data" value="1">
            <input type="submit" value="Reset Gegevens">
        </form>
   


        <div class="main-menu">
            <div class="menu-item">
                <img src="../images/check-list.png" alt="Vragenlijst">
                <p>Vragenlijst</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notifToggle = document.getElementById('notif-toggle');

            notifToggle.addEventListener('change', function() {
                var receiveNotifications = notifToggle.checked ? 1 : 0;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../includes/notification.php", true); // Adjusted path
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
                xhr.send("receive_notifications=" + receiveNotifications);
            });

            // Debugging: Check if the script is running
            console.log("Notification script loaded. Path to notification.php: ../includes/notification.php");
        });
    </script>
</body>
</html>
