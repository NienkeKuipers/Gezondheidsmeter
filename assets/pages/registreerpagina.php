<?php
session_start(); // Start de sessie

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
    <div class="container2">
        <div class="main">
            <p class="sign">Registreer</p>
            <?php 
                // Definieer een lege foutmelding
                $error_message = "";

                // Controleer of de foutmelding is ingesteld en toon deze
                if (isset($_SESSION['error_message'])) {
                    $error_message = $_SESSION['error_message'];
                    // Maak de sessievariabele vrij
                    unset($_SESSION['error_message']);
                }
            ?>
            <!-- Als er een foutmelding is, laat deze zien -->
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="form1" action="../includes/registreer.php" method="POST"> 
                <label for="username">Gebruikersnaam:</label><br>
                <input type="text" id="username" name="username" required><br> 

                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" required><br> 

                <label for="password">Wachtwoord:</label><br>
                <input type="password" id="password" name="password" required><br> 

                <label for="confirm_password">Bevestig Wachtwoord:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br> 

                <button class="submit" type="submit" value="Registreer">Registreer <span class="arrow-right">&#8594;</span></button> 
                <p>Heb je al een account? <a href="inlogpagina.php">Login hier</a>.</p> 
            <?php include "../includes/footer.php"; ?> 
    </div>
</body>

</html>
