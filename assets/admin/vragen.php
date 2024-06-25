<?php
include '../includes/dbconfig.php';

try {
    // Prepare and execute SQL query to fetch all questions
    $stmt = $pdo->prepare("SELECT q.id, q.text, p.name as pillar_name FROM questions q JOIN health_pillars p ON q.pillar_id = p.id");
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle errors if query fails
    echo "Fout bij het ophalen van vragen: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheer van Vragen</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <style>
        .add-button {
            margin-bottom: 20px;
        }
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="vragen.php">Vragen</a></li>
                <li><a href="../includes/uitloggen.php">Uitloggen</a></li>
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
    <a href="dashboard.php" class="back-button">Back</a>
    <h2>Beheer van Vragen</h2>
    <a href="../includes/add_vraag.php" class="btn btn-primary add-button">Vraag Toevoegen</a>
    <table>
        <thead>
            <tr>
                <th>Vraag</th>
                <th>Gezondheidszuil</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?php echo $question['text']; ?></td>
                    <td><?php echo $question['pillar_name']; ?></td>
                    <td>
                        <a href="../includes/edit_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-primary">Bewerken</a>
                        <a href="../includes/delete_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je deze vraag wilt verwijderen?')">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
