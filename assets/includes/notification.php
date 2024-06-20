<?php
require_once 'dbconfig.php';
session_start();

header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Unknown error occurred'];

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $receiveNotifications = isset($_POST['receive_notifications']) ? intval($_POST['receive_notifications']) : 0;

    try {
        $updateQuery = "UPDATE users SET receive_notifications = ? WHERE id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        if ($updateStmt->execute([$receiveNotifications, $userId])) {
            $response['status'] = 'success';
            $response['message'] = 'Notification preference updated to ' . $receiveNotifications;
        } else {
            $response['message'] = 'Failed to execute update query';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'User not logged in';
}

echo json_encode($response);
exit;
?>
