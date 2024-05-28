<?php
include '../includes/dbconfig.php';

// Fetch all health pillars for the dropdown
try {
    $stmt = $pdo->prepare("SELECT id, name FROM health_pillars");
    $stmt->execute();
    $health_pillars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout bij het ophalen van gezondheidszuilen: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pillar_id = $_POST['pillar_id'];
    $question_text = $_POST['question_text'];
    $options = $_POST['options'];
    
    try {
        // Insert the new question
        $stmt = $pdo->prepare("INSERT INTO questions (pillar_id, text) VALUES (?, ?)");
        $stmt->execute([$pillar_id, $question_text]);
        $question_id = $pdo->lastInsertId();

        // Insert the options
        $stmt = $pdo->prepare("INSERT INTO options (question_id, text, points) VALUES (?, ?, ?)");
        foreach ($options as $option) {
            $stmt->execute([$question_id, $option['text'], $option['points']]);
        }

        $success = "Vraag en opties succesvol toegevoegd.";
        
        // Redirect to vragen.php after adding question
        header("Location: ../admin/vragen.php");
        exit();
    } catch (PDOException $e) {
        $error = "Fout bij het toevoegen van vraag: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vraag Toevoegen</title>
    <link rel="stylesheet" href="../../css/add_vraag.css">
</head>
<body>
    <div class="container">
        <h2>Vraag Toevoegen</h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="pillar_id">Gezondheidszuil</label>
            <select id="pillar_id" name="pillar_id" required>
                <?php foreach ($health_pillars as $pillar): ?>
                    <option value="<?php echo $pillar['id']; ?>"><?php echo $pillar['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="question_text">Vraagtekst</label>
            <textarea id="question_text" name="question_text" rows="3" required></textarea>
            
            <div id="options-container">
                <div class="option-container">
                    <label for="option_1">Optie 1</label>
                    <input type="text" id="option_1" name="options[0][text]" required>
                    <label for="points_1">Punten</label>
                    <input type="number" id="points_1" name="options[0][points]" required>
                </div>
            </div>

            <button type="button" onclick="addOption()">Nog een Optie Toevoegen</button>
            <button type="submit">Vraag Opslaan</button>
        </form>
    </div>

    <script>
        let optionCount = 1;

        function addOption() {
            optionCount++;
            const container = document.getElementById('options-container');
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('option-container');
            optionDiv.innerHTML = `
                <label for="option_${optionCount}">Optie ${optionCount}</label>
                <input type="text" id="option_${optionCount}" name="options[${optionCount - 1}][text]" required>
                <label for="points_${optionCount}">Punten</label>
                <input type="number" id="points_${optionCount}" name="options[${optionCount - 1}][points]" required>
            `;
            container.appendChild(optionDiv);
        }
    </script>
</body>
</html>
