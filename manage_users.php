<?php
require_once 'db.php';
if (!isAdmin()) { header("Location: index.php"); exit(); }

$reset_msg = '';

// Delete User Logic
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_users.php");
    exit();
}

// Direct Admin Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $user_id = (int)$_POST['reset_user_id'];
    // Fetch user to make sure they exist and are not admin
    $chk = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
    $chk->execute([$user_id]);
    $target = $chk->fetch();
    if ($target && $target['role'] !== 'Admin') {
        // Generate random 8-char password
        $chars = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        $plain = substr(str_shuffle($chars), 0, 8);
        $hashed = password_hash($plain, PASSWORD_BCRYPT);
        $upd = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $upd->execute([$hashed, $user_id]);
        $reset_msg = "Password for <strong>" . htmlspecialchars($target['name']) . "</strong> has been reset. Give them this temporary password: <strong style='font-size:1.2rem; letter-spacing:2px;'>" . htmlspecialchars($plain) . "</strong>";
    }
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
        <div class="logo-container">
            <img src="images/logo.png" alt="SGJ Logo" class="header-logo" onerror="this.style.display='none'">
            <span class="header-text">User Management</span>
        </div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>
    <div class="container container-wide">
        <div class="admin-container" style="background:#fff; border-radius:12px; padding:30px; box-shadow:0 4px 16px rgba(0,0,0,0.10);">
            <h2 style="color:var(--primary); font-size:1.6rem; font-weight:700; margin-bottom:20px; padding-bottom:12px; border-bottom:3px solid var(--accent);">User Management</h2>
            <?php if ($reset_msg): ?>
                <div class="alert alert-success" style="font-size:1.05rem; padding:15px; margin-bottom:18px;">
                    <i class="fas fa-key"></i> <?= $reset_msg ?>
                </div>
            <?php endif; ?>
            <table class="track-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Name</th>
                        <th style="text-align:left;">Email</th>
                        <th style="text-align:center;">Role</th>
                        <th style="text-align:center;">Reset Password</th>
                        <th style="text-align:center;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td style="text-align:left;"><?= htmlspecialchars($u['name']) ?></td>
                        <td style="text-align:left;"><?= htmlspecialchars($u['email']) ?></td>
                        <td style="text-align:center;"><span class="status <?= $u['role'] == 'Admin' ? 'available' : 'issued' ?>"><?= $u['role'] ?></span></td>
                        <td style="text-align:center;">
                            <?php if ($u['role'] !== 'Admin'): ?>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Reset password for <?= htmlspecialchars(addslashes($u['name'])) ?>?');">
                                    <input type="hidden" name="reset_user_id" value="<?= $u['id'] ?>">
                                    <button type="submit" name="reset_password" class="btn-sm" style="background:var(--primary); color:#fff; border:none; border-radius:6px; padding:5px 12px; cursor:pointer;">
                                        <i class="fas fa-key"></i> Reset
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
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
    <?php include 'footer.php'; ?>
</body>
</html>