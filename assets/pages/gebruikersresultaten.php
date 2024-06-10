<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
</head>
<body>
    <?php
        session_start();
        // Assuming the user's name is stored in the session
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    ?>
    <div id="app" class="mobile-layout">
        <div class="header">
            <div class="profile-section">
                <h2>Welkom <?php echo htmlspecialchars($username); ?></h2>
            </div>
        </div>
        <div class="health-section">
            <div class="health-item">Steps<br>10,000</div>
            <div class="health-item">Calories Burned<br>500</div>
            <div class="health-item">Water Intake<br>2L</div>
        </div>
        <div id="slechte_gezondheid">
    <h3>Slechte Gezondheid (onvoldoende)</h3>
    <p>Je gezondheid bevindt zich op een zorgelijk niveau. Dit kan betekenen dat je onvoldoende beweegt, slecht eet, te weinig water drinkt, of andere ongezonde gewoonten hebt. Het is belangrijk om actie te ondernemen en gezondere keuzes te maken om je algehele welzijn te verbeteren.</p>
</div>

<div id="gemiddelde_gezondheid">
    <h3>Gemiddelde Gezondheid (gemiddeld)</h3>
    <p>Je gezondheid is redelijk, maar er is nog ruimte voor verbetering. Je doet sommige dingen goed, zoals voldoende beweging en een redelijke voeding, maar er zijn nog gebieden die aandacht nodig hebben. Probeer een evenwichtigere levensstijl te vinden voor betere resultaten.</p>
</div>

<div id="goede_gezondheid">
    <h3>Goede Gezondheid (goed)</h3>
    <p>Gefeliciteerd! Je gezondheid is op een uitstekend niveau. Dit betekent dat je goed voor jezelf zorgt door regelmatig te bewegen, gezond te eten, voldoende water te drinken, en andere gezonde gewoonten te onderhouden. Blijf zo doorgaan om je welzijn te behouden.</p>
</div>

        <div class="wrapper">
            <div class="gauge">
                <div class="slice-colors">
                    <div class="st slice-item"></div>
                    <div class="st slice-item"></div>
                    <div class="st slice-item"></div>
                    <div class="st slice-item"></div>
                    <div class="st slice-item"></div>
                </div>
                <div class="needle"></div>
                <div class="gauge-center">
                    <div class="label">UITSLAG</div>
                    <div class="number">GOED</div>
                </div>
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
