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
        session_start();
        // Assuming the user's name is stored in the session
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
                <input type="checkbox">
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
        <div class="main-menu">
            <div class="menu-item">
                <img src="../images/check-list.png" alt="Vragenlijst">
                <p>Vragenlijst</p>
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

        // Button success effect
        function removeSuccess() {
            document.querySelector('.button').classList.remove('success');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.button').addEventListener('click', function(event) {
                event.preventDefault();
                this.classList.add('success');
                setTimeout(removeSuccess, 3000);
            });
        });
    </script>
</body>
</html>
