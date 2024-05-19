<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
</head>
<body>
    <div id="app">
        <div class="side-bar">
            <ul>
                <li><a href="gebruikersdashboard.php">Dashboard</a></li>
                <li><a href="gebruikerstest.php">Vragenlijst</a></li>
                <li><a href="gebruikersresultaten.php">Resultaten</a></li>
                <li><a href="gebruikersaccount.php">Account</a></li>
                <li><a href="gebruikersinstellingen.php">Instellingen</a></li>
                <li id="logoutItem" style="cursor: pointer;">Uitloggen</li>
            </ul>
        </div>
        <div class="main">
            <div class="nav-bar"> 
                <h1>Gezondheidsmeter</h1>
            </div>
            <div class="content">
                <h1>This is the content area</h1>
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
