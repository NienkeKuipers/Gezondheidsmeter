<?php
include '../includes/dbconfig.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    try {
        // Prepare and execute the SQL query to update user details
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $userId]);

        // Redirect back to the dashboard after successful update
        header("Location: ../admin/dashboard.php");
        exit;
    } catch (PDOException $e) {
        // Handle errors if query fails
        echo "Error updating user: " . $e->getMessage();
    }
} else {
    // Fetch user details for the given user ID
    $userId = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle errors if query fails
        echo "Error fetching user details: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../css/edit.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
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
    <div class="container">
        <a href="../admin/dashboard.php" class="back-button">Terug naar Dashboard</a>
        <h2>Edit User</h2>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
