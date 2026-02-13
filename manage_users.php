<?php
require_once 'db.php';
if (!isAdmin()) { header("Location: index.php"); exit(); }

// Delete User Logic
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_users.php");
}

// Fetch Users
$users = $pdo->query("SELECT * FROM users ORDER BY role, name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fas fa-users-cog"></i> User Management</div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>
    <div class="container">
        <div class="admin-dashboard">
            <table class="track-table">
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="status <?= $u['role'] == 'Admin' ? 'available' : 'issued' ?>"><?= $u['role'] ?></span></td>
                        <td>
                            <?php if ($u['role'] !== 'Admin'): ?>
                                <a href="?delete=<?= $u['id'] ?>" class="btn-sm btn-danger" onclick="return confirm('Delete user?');">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>