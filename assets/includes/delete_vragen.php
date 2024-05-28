<?php
include 'dbconfig.php';

if (isset($_GET['id'])) {
    $questionId = $_GET['id'];

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Delete user responses associated with the options of the question
        $stmt = $pdo->prepare("DELETE ur FROM user_responses ur
                               JOIN options o ON ur.option_id = o.id
                               WHERE o.question_id = ?");
        $stmt->execute([$questionId]);

        // Delete options associated with the question
        $stmt = $pdo->prepare("DELETE FROM options WHERE question_id = ?");
        $stmt->execute([$questionId]);

        // Delete the question itself
        $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
        $stmt->execute([$questionId]);

        // Commit transaction
        $pdo->commit();

        // Redirect back to vragen.php with success message
        header("Location: ../admin/vragen.php?delete_success=1");
        exit;
    } catch (PDOException $e) {
        // Rollback transaction in case of error
        $pdo->rollBack();
        echo "Error deleting question: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid question ID!";
    exit;
}
?>
