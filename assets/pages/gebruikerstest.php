<?php
session_start(); 
require_once '../includes/dbconfig.php'; 

// Als de gebruiker niet ingelogd is, laat een bericht zien en stop het script
if (!isset($_SESSION['user_id'])) {
    echo '<p>Log in om de vragenlijst te bekijken.</p>';
    exit;
}

// Sla de ID van de gebruiker en de huidige datum op
$userId = $_SESSION['user_id'];
$currentDate = date('Y-m-d'); // Huidige datum

// Begin met de eerste vraag als er nog geen vraag is geselecteerd
if (!isset($_SESSION['current_question_id'])) {
    $_SESSION['current_question_id'] = 1; // Zet op 1 voor user friendly weergave
}

// Haal het totaal aantal vragen op
$total_questions_stmt = $pdo->query("SELECT COUNT(*) FROM questions");
$total_questions = $total_questions_stmt->fetchColumn(); // Totaal aantal vragen

// Haal de huidige vraag op uit de sessie
$current_question_id = $_SESSION['current_question_id'];

// Haal de huidige vraag en opties op
$stmt = $pdo->prepare("SELECT q.id, q.text, o.id as option_id, o.text as option_text 
                       FROM questions q 
                       JOIN options o ON q.id = o.question_id 
                       WHERE q.id = ?");
$stmt->execute([$current_question_id]);
$questionsOptions = $stmt->fetchAll(PDO::FETCH_ASSOC); // Haal de vraag en opties op

// Bereken de voortgang in procenten
if ($total_questions > 1) {
    $progress = (($current_question_id) / $total_questions) * 100;

    if ($current_question_id == ($total_questions)) {
        $progress = 90; // Laatste vraag toont 90%
    }

    if (!empty($questionsOptions) && $questionsOptions[0]['id'] == 1) {
        $progress = 0; // Eerste vraag toont 0%
    }

} else {
    $progress = 0; // Als er maar één vraag is, zet voortgang op 0%
}

$question = null; // Variabele voor de vraag
$options = []; // Array voor de opties
if ($questionsOptions) {
    $question = [
        'id' => $questionsOptions[0]['id'],
        'text' => $questionsOptions[0]['text']
    ];
    foreach ($questionsOptions as $item) {
        $options[] = [
            'id' => $item['option_id'],
            'text' => $item['option_text']
        ];
    }
}

// Verwerk de formulierinzending
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Controleer of het formulier is verzonden
    if (isset($_POST['goBack'])) { // Als de gebruiker terug wil naar de vorige vraag
        if ($_SESSION['current_question_id'] > 1) {
            $_SESSION['current_question_id']--; // Ga één vraag terug
        }
    } else { // Als de gebruiker een antwoord heeft gekozen en op 'Volgende' klikt
        if (isset($_POST['selectedOption']) && $_POST['selectedOption'] !== '') {
            $selected_option = $_POST['selectedOption'];

            // Controleer of er al een antwoord bestaat voor de huidige vraag
            $check_stmt = $pdo->prepare("SELECT * FROM user_responses WHERE user_id = ? AND question_id = ?");
            $check_stmt->execute([$userId, $current_question_id]);
            $existing_response = $check_stmt->fetch();

            if ($existing_response) {
                // Update het bestaande antwoord
                $update_stmt = $pdo->prepare("UPDATE user_responses SET option_id = ?, response_date = ? WHERE user_id = ? AND question_id = ?");
                $update_stmt->execute([$selected_option, $currentDate, $userId, $current_question_id]);
            } else {
                // Voeg een nieuw antwoord toe
                $insert_stmt = $pdo->prepare("INSERT INTO user_responses (user_id, question_id, option_id, response_date)
                                              VALUES (?, ?, ?, ?)");
                $insert_stmt->execute([$userId, $current_question_id, $selected_option, $currentDate]);
            }

            if ($_SESSION['current_question_id'] < $total_questions) {
                $_SESSION['current_question_id']++; // Ga naar de volgende vraag
            } else {
                header("Location: ../pages/gebruikersresultaten.php"); // Als alle vragen zijn beantwoord, ga naar de resultatenpagina
                exit();
            }
        }
    }

    header("Location: gebruikerstest.php"); // Laad de pagina opnieuw om de volgende vraag te tonen
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikerstest</title>
    <link rel="stylesheet" href="../../css/vragenlijst.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://i.imgur.com/SN48E3D.png" type="image/png">
    <style>
        .progress-bar-fill {
            height: 100%;
            width: <?php echo min(100, round($progress)); ?>%;
            background: linear-gradient(to right, #4caf50, #81c784);
            transition: width 0.4s ease;
        }
    </style>
    <script>
        // Functie om een optie te selecteren
        function selectOption(button) {
            const buttons = document.querySelectorAll('.option-btn');
            buttons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        }

        // Functie om terug te gaan naar de vorige vraag
        function goBack() {
            document.getElementById('goBackForm').submit();
        }
    </script>
</head>
<body>
    <form id="goBackForm" method="POST" action="">
        <input type="hidden" name="goBack" value="1">
    </form>

    <div class="container">
    <div class="header">
            <div class="profile-section">
            <div class="back-button" onclick="location.href='gebruikersdashboard.php'">
            <i class="fa fa-arrow-left"></i>
    </div>
    <h1> Vragenlijst </h1>
        </div>
       
        <?php if ($question): ?>
            <div class="progress-bar">
                <div class="progress-bar-fill"></div>
                <div class="progress-bar-text"><?php echo min(100, round($progress)); ?>%</div>
            </div>
            <form method="POST" action="">
                <h3><?php echo htmlspecialchars($question['text']); ?></h3>
                <div class="options">
                    <?php if ($options): ?>
                        <?php foreach ($options as $option): ?>
                            <label class="option-btn">
                                <input type="radio" name="selectedOption" value="<?php echo htmlspecialchars($option['id']); ?>" onclick="selectOption(this.parentElement)">
                                <?php echo htmlspecialchars($option['text']); ?>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Geen opties beschikbaar.</p>
                    <?php endif; ?>
                </div>
                <button type="submit" name="submit" class="btn">
                    <?php echo $current_question_id == $total_questions ? 'Indienen' : 'Volgende'; ?>
                </button>
            </form>
        <?php else: ?>
            <p>Je hebt alle vragen beantwoord.</p>
            <?php header("Location: ../pages/gebruikersresultaten.php"); exit(); ?>
        <?php endif; ?>
    </div>
</body>
</html>
