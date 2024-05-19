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
    <div class="container2">
        <div class="main">
            <p class="sign">Registreer</p>
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
            <form class="form1" action="../includes/registreer.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob"><br>


        <button class="submit" type="submit" value="Registreer">Registreer <span class="arrow-right">&#8594;</span></button> <!-- Added arrow -->
        <p>Already have an account? <a href="inlogpagina.php">Login here</a>.</p>
    </form>
            <?php include "../includes/footer.php"; ?>
        </div>
    </div>
</body>

</html>
