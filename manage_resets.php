<?php
require_once 'db.php';
if (!isAdmin()) { header("Location: index.php"); exit(); }

function generateRandomPassword($length = 8) {
    $chars = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
    return substr(str_shuffle($chars), 0, $length);
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_reset'])) {
    $request_id = $_POST['request_id'];
    $user_id = $_POST['user_id'];
    
    $plain_password = generateRandomPassword();
    
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
    
    $updateUser = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateUser->execute([$hashed_password, $user_id]);
    
    $updateReq = $pdo->prepare("UPDATE password_resets SET status = 'completed', temp_password_shown = ? WHERE id = ?");
    $updateReq->execute([$plain_password, $request_id]);
    
    $msg = "Password reset! Share this new password with the user — it is their permanent login password: <strong>" . htmlspecialchars($plain_password) . "</strong>";
}

$requestsQuery = "SELECT pr.*, u.name, u.email, u.role 
                  FROM password_resets pr 
                  JOIN users u ON pr.user_id = u.id 
                  ORDER BY pr.status ASC, pr.request_date DESC";
$requests = $pdo->query($requestsQuery)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Password Resets - SGJ Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="images/logo.png" alt="SGJ Logo" class="header-logo" onerror="this.style.display='none'">
            <span class="header-text">SGJ LIBRARY</span>
        </div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
    
    <div class="container container-wide">
        <?php if ($msg): ?>
            <div class="alert alert-success" style="font-size: 1.1rem; padding: 15px;">
                <i class="fas fa-check-circle"></i> <?= $msg ?>
            </div>
        <?php endif; ?>

        <div class="admin-dashboard" style="background: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <h2 style="color: #0B3C5D; font-size: 1.6rem; font-weight: 700; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 3px solid #FFD700; text-align: center;">
                Password Reset Requests
            </h2>
            <table class="track-table admin-table">
                <thead>
                    <tr>
                        <th>Date Requested</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action / Info</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($requests) > 0): ?>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td><?= date('M j, Y g:i A', strtotime($req['request_date'])) ?></td>
                            <td><?= htmlspecialchars($req['name']) ?></td>
                            <td><?= htmlspecialchars($req['email']) ?></td>
                            <td><span class="status <?= $req['role'] == 'Admin' ? 'available' : 'issued' ?>"><?= htmlspecialchars($req['role']) ?></span></td>
                            <td>
                                <?php if($req['status'] == 'pending'): ?>
                                    <span class="status issued">Pending</span>
                                <?php else: ?>
                                    <span class="status available">Completed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($req['status'] == 'pending'): ?>
                                    <form method="POST" style="margin: 0;">
                                        <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $req['user_id'] ?>">
                                        <button type="submit" name="approve_reset" class="btn btn-success btn-sm" onclick="return confirm('Generate a new password for this user?');">
                                            <i class="fas fa-key"></i> Generate Reset
                                        </button>
                                    </form>
                                <?php elseif($req['status'] == 'completed' && !empty($req['temp_password_shown'])): ?>
                                    <span style="color:#0B3C5D; font-weight:bold;">New Password: <?= htmlspecialchars($req['temp_password_shown']) ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No password reset requests found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
