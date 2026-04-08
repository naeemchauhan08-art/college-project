<?php
require_once 'db.php';

if (!isLoggedIn() || !isAdmin()) {
    $_SESSION['error'] = "Admin access required.";
    header("Location: index.php#admin-dashboard");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: index.php#admin-dashboard");
    exit();
}

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token.";
    header("Location: index.php#admin-dashboard");
    exit();
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$request_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if (empty($action) || $request_id <= 0) {
    $_SESSION['error'] = "Invalid action or request ID.";
    header("Location: index.php#admin-dashboard");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT br.*, u.name as username, u.email, b.title, b.author, br.copies_requested
        FROM borrow_requests br
        JOIN users u ON br.user_id = u.id
        JOIN books b ON br.book_id = b.id
        WHERE br.id = ? AND br.status = 'pending'");
    $stmt->execute([$request_id]);
    $request = $stmt->fetch();
    
    if (!$request) {
        $_SESSION['error'] = "Request not found or already processed.";
        header("Location: index.php#admin-dashboard");
        exit();
    }
    
    if ($action === 'approve') {
        $available_copies = getBookAvailability($request['book_id']);
        $requested_qty = (int)$request['copies_requested'];
        
        if ($requested_qty > $available_copies) {
            $_SESSION['error'] = "Only $available_copies copy/copies available, but request was for $requested_qty copies.";
        } else {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("UPDATE borrow_requests SET status = 'approved' WHERE id = ?");
            $stmt->execute([$request_id]);
            
            $stmt = $pdo->prepare("INSERT INTO borrow_records (user_id, book_id, issued_on, due_on, status) 
                VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 'Issued')");
            
            for ($i = 0; $i < $requested_qty; $i++) {
                $stmt->execute([$request['user_id'], $request['book_id']]);
            }
            
            $pdo->commit();
            
            $_SESSION['success'] = "Borrow request for $requested_qty copy/copies approved successfully for " . htmlspecialchars($request['username']) . " - " . htmlspecialchars($request['title']);
        }
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("UPDATE borrow_requests SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$request_id]);
        
        $_SESSION['success'] = "Borrow request rejected for " . htmlspecialchars($request['username']) . " - " . htmlspecialchars($request['title']);
    } else {
        $_SESSION['error'] = "Invalid action.";
    }
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollback();
    }
    
    error_log("Error processing request: " . $e->getMessage());
    $_SESSION['error'] = "Error processing request. Please try again.";
}

header("Location: index.php#admin-dashboard");
exit();
?>