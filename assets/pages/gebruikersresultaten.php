<?php
require_once '../includes/dbconfig.php'; // Laad de databaseconfiguratie
require_once '../includes/score_translator.php'; // Laad de score vertaler
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd, zo niet, stuur naar loginpagina
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit; // Stop het script
}

$userId = $_SESSION['user_id']; // Gebruikers-ID opslaan voor later gebruik
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; // Haal gebruikersnaam op of zet op 'Guest'

// De gemiddelde score van de gebruiker ophalen
$query = "SELECT AVG(o.points) as overall_average FROM user_responses ur JOIN options o ON ur.option_id = o.id WHERE ur.user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$overallScore = round($result['overall_average'], 2); // Afronden op het gemiddelde 
$translatedOverallScore = translateToThreePointScale($overallScore); // Vertaal de score naar leesbare tekst

// Bepaal de initiële rotatiegraad op basis van de score
$rotationDegree = 0; // Standaard rotatie
if ($translatedOverallScore['scale'] == 'Onvoldoende') {
    $rotationDegree = 26;
} elseif ($translatedOverallScore['scale'] == 'Voldoende') {
    $rotationDegree = 89;
} elseif ($translatedOverallScore['scale'] == 'Goed') {
    $rotationDegree = 153;
}

// Controleren of de gebruiker al eerder antwoorden heeft ingediend
$responseCheckQuery = "SELECT 1 FROM user_responses WHERE user_id = ?";
$responseCheckStmt = $pdo->prepare($responseCheckQuery);
$responseCheckStmt->execute([$userId]);
$hasResponses = $responseCheckStmt->rowCount() > 0; // Heeft de gebruiker al antwoorden ingediend?
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers resultaten</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/account.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="green-top">
        <div class="header">
            <div class="profile-section">
            </div>
        </div>
    </div> 
    <div id="app" class="mobile-layout" style="padding: 0px;">
    <div class="header">
            <div class="profile-section">
            <div class="back-button" onclick="location.href='gebruikersdashboard.php'">
                <i class="fa fa-arrow-left"></i>
            </div>
                <h1>Resultaten</h1>
            </div>
        </div>    
        
        <!-- Gezondheidsstatus secties, aanvankelijk verborgen -->
    <div class="combined_health">
        <div id="slechte_gezondheid" style="display: none;">
            <h3>Slechte Gezondheid (onvoldoende)</h3>
            <p>Je gezondheid bevindt zich op een zorgelijk niveau. Dit kan betekenen dat je onvoldoende beweegt, slecht eet, te weinig water drinkt, of andere ongezonde gewoonten hebt. Het is belangrijk om actie te ondernemen en gezondere keuzes te maken om je algehele welzijn te verbeteren.</p>
        </div>
        <div id="gemiddelde_gezondheid" style="display: none;">
            <h3>Gemiddelde Gezondheid (gemiddeld)</h3>
            <p>Je gezondheid is redelijk, maar er is nog ruimte voor verbetering. Je doet sommige dingen goed, zoals voldoende beweging en een redelijke voeding, maar er zijn nog gebieden die aandacht nodig hebben. Probeer een evenwichtigere levensstijl te vinden voor betere resultaten.</p>
        </div>
        <div id="goede_gezondheid" style="display: none;">
            <h3>Goede Gezondheid (goed)</h3>
            <p>Gefeliciteerd! Je gezondheid is op een uitstekend niveau. Dit betekent dat je goed voor jezelf zorgt door regelmatig te bewegen, gezond te eten, voldoende water te drinken, en andere gezonde gewoonten te onderhouden. Blijf zo doorgaan om je welzijn te behouden.</p>
        </div>
    </div>

        <?php if ($hasResponses): ?>
            <div class="wrapper">
                <div class="gauge">
                    <div class="slice-colors">
                        <div class="st slice-item"></div>
                        <div class="st slice-item"></div>
                        <div class="st slice-item"></div>
                        <div class="st slice-item"></div>
                        <div class="st slice-item"></div>
                    </div>
                    <div class="needle" data-rotation="<?= $rotationDegree ?>"></div>
                    <div class="gauge-center">
                        <div class="label">UITSLAG</div>
                        <div class="number"><?= htmlspecialchars($translatedOverallScore['scale']) ?></div>
                    </div>
                </div>
            </div>

           
        <?php else: ?>
            <p>Er is nog geen data beschikbaar. Vul de dagelijkse vragenlijst in om je score te zien.</p>
        <?php endif; ?>
    </div>
    <div class="health-section">
                    <div class="health-item">&nbsp;</div>
            </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateGauge() {
                const needle = document.querySelector('.needle');
                const rotation = parseInt(needle.getAttribute('data-rotation'));
                const numberDiv = document.querySelector('.gauge-center .number');
                
                
                needle.classList.remove('onvoldoende', 'voldoende', 'goed');

                if (rotation === 26) {
                    numberDiv.textContent = 'Onvoldoende'; 
                    document.getElementById('slechte_gezondheid').style.display = 'block';
                    needle.classList.add('onvoldoende');
                } else if (rotation === 89) {
                    numberDiv.textContent = 'Voldoende'; 
                    document.getElementById('gemiddelde_gezondheid').style.display = 'block';
                    needle.classList.add('voldoende');
                } else if (rotation === 153) {
                    numberDiv.textContent = 'Goed'; 
                    document.getElementById('goede_gezondheid').style.display = 'block';
                    needle.classList.add('goed');
                } else {
                    numberDiv.textContent = 'Onbekend';
                }

                // Forceer opnieuw tekenen om de animatie opnieuw te starten
                numberDiv.style.animation = 'none';
                numberDiv.offsetHeight; // Forceer opnieuw tekenen
                numberDiv.style.animation = '';
            }

            updateGauge(); // Roep de functie aan om de meter bij te werken
        });
    </script>

    <script>
        // Functie om uit te loggen
        function handleLogout() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../includes/uitloggen.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = "../../index.php"; // Redirect naar de hoofdpagina na uitloggen
                }
            };
            xhr.send("logout=1"); // Stuur logout-verzoek naar de server
        }

        // Voeg een click event listener toe aan het logout-item
        document.getElementById('logoutItem').addEventListener('click', handleLogout);
    </script>
</body>
</html>
