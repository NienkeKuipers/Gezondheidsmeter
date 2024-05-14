<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <h1>Login Gezondheidsmeter</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <li><a href="inlogpagina.php">Login</a></li>
            <li><a href="registreerpagina.php">Register</a></li>
        </ul>
    </nav>
    <main>
        <!-- Tonen van de foutmelding -->
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

        <form action="../includes/inlog.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
            <p>Heb je geen account? <a href="registreerpagina.php">Klik hier</a> om te registreren.</p>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Gezondheidsmeter. All rights reserved.</p>
    </footer>
</body>
</html>
