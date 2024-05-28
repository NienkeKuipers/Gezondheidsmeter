<?php
include '../includes/dbconfig.php';

try {
    // Prepare and execute SQL query to fetch all questions
    $stmt = $pdo->prepare("SELECT q.id, q.text, p.name as pillar_name FROM questions q JOIN health_pillars p ON q.pillar_id = p.id");
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle errors if query fails
    echo "Error fetching questions: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions Management</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
<header>
    <div class="container">
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
    <h2>Questions Management</h2>
    <table>
        <thead>
            <tr>
                <th>Vragen</th>
                <th>Onderwerp</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
<<<<<<< HEAD
                    
                    <th>Question</th>
                    <th>Pillar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        
                        <td><?php echo $question['text']; ?></td>
                        <td><?php echo $question['pillar_name']; ?></td>
                        <td>
                            <a href="../includes/edit_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
=======
                    <td data-label="Vragen"><?php echo htmlspecialchars($question['text']); ?></td>
                    <td data-label="Onderwerp"><?php echo htmlspecialchars($question['pillar_name']); ?></td>
                    <td data-label="Action">
                        <a href="edit_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_vragen.php?id=<?php echo $question['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
>>>>>>> 1622eb5de19fbf936265e129402921ab5acfcb47
<script>
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('toggle');
    });
</script>
</body>
</html>
