<?php
require_once 'db.php';

// Check if user is logged in and is an admin
if (!isLoggedIn() || !isAdmin()) {
    $_SESSION['error'] = "Admin access required.";
    header("Location: index.php#admin-dashboard");
    exit();
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: index.php#admin-dashboard");
    exit();
}

// Validate CSRF token
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
    // Get the request details
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
        // Check if book is still available
        $available_copies = getBookAvailability($request['book_id']);
        $requested_qty = (int)$request['copies_requested'];
        
        if ($requested_qty > $available_copies) {
            $_SESSION['error'] = "Only $available_copies copy/copies available, but request was for $requested_qty copies.";
        } else {
            // Start transaction
            $pdo->beginTransaction();
            
            // Update the borrow request status to approved
            $stmt = $pdo->prepare("UPDATE borrow_requests SET status = 'approved' WHERE id = ?");
            $stmt->execute([$request_id]);
            
            // Create multiple borrow records based on requested quantity
            $stmt = $pdo->prepare("INSERT INTO borrow_records (user_id, book_id, issued_on, due_on, status) 
                VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 'Issued')");
            
            for ($i = 0; $i < $requested_qty; $i++) {
                $stmt->execute([$request['user_id'], $request['book_id']]);
            }
            
            // Commit transaction
            $pdo->commit();
            
            $_SESSION['success'] = "Borrow request for $requested_qty copy/copies approved successfully for " . htmlspecialchars($request['username']) . " - " . htmlspecialchars($request['title']);
        }
    } elseif ($action === 'reject') {
        // Update the borrow request status to rejected
        $stmt = $pdo->prepare("UPDATE borrow_requests SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$request_id]);
        
        $_SESSION['success'] = "Borrow request rejected for " . htmlspecialchars($request['username']) . " - " . htmlspecialchars($request['title']);
    } else {
        $_SESSION['error'] = "Invalid action.";
    }
} catch (PDOException $e) {
    // Rollback transaction if something went wrong
    if ($pdo->inTransaction()) {
        $pdo->rollback();
    }
    
    error_log("Error processing request: " . $e->getMessage());
    $_SESSION['error'] = "Error processing request. Please try again.";
}

// Redirect back to the main page
header("Location: index.php#admin-dashboard");
exit();
?>