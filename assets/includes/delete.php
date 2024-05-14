<?php
include '../includes/dbconfig.php';

// Check if user ID is provided and if it's a valid integer
if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $userId = $_GET['id'];

    try {
        // Prepare and execute SQL query to delete the user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        
        // Redirect back to the admin dashboard after deletion
        header("Location: ../assets/admin/Dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Handle errors if query fails
        echo "Error deleting user: " . $e->getMessage();
    }
} else {
    // If user ID is not provided or invalid, redirect back to the admin dashboard
    header("Location: ../assets/admin/Dashboard.php");
    exit();
}
?>
