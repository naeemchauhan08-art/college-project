<?php
require_once 'db.php';


echo "<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:20px;}
.ok{color:green;} .skip{color:orange;} .err{color:red;}
pre{background:#f4f4f4;padding:10px;border-radius:6px;}</style>";

echo "<h2>🔧 SGJ Library – Password Fix Tool</h2>";

$users = $pdo->query("SELECT id, name, email, password FROM users")->fetchAll();

if (empty($users)) {
    echo "<p class='err'>No users found in the database. Check your DB connection.</p>";
    exit;
}

$fixed = 0;
$alreadyHashed = 0;

foreach ($users as $u) {
    $pw = $u['password'];

    if (strlen($pw) === 60 && strpos($pw, '$2y$') === 0) {
        echo "<p class='skip'>⏭ <strong>{$u['name']}</strong> ({$u['email']}) — already hashed, skipping.</p>";
        $alreadyHashed++;
        continue;
    }

    $hashed = password_hash($pw, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed, $u['id']]);

    echo "<p class='ok'>✅ <strong>{$u['name']}</strong> ({$u['email']}) — re-hashed successfully.<br>
          &nbsp;&nbsp;&nbsp;&nbsp;Original plain-text was: <code>{$pw}</code></p>";
    $fixed++;
}

echo "<hr>";
echo "<p>Done! <strong>{$fixed}</strong> password(s) fixed, <strong>{$alreadyHashed}</strong> already correct.</p>";

if ($fixed > 0) {
    echo "<p class='ok'><strong>✅ You can now log in normally.</strong></p>";
    echo "<p><a href='index.php'>→ Go to Login Page</a></p>";
}

echo "<hr><p style='color:red;font-weight:bold;'>⚠️ DELETE this file (fix_passwords.php) now that it is done!</p>";
?>
