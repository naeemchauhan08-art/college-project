<?php
require_once 'db.php';

$fixed = 0;
$skipped = 0;
$errors = [];

$users = $pdo->query("SELECT id, name, email, password FROM users")->fetchAll();

foreach ($users as $u) {
    $pw = $u['password'];
    if (strpos($pw, '$2y$') === 0 || strpos($pw, '$2a$') === 0) {
        $skipped++;
        continue;
    }
    $hashed = password_hash($pw, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed, $u['id']]);
    $fixed++;
    $errors[] = "Fixed: <strong>" . htmlspecialchars($u['name']) . "</strong> (" . htmlspecialchars($u['email']) . ") — old plain password was: <code>" . htmlspecialchars($pw) . "</code>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Fix Utility</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; padding: 20px; background: #f4f4f4; }
        .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { color: #0B3C5D; border-bottom: 3px solid #FFD700; padding-bottom: 10px; }
        .ok { color: green; } .warn { color: orange; } .info { color: #333; }
        code { background: #eee; padding: 2px 6px; border-radius: 4px; }
        .alert { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 6px; margin-top: 20px; }
        .fixed-item { background: #fff3cd; border: 1px solid #ffc107; padding: 10px; border-radius: 6px; margin: 8px 0; font-size: 0.9rem; }
        .danger { background: #f8d7da; padding: 15px; border-radius: 6px; border: 1px solid #f5c6cb; margin-top: 20px; font-weight: bold; color: #721c24; }
    </style>
</head>
<body>
<div class="card">
    <h2>🔧 Password Fix Utility</h2>

    <p class="ok">✅ Database connected successfully to <code>sgj_library_db</code></p>
    <p class="info">Total users found: <strong><?= count($users) ?></strong></p>
    <p class="ok">✅ Already hashed (skipped): <strong><?= $skipped ?></strong></p>
    <p class="warn">🔄 Plain-text passwords fixed: <strong><?= $fixed ?></strong></p>

    <?php if ($fixed > 0): ?>
        <div class="alert">
            <strong>Fixed the following users:</strong><br><br>
            <?php foreach ($errors as $e): ?>
                <div class="fixed-item"><?= $e ?></div>
            <?php endforeach; ?>
        </div>
        <p class="ok" style="margin-top:15px;">✅ All done! You can now log in normally with the same password as before.</p>
    <?php else: ?>
        <div class="alert">
            ✅ All passwords were already bcrypt hashed. No changes needed.<br>
            If login is still failing, the password entered may just be wrong.
        </div>
    <?php endif; ?>

    <div class="danger">
        ⚠️ DELETE this file (<code>reset_hash.php</code>) after use for security!
    </div>

    <p style="margin-top:20px;"><a href="index.php" style="color:#0B3C5D; font-weight:bold;">← Go to Login Page</a></p>
</div>
</body>
</html>
