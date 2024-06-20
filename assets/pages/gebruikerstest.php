<?php
session_start();
include '../includes/dbconfig.php';

if (!isset($_SESSION['current_question_id'])) {
    $_SESSION['current_question_id'] = 1;
}

// Haal de huidige vraag op uit de sessie
$current_question_id = $_SESSION['current_question_id'];

// Haal het totaal aantal vragen op
$total_questions_stmt = $pdo->query("SELECT COUNT(*) FROM questions");
$total_questions = $total_questions_stmt->fetchColumn();

// Bereken de voortgang in procenten
$progress = ($current_question_id / $total_questions) * 100;

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
    <style>
        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
            height: 30px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-fill {
            height: 100%;
            width: <?php echo $progress; ?>%;
            background: linear-gradient(to right, #4caf50, #81c784);
            text-align: center;
            line-height: 30px;
            color: white;
            font-weight: bold;
            border-radius: 20px;
            transition: width 0.4s ease;
        }
    </style>
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
    <button class="back-btn" onclick="goBack()">Terug</button>
    <div class="container">
        <div class="progress-bar">
            <div class="progress-bar-fill"><?php echo round($progress); ?>%</div>
        </div>
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
