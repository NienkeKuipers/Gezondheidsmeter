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
