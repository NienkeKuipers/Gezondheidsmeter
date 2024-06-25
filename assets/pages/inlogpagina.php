<?php
session_start(); 

// Als de gebruiker al is ingelogd, stuur door naar het dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ../pages/gebruikersdashboard.php');
    exit; // Stop het script
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="../../css/login.css"> 
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> 
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="../../css/style.css"> 
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
</head>

<body>
    <div class="green-top"></div> <!-- Groene bovenkant -->
    <div class="container">
        <div class="main">
            <p class="sign">Log in</p>
            <?php 
                $error_message = ""; 
                // Als er een foutmelding is opgeslagen in de sessie, haal deze op en verwijder daarna
                if (isset($_SESSION['error_message'])) {
                    $error_message = $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
            ?>
            <!-- Als er een foutmelding is, laat deze zien -->
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="form1" action="../includes/inlog.php" method="POST"> 
                <label for="username">Email Address</label>
                <input class="un" type="text" placeholder="Username" name="username" id="username" required> 
                <label for="password">Wachtwoord</label>
                <input class="pass" type="password" placeholder="Password" name="password" id="password" required> 
                <button class="submit" type="submit">Log in <span class="arrow-right">&#8594;</span></button>
                <p class="forgot">Heb je nog geen account? <a href="registreerpagina.php">Registreer hier</a>.</p> 
            </form>
            <?php include "../includes/footer.php"; ?>
        </div>
    </div>
</body>

</html>
