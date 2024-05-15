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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>
<nav>
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <li><a href="registreerpagina.php">Register</a></li>
        </ul>
    </nav>
    <div class="main">
        <p class="sign" align="center">Login</p>
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
            <p style="color: red;" align="center"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form class="form1" action="../includes/inlog.php" method="POST">
            <input class="username " type="text" align="center" placeholder="Username" name="username" required>
            <input class="pass" type="password" align="center" placeholder="Password" name="password" required>
            <button class="submit" align="center" type="submit">Login</button>
            <p class="forgot" align="center"><a href="#">Heb je nog een account registreer?</a></p>
        </form>
    </div>
</body>

</html>
