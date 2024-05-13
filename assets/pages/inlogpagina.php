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
        <form action="process_login.php" method="POST">
            <div class="oval-input">
                <span class="icon">&#9993; email adress</span>
                <input type="text" id="email" name="email" placeholder="Email adres" required>
            </div>
            <br>
            <div class="oval-input">
                <span class="icon">&#128274; Wachtwoord</span>
                <input type="password" id="password" name="password" placeholder="Wachtwoord" required>
            </div>
            <br>
            <input type="submit" value="Log in">
        </form>
        <p>Nog geen account? <a href="registreerpagina.php">Registreer</a></p>
    </main>
    <footer>
        <p>&copy; 2024 Gezondheidsmeter. All rights reserved.</p>
    </footer>
</body>
</html>
