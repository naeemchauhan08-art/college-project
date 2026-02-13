<?php
require_once 'db.php';

// Get book title from URL parameter
$book_title = isset($_GET['title']) ? trim($_GET['title']) : '';

if (empty($book_title)) {
    header("Location: index.php");
    exit();
}

// Fetch all copies of the same book title
$stmt = $pdo->prepare("
    SELECT b.*, 
           (b.copies - COALESCE(issued.issued_count, 0) - COALESCE(pending.pending_count, 0)) as available_copies,
           COALESCE(issued.issued_count, 0) as issued_count,
           COALESCE(pending.pending_count, 0) as pending_count
    FROM books b 
    LEFT JOIN (
        SELECT book_id, SUM(CASE WHEN status = 'Issued' THEN 1 ELSE 0 END) as issued_count 
        FROM borrow_records GROUP BY book_id
    ) issued ON b.id = issued.book_id
    LEFT JOIN (
        SELECT book_id, SUM(copies_requested) as pending_count
        FROM borrow_requests
        WHERE status = 'pending'
        GROUP BY book_id
    ) pending ON b.id = pending.book_id
    WHERE b.title = ?
    ORDER BY b.id ASC
");
$stmt->execute([$book_title]);
$book_copies = $stmt->fetchAll();

if (empty($book_copies)) {
    header("Location: index.php");
    exit();
}

// Get the first book as main reference for common details
$main_book = $book_copies[0];

// Calculate totals
$total_copies = array_sum(array_column($book_copies, 'copies'));
$total_available = array_sum(array_column($book_copies, 'available_copies'));
$total_issued = array_sum(array_column($book_copies, 'issued_count'));
$total_pending = array_sum(array_column($book_copies, 'pending_count'));

// Handle success messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'requested') {
        $success = "Request submitted successfully!";
    }
}

// Handle book request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_copy'])) {
    if (isLoggedIn() && isStudent()) {
        $book_id = (int)$_POST['book_id'];
        $user_id = $_SESSION['user_id'];
        $qty = max(1, (int)($_POST['copies_requested'] ?? 1));
        
        // Capture current page and search from the form
        $current_page = isset($_POST['current_page']) ? $_POST['current_page'] : 1;
        $current_search = isset($_POST['current_search']) ? $_POST['current_search'] : '';

        // Check if already requested
        $stmt = $pdo->prepare("SELECT id FROM borrow_requests WHERE user_id = ? AND book_id = ? AND status = 'pending'");
        $stmt->execute([$user_id, $book_id]);
        
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("INSERT INTO borrow_requests (user_id, book_id, copies_requested, status) VALUES (?, ?, ?, 'pending')");
            $stmt->execute([$user_id, $book_id, $qty]);
            // Redirect back to the book details page with success message
            $redirect_url = "book_details.php?title=" . urlencode($_GET['title']);
            if (isset($_GET['page'])) $redirect_url .= "&page=" . $_GET['page'];
            if (isset($_GET['search'])) $redirect_url .= "&search=" . urlencode($_GET['search']);
            $redirect_url .= "&msg=requested";
            header("Location: $redirect_url");
            exit();
        } else {
            $error = "You already have a pending request for this copy.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($main_book['title']) ?> - SGJ Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="book-details-modal">
        <div class="book-details-content">
            <div class="book-details-header">
                <h2><i class="fas fa-book"></i> <?= htmlspecialchars($main_book['title']) ?></h2>
                <button class="close-book-details" onclick="window.location.href='index.php'">&times;</button>
            </div>
            
            <div class="book-details-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <!-- Book Summary -->
                <div class="book-summary">
                    <h3><i class="fas fa-info-circle"></i> Book Information</h3>
                    <p><strong>Author:</strong> <?= htmlspecialchars($main_book['author']) ?></p>
                    <p><strong>Publisher:</strong> <?= htmlspecialchars($main_book['publisher'] ?? 'Not specified') ?></p>
                    
                    <div class="total-stats">
                        <div class="stat-card">
                            <div class="number"><?= $total_copies ?></div>
                            <div class="label">Total Copies</div>
                        </div>
                        <div class="stat-card">
                            <div class="number"><?= $total_available ?></div>
                            <div class="label">Available</div>
                        </div>
                        <div class="stat-card">
                            <div class="number"><?= $total_issued ?></div>
                            <div class="label">Issued</div>
                        </div>
                        <div class="stat-card">
                            <div class="number"><?= $total_pending ?></div>
                            <div class="label">Pending</div>
                        </div>
                    </div>
                </div>
                
                <!-- All Copies -->
                <div class="book-info-section">
                    <h3><i class="fas fa-copy"></i> Available Copies (<?= count($book_copies) ?>)</h3>
                    <div class="copies-grid">
                        <?php foreach ($book_copies as $book): 
                            $avail = $book['available_copies'];
                            $status_class = $avail > 0 ? 'available' : 'issued';
                            $status_text = $avail > 0 ? "Available ($avail)" : "Out of Stock";
                        ?>
                        <div class="copy-card">
                            <div class="copy-card-header">
                                <h4>Copy #<?= $book['id'] ?></h4>
                                <span class="accession-number"><?= htmlspecialchars($book['accession_no']) ?></span>
                            </div>
                            
                            <div class="copy-details">
                                <p><strong>Publisher:</strong> <span><?= htmlspecialchars($book['publisher'] ?? 'Not specified') ?></span></p>
                                <p><strong>Total Copies:</strong> <span><?= $book['copies'] ?></span></p>
                                <p><strong>Issued:</strong> <span><?= $book['issued_count'] ?></span></p>
                                <p><strong>Pending:</strong> <span><?= $book['pending_count'] ?></span></p>
                            </div>
                            
                            <span class="status <?= $status_class ?>"><?= $status_text ?></span>
                            
                            <?php if (isStudent()): ?>
                                <div class="copy-actions">
                                    <?php if ($avail > 0): ?>
                                        <form method="POST" style="flex: 1; margin: 0;">
                                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                            <input type="hidden" name="current_page" value="<?= isset($_GET['page']) ? $_GET['page'] : 1 ?>">
                                            <input type="hidden" name="current_search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                            <input type="number" name="copies_requested" value="1" min="1" max="<?= min(4, $avail) ?>" style="width: 100%; margin-bottom: 0.8rem; padding: 0.6rem; border: 1px solid var(--border-dark); border-radius: 4px;">
                                            <button type="submit" name="request_copy" class="btn btn-primary btn-sm">Request Copy</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>No Copies Available</button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isAdmin()): ?>
                                <div class="copy-actions">
                                    <a href="edit_book.php?id=<?= $book['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="index.php?delete_book=<?= $book['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this copy permanently?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Close modal when clicking outside
        document.querySelector('.book-details-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                window.location.href = 'index.php';
            }
        });
        
        // Close with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.href = 'index.php';
            }
        });
    </script>
</body>
</html>