<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sgj_library_db');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
}

function isStudent() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Student';
}

function getUserDetails($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function getBookAvailability($bookId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT b.copies, 
               COALESCE(SUM(CASE WHEN br.status = 'Issued' THEN 1 ELSE 0 END), 0) as issued_count
        FROM books b
        LEFT JOIN borrow_records br ON b.id = br.book_id
        WHERE b.id = ?
        GROUP BY b.id
    ");
    $stmt->execute([$bookId]);
    $result = $stmt->fetch();
    
    if ($result) {
        return $result['copies'] - $result['issued_count'];
    }
    return 0;
}

function getBookWithAvailability($bookId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT b.*, 
               (b.copies - COALESCE(issued.issued_count, 0)) as available_copies
        FROM books b
        LEFT JOIN (
            SELECT book_id, 
                   SUM(CASE WHEN status = 'Issued' THEN 1 ELSE 0 END) as issued_count
            FROM borrow_records 
            GROUP BY book_id
        ) issued ON b.id = issued.book_id
        WHERE b.id = ?
    ");
    $stmt->execute([$bookId]);
    return $stmt->fetch();
}
?>