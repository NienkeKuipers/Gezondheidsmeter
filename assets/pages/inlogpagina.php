<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="../../css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="green-top"></div> <!-- Green top section -->
    <div class="container">
        <div class="main">
            <p class="sign">log in</p>
            <?php 
                // Definieer een lege foutmelding
                $error_message = "";

                // Controleer of de foutmelding is ingesteld en toon deze
                if(isset($_SESSION['error_message'])) {
                    $error_message = $_SESSION['error_message'];
                    // Maak de sessievariabele vrij
                    unset($_SESSION['error_message']);
                }
            ?>
            <?php if(!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="form1" action="../includes/inlog.php" method="POST">
                <label for="username">Email Address</label>
                <input class="un" type="text" placeholder="Username" name="username" id="username" required>
                <label for="password">Wachtwoord</label>
                <input class="pass" type="password" placeholder="Password" name="password" id="password" required>
                <button class="submit" type="submit">log in <span class="arrow-right">&#8594;</span></button> <!-- Added arrow -->
                <p class="forgot">Heb je nog geen account? <a href="registreerpagina.php">Registreer hier</a>.</p>
            </form>
            <?php include "../includes/footer.php"; ?>
        </div>
    </div>
</body>

</html>
