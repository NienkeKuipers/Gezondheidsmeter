<?php
session_start();
include '../includes/dbconfig.php';


if (!isset($_SESSION['current_question_id'])) {
    $_SESSION['current_question_id'] = 1;
}

// Haal de huidige vraag op uit de sessie
$current_question_id = $_SESSION['current_question_id'];


$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$current_question_id]);
$question = $stmt->fetch();

if ($question) {

    $options_stmt = $pdo->prepare("SELECT * FROM options WHERE question_id = ?");
    $options_stmt->execute([$current_question_id]);
    $options = $options_stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikerstest</title>
    <link rel="stylesheet" href="../../css/test.css">
    <script>
        function selectOption(button) {

            const buttons = document.querySelectorAll('.option-btn');
            buttons.forEach(btn => btn.classList.remove('selected'));

            button.classList.add('selected');
        }

        function goBack() {
            document.getElementById('goBackForm').submit();
        }
    </script>
</head>
<body>
    <form id="goBackForm" method="POST" action="">
        <input type="hidden" name="goBack" value="1">
    </form>
    <button class="back-btn" onclick="goBack()"></button>
    <div class="container">
        <?php if ($question): ?>
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
                <button type="submit" name="submit" class="btn">Volgende</button>
            </form>
        <?php else: ?>
            <p>Geen vragen meer beschikbaar.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['goBack'])) {
       
        if ($_SESSION['current_question_id'] > 1) {
            $_SESSION['current_question_id']--;
        }
    } else {
        if (isset($_POST['selectedOption']) && $_POST['selectedOption'] !== '') {
            $selected_option = $_POST['selectedOption'];

            // Sla het antwoord op in de database
            $user_id = 1; 
            $response_date = date("Y-m-d");
            $insert_response_stmt = $pdo->prepare("INSERT INTO user_responses (user_id, question_id, option_id, date, response_date)
                                                   VALUES (?, ?, ?, '0000-00-00', ?)");
            $insert_response_stmt->execute([$user_id, $current_question_id, $selected_option, $response_date]);

            $_SESSION['current_question_id']++;
        }
    }

   
    header("Location: gebruikerstest.php");
    exit();
}
?>
