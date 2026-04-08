<?php
require_once 'db.php';

if (!isLoggedIn()) {
    $_SESSION['error'] = "Please log in to return books.";
    header("Location: index.php");
    exit();
}

if (!isStudent()) {
    $_SESSION['error'] = "Only students can return books.";
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: index.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Invalid CSRF token.";
    header("Location: index.php");
    exit();
}

$borrow_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($borrow_id <= 0) {
    $_SESSION['error'] = "Invalid borrow record ID.";
    header("Location: index.php");
    exit();
}

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

try {
    $pdo->beginTransaction();
    
    $stmt = $pdo->prepare("UPDATE borrow_records SET status = 'Returned', returned_on = NOW() WHERE id = ?");
    $stmt->execute([$borrow_id]);
    
    $pdo->commit();
    
    $_SESSION['success'] = "Book '" . htmlspecialchars($borrow_record['title']) . "' returned successfully!";
} catch (PDOException $e) {
    $pdo->rollback();
    error_log("Error returning book: " . $e->getMessage());
    $_SESSION['error'] = "Error returning book. Please try again.";
}

header("Location: index.php");
exit();
?>