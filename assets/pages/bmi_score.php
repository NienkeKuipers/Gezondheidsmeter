<?php
session_start(); 

// Functie om BMI uit te rekenen
function calculateBMI($weight, $height) {
    if ($height == 0) return 0; // Als lengte 0 is, geef 0 terug, want delen door 0 kan niet
    return $weight / (($height / 100) ** 2); // Bereken BMI en geef het terug
}

// Functie om BMI een betekenis te geven op basis van geslacht
function interpretBMI($bmi, $gender) {
    if ($gender === 'male') { 
        if ($bmi < 20.7) return "ondergewicht"; 
        if ($bmi < 26.4) return "normaal gewicht"; 
        if ($bmi < 27.8) return "licht overgewicht"; 
        if ($bmi < 31.1) return "overgewicht"; 
        return "ernstig overgewicht"; 
    } else if ($gender === 'female') { 
        if ($bmi < 19.1) return "ondergewicht"; 
        if ($bmi < 25.8) return "normaal gewicht"; 
        if ($bmi < 27.3) return "licht overgewicht";
        if ($bmi < 32.3) return "overgewicht"; 
        return "ernstig overgewicht";
    } else {
        return "ongeldige invoer"; 
    }
}

$bmiResult = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Controleer of het formulier is verzonden
    $age = $_POST['age']; 
    $height = $_POST['height']; 
    $weight = $_POST['weight'];
    $gender = $_POST['gender']; 
    $bmi = calculateBMI($weight, $height); 
    $bmiCategory = interpretBMI($bmi, $gender); 
    $bmiResult = "Je BMI is: " . round($bmi, 2) . " (" . $bmiCategory . ")"; 
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Berekenaar</title>
    <link rel="stylesheet" href="../../css/userdashboard.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/account.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="green-top">
    <div class="header">
        <div class="profile-section">
        </div>
    </div>
</div> 
<div id="app" class="mobile-layout">
    <div class="header">
        <div class="profile-section">
        <div class="back-button" onclick="location.href='gebruikersaccount.php'">
        <i class="fa fa-arrow-left"></i>
    </div>
            <h1>BMI Berekenaar</h1>
        </div>
    </div>
    <div class="content">
        <form action="bmi_score.php" method="POST">
            <div class="form-group">
                <label for="age">Leeftijd:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="height">Lengte (cm):</label>
                <input type="number" id="height" name="height" required>
            </div>
            <div class="form-group">
                <label for="weight">Gewicht (kg):</label>
                <input type="number" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="gender">Geslacht:</label>
                <select id="gender" name="gender" required class="form-control">
                    <option value="male">Man</option>
                    <option value="female">Vrouw</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Bereken BMI</button>
            </div>
        </form>

        <?php if ($bmiResult): ?>
            <div class="bmi-result">  
                <p><?php echo $bmiResult; ?> <span class="info-icon" onclick="showPopup()">i</span></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="health-section">
        <div class="health-item">&nbsp;</div>
    </div>

<div class="overlay" id="overlay" onclick="closePopup()"></div>

<div class="popup" id="popup">
    <div class="close-btn">
        <button onclick="closePopup()">×</button>
    </div>
    <img src="../images/bmi_foto.png" alt="BMI Explanation">
</div>

<script>
// Functie om popup te laten zien
function showPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

// Functie om popup te verbergen
function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>
</body>
</html>
