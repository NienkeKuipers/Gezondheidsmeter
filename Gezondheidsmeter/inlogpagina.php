<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogpagina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Login to Gezondheidsmeter</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="inlogpagina.php">Login</a></li>
            <li><a href="registreerpagina.php">Register</a></li>
        </ul>
    </nav>
    <main>
        <form action="process_login.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
            <p>Heb je geen account ? <a href="registreerpagina.php">klik hier</a> voor registreren.</p>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Gezondheidsmeter. All rights reserved.</p>
    </footer>
</body>
</html>
