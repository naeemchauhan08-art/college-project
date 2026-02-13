<?php
require_once 'db.php';

// 1. Security Check
if (!isAdmin()) {
    header("Location: index.php");
    exit();
}

// 2. Handle Actions (Approve/Reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['request_id'])) {
        $req_id = $_POST['request_id'];
        $action = $_POST['action'];

        try {
            $pdo->beginTransaction();

            // Get request details
            $stmt = $pdo->prepare("SELECT book_id, user_id, copies_requested FROM borrow_requests WHERE id = ?");
            $stmt->execute([$req_id]);
            $request = $stmt->fetch();

            if ($request) {
                if ($action === 'approve') {
                    // Check stock one last time
                    $stmt = $pdo->prepare("SELECT copies FROM books WHERE id = ?");
                    $stmt->execute([$request['book_id']]);
                    $book = $stmt->fetch();
                    
                    // Count currently issued
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM borrow_records WHERE book_id = ? AND status = 'Issued'");
                    $stmt->execute([$request['book_id']]);
                    $issued = $stmt->fetchColumn();

                    $available = $book['copies'] - $issued;

                    if ($available >= $request['copies_requested']) {
                        // Create Borrow Record
                        $stmt = $pdo->prepare("INSERT INTO borrow_records (user_id, book_id, status) VALUES (?, ?, 'Issued')");
                        $stmt->execute([$request['user_id'], $request['book_id']]);
                        
                        // Update Request Status
                        $stmt = $pdo->prepare("UPDATE borrow_requests SET status = 'approved' WHERE id = ?");
                        $stmt->execute([$req_id]);
                        $msg = "Request approved successfully.";
                    } else {
                        $err = "Not enough copies available to approve this request.";
                    }
                }
            }
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            $err = "Error: " . $e->getMessage();
        }
    }
}

// 3. Fetch Requests (REMOVED 'created_at' to fix the error)
$stmt = $pdo->query(
    "SELECT br.id, u.name, b.title, br.copies_requested, br.status
    FROM borrow_requests br
    JOIN users u ON br.user_id = u.id
    JOIN books b ON br.book_id = b.id
    WHERE br.status = 'pending'
    ORDER BY br.id ASC"
);
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Requests</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fas fa-tasks"></i> Manage Requests</div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>

    <div class="container">
        <?php if (isset($msg)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if (isset($err)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <div class="auth-card" style="max-width: 1000px; margin: 0 auto; text-align: left;">
            <h2 class="section-title">Pending Approvals</h2>

            <?php if (count($requests) > 0): ?>
                <table class="track-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Book Title</th>
                            <th>Copies</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td><?= htmlspecialchars($req['name']) ?></td>
                            <td><?= htmlspecialchars($req['title']) ?></td>
                            <td><strong><?= $req['copies_requested'] ?></strong></td>
                            
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn-sm btn-success" onclick="return confirm('Approve this request?')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--success-color); margin-bottom: 10px;"></i>
                    <p>All caught up! No pending requests.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>