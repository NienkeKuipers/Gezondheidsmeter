<?php
include '../includes/dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionId = $_POST['id'];
    $questionText = $_POST['text'];
    $pillarId = $_POST['pillar_id'];
    $options = $_POST['options'];

    try {
        // Update question
        $stmt = $pdo->prepare("UPDATE questions SET text = ?, pillar_id = ? WHERE id = ?");
        $stmt->execute([$questionText, $pillarId, $questionId]);

        // Update options
        foreach ($options as $optionId => $option) {
            $stmtOption = $pdo->prepare("UPDATE options SET text = ?, points = ? WHERE id = ?");
            $stmtOption->execute([$option['text'], $option['points'], $optionId]);
        }

        // Redirect back to vragen.php
        header("Location: ../admin/vragen.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating question: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
