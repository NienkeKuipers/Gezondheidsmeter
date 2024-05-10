<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Register for Gezondheidsmeter</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="inlogpagina.php">Login</a></li>
            <li><a href="registreerpagina.php">Register</a></li>
        </ul>
    </nav>
    <main>
        <form action="process_registration.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required style="width: 100%; height:40px;"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <input type="submit" value="Registreer">
            <p>Heb je al een account ? <a href="inlogpagina.php">Login hier</a>.</p>
        </form>
        
    </main>
    <footer>
        <p>&copy; 2024 Gezondheidsmeter. All rights reserved.</p>
    </footer>
</body>
</html>
