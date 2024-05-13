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
        <form action="../includes/inlog.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
            <p>Heb je geen account? <a href="registreerpagina.php">Klik hier</a> om te registreren.</p>
        </form>
        <p>Nog geen account? <a href="registreerpagina.php">Registreer</a></p>
    </main>
    <footer>
        <p>&copy; 2024 Gezondheidsmeter. All rights reserved.</p>
    </footer>
</body>
</html>
