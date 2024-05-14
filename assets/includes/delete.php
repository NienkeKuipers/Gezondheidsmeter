<?php
include '../includes/dbconfig.php';

// Controleer of de gebruikers-ID is opgegeven
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    try {
        // Verwijder eerst de gerelateerde gegevens uit de user_responses-tabel
        $stmt = $pdo->prepare("DELETE FROM user_responses WHERE user_id = ?");
        $stmt->execute([$userId]);

        // Verwijder vervolgens de gebruiker uit de users-tabel
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);

        // Redirect naar de admin dashboard-pagina na succesvol verwijderen
        header("Location: ../admin/Dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Geef een foutmelding weer als het verwijderen mislukt
        echo "Error deleting user: " . $e->getMessage();
    }
} else {
    // Geef een foutmelding weer als er geen gebruikers-ID is opgegeven
    echo "User ID not specified.";
}
?>
