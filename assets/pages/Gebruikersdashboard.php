<?php
require_once '../includes/dbconfig.php'; // Laad de databaseconfiguratie
session_start(); // Start de sessie

// Haal de gebruikers-ID en de huidige datum op
$userId = $_SESSION['user_id'];
$currentDate = date('Y-m-d'); // Huidige datum in het formaat 'YYYY-MM-DD'


// Stel de huidige vraag-ID op of haal deze op uit de sessie
if (!isset($_SESSION['current_question_id'])) {
    $_SESSION['current_question_id'] = 1; // Zet de vraag-ID op 1 als het niet bestaat
}

// Haal het totaal aantal vragen op
$totalQuestionsStmt = $pdo->query("SELECT COUNT(*) FROM questions");
$totalQuestions = $totalQuestionsStmt->fetchColumn(); // Totaal aantal vragen

// Haal de huidige vraag-ID op uit de sessie
$currentQuestionId = $_SESSION['current_question_id'];

// Haal de huidige vraag en opties op
$stmt = $pdo->prepare("SELECT q.id, q.text, o.id as option_id, o.text as option_text 
                       FROM questions q 
                       JOIN options o ON q.id = o.question_id 
                       WHERE q.id = ?");
$stmt->execute([$currentQuestionId]);
$questionsOptions = $stmt->fetchAll(PDO::FETCH_ASSOC); // Haal de vraag en opties op

$question = null; // Variabele voor de vraag
$options = []; // Array voor de opties
if ($questionsOptions) {
    $question = [
        'id' => $questionsOptions[0]['id'],
        'text' => $questionsOptions[0]['text']
    ];
    foreach ($questionsOptions as $item) {
        $options[] = [
            'id' => $item['option_id'],
            'text' => $item['option_text']
        ];
    }
}

// Haal de notificatievoorkeur van de gebruiker op
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications'];

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Dashboard</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
</head>
<body>

    <?php
        // De gebruikersnaam ophalen uit de sessie
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Gast';
    ?>
    <div class="green-top">
        <div class="header">
            <div class="profile-section">
                <h1>Welkom <?php echo htmlspecialchars($username); ?></h1>
            </div>
        </div>
    </div> <!-- Groene bovenkant -->
    <div id="app" class="mobile-layout">

        <div class="speechcent">
            <div class="speech-bubble round float">
                <?php if ($userNotifPref): // Controleer of de gebruiker notificaties heeft ingeschakeld ?>
                    <?php if ($question): // Controleer of er onbeantwoorde vragen zijn ?>
                        <p class="reminder">Je hebt de dagelijkse vragenlijst nog niet ingevuld! <a href="gebruikerstest.php"><br><i>Klik hier om het nu in te vullen.</i></a></p>
                    <?php else: // Geen onbeantwoorde vragen meer ?>
                        <p class="reminder">Goed gedaan! Je hebt alle vragen beantwoord.</p>
                    <?php endif; ?>
                <?php else: // Notificaties zijn uitgeschakeld ?>
                    <p class="reminder">Meldingen zijn momenteel uitgeschakeld.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="health-section">
            <div class="health-item"><h2>DASHBOARD</h2></div>
        </div>
        <div class="main-menu">
            <a href="gebruikerstest.php" class="menu-item">
                <img src="../images/check-list.png" alt="Vragenlijst">
                <p>Vragenlijst</p>
            </a>
            <a href="gebruikersresultaten.php" class="menu-item">
                <img src="../images/result.png" alt="Resultaten">
                <p>Resultaten</p>
            </a>
            <a href="gebruikersaccount.php" class="menu-item">
                <img src="../images/user.png" alt="Account">
                <p>Account Beheer</p>
            </a>
            <a href="gebruikersinstellingen.php" class="menu-item">
                <img src="../images/settings.png" alt="Instellingen">
                <p>Instellingen</p>
            </a>
        </div>
        <div class="health-section">
            <div class="health-item">&nbsp;</div>
        </div>
        <div class="button-container">
            <div class="button" id="logoutButton">
                <div class="light"></div>
            </div>
        </div>
    </div>

    <script>
        // Functie om de gebruiker uit te loggen
        function handleLogout() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../includes/uitloggen.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Redirect naar index.php na succesvol uitloggen
                    window.location.href = "../../index.php";
                }
            };
            xhr.send("logout=1"); // Stuur logout-verzoek naar de server
        }

        // Voeg een click event listener toe aan de logout-knop
        document.getElementById('logoutButton').addEventListener('click', handleLogout);
    </script>
</body>
</html>
