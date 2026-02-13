<?php
require_once 'db.php';

// Check if user is logged in
if (!isLoggedIn()) {
    $_SESSION['error'] = "Please log in to return books.";
    header("Location: index.php");
    exit();
}

// Check if user is a student
if (!isStudent()) {
    $_SESSION['error'] = "Only students can return books.";
    header("Location: index.php");
    exit();
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: index.php");
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token.";
    header("Location: index.php");
    exit();
}

// Get the borrow record ID from POST
$borrow_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($borrow_id <= 0) {
    $_SESSION['error'] = "Invalid borrow record ID.";
    header("Location: index.php");
    exit();
}

// Get the borrow record details to verify it belongs to the current user
try {
    $stmt = $pdo->prepare("
        SELECT br.*, b.title, u.id as user_id
        FROM borrow_records br
        JOIN books b ON br.book_id = b.id
        JOIN users u ON br.user_id = u.id
        WHERE br.id = ? AND br.status = 'Issued'
    ");
    $stmt->execute([$borrow_id]);
    $borrow_record = $stmt->fetch();
    
    // Verify that the borrow record exists and belongs to the current user
    if (!$borrow_record) {
        $_SESSION['error'] = "Borrow record not found or already returned.";
        header("Location: index.php");
        exit();
    }
    
    if ($borrow_record['user_id'] != $_SESSION['user_id']) {
        $_SESSION['error'] = "You can only return books that you have borrowed.";
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error fetching borrow record: " . $e->getMessage());
    $_SESSION['error'] = "Error fetching borrow record. Please try again.";
    header("Location: index.php");
    exit();
}

// Process the return
try {
    // Start transaction for data consistency
    $pdo->beginTransaction();
    
    // Update the borrow record status to 'Returned' and set the return date
    $stmt = $pdo->prepare("UPDATE borrow_records SET status = 'Returned', returned_on = NOW() WHERE id = ?");
    $stmt->execute([$borrow_id]);
    
    // Commit the transaction
    $pdo->commit();
    
    $_SESSION['success'] = "Book '" . htmlspecialchars($borrow_record['title']) . "' returned successfully!";
} catch (PDOException $e) {
    // Rollback the transaction in case of error
    $pdo->rollback();
    error_log("Error returning book: " . $e->getMessage());
    $_SESSION['error'] = "Error returning book. Please try again.";
}

// Redirect back to the main page
header("Location: index.php");
exit();
?>