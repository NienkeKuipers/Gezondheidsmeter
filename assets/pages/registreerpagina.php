<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreer</title>
    <link rel="stylesheet" href="../../css/registreer.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="../../index.php">Home</a></li>
        <li><a href="inlogpagina.php">Login</a></li>
    </ul>
</nav>
<div class="main">
    <p class="sign" align="center">Registreer</p>
    <form class="form1" action="../includes/registreerpagina.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required style="width: 100%; height:40px;"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob"><br>

        <input type="submit" value="Register">
        <p>Already have an account? <a href="inlogpagina.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>
