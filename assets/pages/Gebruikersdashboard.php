<?php
require_once '../includes/dbconfig.php';
session_start();

$userId = $_SESSION['user_id']; // Gebruikers-ID opslaan voor later gebruik

// Fetch the total number of questions
$totalQuestionsQuery = "SELECT COUNT(*) FROM questions";
$totalQuestionsStmt = $pdo->prepare($totalQuestionsQuery);
$totalQuestionsStmt->execute();
$totalQuestions = $totalQuestionsStmt->fetchColumn();

// Controleren of de gebruiker vandaag de vragenlijst al heeft ingevuld
$today = date('Y-m-d'); // De huidige datum
$checkQuery = "SELECT COUNT(*) FROM user_responses WHERE user_id = ? AND response_date = ?";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->execute([$userId, $today]);
$responsesToday = $checkStmt->fetchColumn();
$hasCompletedToday = $responsesToday >= $totalQuestions; // Controleer of alle vragen zijn beantwoord

// De notificatievoorkeur van de gebruiker ophalen
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications']; // Opslaan of gebruiker notificaties wil

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php
        // Assuming the user's name is stored in the session
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    ?>
    <div class="green-top">        <div class="header">
            <div class="profile-section">
                <h1>Welkom <?php echo htmlspecialchars($username); ?></h1>
            </div>
        </div></div> <!-- Green top section -->
    <div id="app" class="mobile-layout">

    <div class="speechcent">
        <div class="speech-bubble round float">
            <?php if ($userNotifPref): // Controleert of de gebruiker notificaties heeft ingeschakeld ?>
                <?php if ($hasCompletedToday): // Check if all questions have been completed ?>
                    <p class="reminder">Goed gedaan! Je hebt alle vragen beantwoord.</p>
                <?php else: // Controleert of de gebruiker de vragenlijst nog niet heeft ingevuld ?>
                    <p class="reminder">Je hebt de dagelijkse vragenlijst nog niet ingevuld! <a href="gebruikerstest.php"><br><i>Klik hier om het nu in te vullen.</i></a></p>
                <?php endif; ?>
            <?php else: // Als notificaties zijn uitgeschakeld, toon dit bericht ?>
                <p class="reminder">Meldingen zijn momenteel uitgeschakeld.</p>
            <?php endif; ?>
        </div>
    </div>

        <div class="health-section">
            <div class="health-item"><h2>DASHBOARD<h2></div>
        </div>
        <div class="main-menu">
            <div class="menu-item">
                <img src="../images/check-list.png" alt="Vragenlijst">
                <p>Vragenlijst</p>
            </div>
            <div class="menu-item">
                <img src="../images/result.png" alt="Resultaten">
                <p>Resultaten</p>
            </div>
            <div class="menu-item">
                <img src="../images/user.png" alt="Account">
                <p>Account Beheer</p>
            </div>
            <div class="menu-item">
                <img src="../images/settings.png" alt="Instellingen">
                <p>Instellingen</p>
            </div>
        </div>
        <div class="health-section">
            <div class="health-item">&nbsp;</div>
        </div>
        <div class="button-container">
            <div class="button">
                <div class="light"></div>
            </div>
        </div>
    </div>

    <script>
        // Function to handle logout action
        function handleLogout() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../includes/uitloggen.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Redirect to index.php after successful logout
                    window.location.href = "../../index.php";
                }
            };
            xhr.send("logout=1");
        }

        // Attach click event listener to logout list item
        document.getElementById('logoutItem').addEventListener('click', handleLogout);
    </script>
</body>
</html>
