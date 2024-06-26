<?php
include '../includes/dbconfig.php';

if (isset($_GET['id'])) {
    $questionId = $_GET['id'];

    try {
        // Fetch question details
        $stmt = $pdo->prepare("SELECT text, pillar_id FROM questions WHERE id = ?");
        $stmt->execute([$questionId]);
        $question = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$question) {
            echo "Question not found!";
            exit;
        }

        // Fetch all pillars for dropdown
        $stmtPillars = $pdo->prepare("SELECT id, name FROM health_pillars");
        $stmtPillars->execute();
        $pillars = $stmtPillars->fetchAll(PDO::FETCH_ASSOC);

        // Fetch options for the question
        $stmtOptions = $pdo->prepare("SELECT id, text, points FROM options WHERE question_id = ?");
        $stmtOptions->execute([$questionId]);
        $options = $stmtOptions->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching question details: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid question ID!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/edit_vraag.css">
    <style>
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <div class="container container2">
        <nav>
            <ul class="nav-links">
                <li><a href="../admin/dashboard.php">Dashboard</a></li>
                <li><a href="../admin/vragen.php">Vragen</a></li>
                <li><a href="../includes/logout.php">Uitloggen</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </div>
</header>

<div class="container">
    <a href="../admin/vragen.php" class="back-button">Terug naar Vragen</a>
    <h2>Bewerk Vraag</h2>
    <form action="update_question.php" method="post">
        <input type="hidden" name="id" value="<?php echo $questionId; ?>">
        <div class="form-group">
            <label for="text">Vragen:</label>
            <textarea id="text" name="text" required><?php echo htmlspecialchars($question['text']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="pillar_id">Onderwerp:</label>
            <select id="pillar_id" name="pillar_id" required>
                <?php foreach ($pillars as $pillar): ?>
                    <option value="<?php echo $pillar['id']; ?>" <?php echo $pillar['id'] == $question['pillar_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($pillar['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="options-container">
            <h3>Opties</h3>
            <?php foreach ($options as $option): ?>
                <div class="form-group">
                    <label for="option_<?php echo $option['id']; ?>">Opties:</label>
                    <input type="text" id="option_<?php echo $option['id']; ?>" name="options[<?php echo $option['id']; ?>][text]" value="<?php echo htmlspecialchars($option['text']); ?>" required>
                    <label for="points_<?php echo $option['id']; ?>">Punten:</label>
                    <input type="number" id="points_<?php echo $option['id']; ?>" name="options[<?php echo $option['id']; ?>][points]" value="<?php echo htmlspecialchars($option['points']); ?>" required>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('toggle');
    });
</script>
</body>
</html>
