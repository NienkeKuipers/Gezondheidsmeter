<?php
include '../includes/dbconfig.php';

try {
    // Prepare and execute SQL query to fetch non-admin users
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE is_admin = 0");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle errors if query fails
    echo "Error fetching users: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
<header>
    <div class="container">
        <nav>
            <ul class="nav-links">
                <li><a href="Dashboard.php">Dashboard</a></li>
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
        <h2>Admin Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="../includes/edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="../includes/delete.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('toggle');
    });
</script>
</html>
