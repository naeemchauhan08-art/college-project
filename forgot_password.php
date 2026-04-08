<?php
require_once 'db.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_request'])) {
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $checkStmt = $pdo->prepare("SELECT id FROM password_resets WHERE user_id = ? AND status = 'pending'");
        $checkStmt->execute([$user['id']]);
        if ($checkStmt->rowCount() == 0) {
            $stmt = $pdo->prepare("INSERT INTO password_resets (user_id) VALUES (?)");
            $stmt->execute([$user['id']]);
            $msg = "Request sent! Please contact the Librarian to get your new password.";
        } else {
            $err = "You already have a pending password reset request.";
        }
    } else {
        $err = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - SGJ Library</title>
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
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>

    <div class="container">
        <div class="auth-section">
            <div class="auth-card">
                <h2>Forgot Password</h2>
                <p>Enter your registered email address to request a password reset from the Admin.</p>
                
                <?php if ($msg): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
                <?php endif; ?>
                <?php if ($err): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="email" name="email" placeholder="Your Email Address" required>
                    <button type="submit" name="submit_request" class="btn btn-primary">Request Reset</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
