<?php
require_once 'db.php';

// --- HANDLE ACTIONS ---
if (isset($_GET['delete_book']) && isAdmin()) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$_GET['delete_book']]);
    header("Location: index.php?msg=deleted");
    exit();
}

// Handle book requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_book'])) {
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
            // REDIRECT back to the exact same page and search query
            header("Location: index.php?msg=requested&page=" . $current_page . "&search=" . urlencode($current_search));
            exit();
        } else {
            $error = "You already have a pending request for this book.";
        }
    }
}

// Login/Logout Logic (Kept same as before)
if (isset($_GET['logout'])) { session_destroy(); header("Location: index.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php"); exit();
    } else {
        $error = "Invalid email or password";
    }
}

// Pagination settings
$items_per_page = 12; // Show 12 books per page
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $items_per_page;

// Fetch Books - GROUPED by title
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Group books by title to show one entry per unique title
$grouped_sql = "SELECT 
    b.title,
    b.author,
    GROUP_CONCAT(b.id ORDER BY b.id) as book_ids,
    GROUP_CONCAT(b.accession_no ORDER BY b.id) as accession_numbers,
    GROUP_CONCAT(b.publisher ORDER BY b.id) as publishers,
    SUM(b.copies) as total_copies,
    SUM(COALESCE(issued.issued_count, 0)) as total_issued,
    SUM(COALESCE(pending.pending_count, 0)) as total_pending,
    SUM(b.copies - COALESCE(issued.issued_count, 0) - COALESCE(pending.pending_count, 0)) as total_available
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
GROUP BY b.title, b.author";

// Count total unique titles for pagination
$count_sql = "SELECT COUNT(DISTINCT b.title) FROM books b 
LEFT JOIN (
    SELECT book_id, SUM(CASE WHEN status = 'Issued' THEN 1 ELSE 0 END) as issued_count 
    FROM borrow_records GROUP BY book_id
) issued ON b.id = issued.book_id
LEFT JOIN (
    SELECT book_id, SUM(copies_requested) as pending_count
    FROM borrow_requests
    WHERE status = 'pending'
    GROUP BY book_id
) pending ON b.id = pending.book_id";

if ($search) {
    $count_stmt = $pdo->prepare($count_sql . " WHERE b.title LIKE ? OR b.author LIKE ?");
    $count_stmt->execute(["%$search%", "%$search%"]);
    $total_books = $count_stmt->fetchColumn();
    
    $stmt = $pdo->prepare($grouped_sql . " WHERE b.title LIKE ? OR b.author LIKE ? ORDER BY b.title ASC LIMIT ? OFFSET ?");
    $stmt->execute(["%$search%", "%$search%", $items_per_page, $offset]);
} else {
    $total_books = $pdo->query($count_sql)->fetchColumn();
    $stmt = $pdo->prepare($grouped_sql . " ORDER BY b.title ASC LIMIT ? OFFSET ?");
    $stmt->execute([$items_per_page, $offset]);
}

$books = $stmt->fetchAll();

// Calculate total pages
$total_pages = ceil($total_books / $items_per_page);

// Pagination helper function
function generatePagination($current_page, $total_pages, $total_books, $search = '') {
    $pagination_html = '<div class="pagination-container">';
    
    // Previous button
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        $search_param = $search ? "&search=" . urlencode($search) : "";
        $pagination_html .= '<a href="?page=' . $prev_page . $search_param . '" class="prev">Previous</a>';
    } else {
        $pagination_html .= '<span class="prev disabled">Previous</span>';
    }
    
    // Page numbers
    $pagination_html .= '<ul class="pagination">';
    
    // Show first page
    if ($current_page > 3) {
        $search_param = $search ? "&search=" . urlencode($search) : "";
        $pagination_html .= '<li><a href="?page=1' . $search_param . '">1</a></li>';
        if ($current_page > 4) {
            $pagination_html .= '<li><span>...</span></li>';
        }
    }
    
    // Show pages around current page
    $start = max(1, $current_page - 2);
    $end = min($total_pages, $current_page + 2);
    
    for ($i = $start; $i <= $end; $i++) {
        $search_param = $search ? "&search=" . urlencode($search) : "";
        if ($i == $current_page) {
            $pagination_html .= '<li><span class="active">' . $i . '</span></li>';
        } else {
            $pagination_html .= '<li><a href="?page=' . $i . $search_param . '">' . $i . '</a></li>';
        }
    }
    
    // Show last page
    if ($current_page < $total_pages - 2) {
        if ($current_page < $total_pages - 3) {
            $pagination_html .= '<li><span>...</span></li>';
        }
        $search_param = $search ? "&search=" . urlencode($search) : "";
        $pagination_html .= '<li><a href="?page=' . $total_pages . $search_param . '">' . $total_pages . '</a></li>';
    }
    
    $pagination_html .= '</ul>';
    
    // Next button
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        $search_param = $search ? "&search=" . urlencode($search) : "";
        $pagination_html .= '<a href="?page=' . $next_page . $search_param . '" class="next">Next</a>';
    } else {
        $pagination_html .= '<span class="next disabled">Next</span>';
    }
    
    // Page info
    $start_item = ($current_page - 1) * 12 + 1;
    $end_item = min($current_page * 12, $total_books);
    $pagination_html .= '<div class="page-info">Showing ' . $start_item . ' - ' . $end_item . ' of ' . $total_books . ' books</div>';
    
    $pagination_html .= '</div>';
    
    return $pagination_html;
}

// Handle success/error messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'requested') {
        $success = "Request submitted successfully!";
    } elseif ($_GET['msg'] === 'deleted') {
        $success = "Book deleted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SGJ Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fas fa-book-reader"></i> SGJ Library</div>
        <div class="user-info">
            <?php if (isLoggedIn()): ?>
                <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?> (<?= $_SESSION['role'] ?>)</span>
                
                <?php if (isStudent()): ?>
                    <button onclick="openModal()" class="btn-info">
                        <i class="fas fa-list-ul"></i> Track My Requests
                    </button>
                <?php endif; ?>



                <a href="?logout=1" class="btn btn-danger btn-sm">Logout</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <?php if (isset($error)): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
        <?php if (isset($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

        <?php if (!isLoggedIn()): ?>
             <div class="auth-section">
                <div class="auth-card">
                    <h2>Admin/Student Login</h2>
                    <form method="POST">
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </form>
                </div>
             </div>
        <?php else: ?>

            <?php if (isAdmin()): ?>
                <div class="admin-section">
                    <h2>Admin Dashboard</h2>
                    
                    <div class="admin-toolbar">
                        <a href="manage_requests.php" class="admin-action-card card-requests">
                            <i class="fas fa-tasks"></i> Manage Requests
                        </a>
                        <a href="add_book.php" class="admin-action-card card-add">
                            <i class="fas fa-plus-circle"></i> Add Book
                        </a>
                        <a href="manage_users.php" class="admin-action-card card-users">
                            <i class="fas fa-users-cog"></i> Manage Users
                        </a>
                        <a href="simple_import.php" class="admin-action-card card-import">
                            <i class="fas fa-file-csv"></i> Import CSV
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="search-bar">
                <form method="GET">
                    <input type="text" name="search" placeholder="🔍 Search by Book Name, Author, or Accession No..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn">Search</button>
                </form>
            </div>

            <div class="books-grid">
                <?php foreach ($books as $grouped_book): 
                    $total_avail = $grouped_book['total_available'];
                    $total_copies = $grouped_book['total_copies'];
                    $status_text = $total_avail > 0 ? "Available ($total_avail/$total_copies)" : "All Copies Out ($total_copies)";
                    $status_class = $total_avail > 0 ? 'available' : 'issued';
                ?>
                <div class="book-card">
                    <h3><a href="book_details.php?title=<?= urlencode($grouped_book['title']) ?>" style="color: inherit; text-decoration: none;"><?= htmlspecialchars(substr($grouped_book['title'], 0, 50)) ?></a></h3>
                    <p>by <?= htmlspecialchars($grouped_book['author']) ?></p>
                    <p class="details"><i class="fas fa-copy"></i> <?= count(explode(',', $grouped_book['book_ids'])) ?> copies available</p>
                    <span class="status <?= $status_class ?>">
                        <?= $status_text ?>
                    </span>

                    <?php if (isAdmin()): ?>
                        <div class="admin-book-controls">
                            <a href="book_details.php?title=<?= urlencode($grouped_book['title']) ?>" class="btn-icon btn-edit">
                                <i class="fas fa-eye"></i> View All Copies
                            </a>
                            <a href="add_book.php" class="btn-icon btn-success">
                                <i class="fas fa-plus"></i> Add Copy
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (isStudent()): ?>
                        <?php if ($total_avail > 0): ?>
                        <div class="unavailable-msg">
                            <small style="color: var(--success); font-style: italic;">
                                <i class="fas fa-check"></i> <?= $total_avail ?> of <?= $total_copies ?> copies available
                            </small>
                            <br>
                            <a href="book_details.php?title=<?= urlencode($grouped_book['title']) ?>" class="btn btn-info btn-sm" style="margin-top: 10px;">
                                <i class="fas fa-list"></i> View/Request Copies
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="unavailable-msg">
                            <small style="color: #e74c3c; font-style: italic;">
                                <i class="fas fa-times"></i> All <?= $total_copies ?> copies are currently borrowed
                            </small>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ($total_books > $items_per_page): ?>
                <?= generatePagination($current_page, $total_pages, $total_books, $search) ?>
            <?php endif; ?>

        <?php endif; ?>
    </div>
    <!-- Track Status Modal -->
    <div id="trackModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-history"></i> My Borrow Requests</h3>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>
            
            <div class="modal-body">
                <table class="track-table">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Copies</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isLoggedIn() && isStudent()) {
                            $user_id = $_SESSION['user_id'];
                            // Fetch requests for this specific student
                            $track_stmt = $pdo->prepare(
                                "SELECT br.*, b.title 
                                FROM borrow_requests br 
                                JOIN books b ON br.book_id = b.id 
                                WHERE br.user_id = ? 
                                ORDER BY br.id DESC LIMIT 10"
                            );
                            $track_stmt->execute([$user_id]);
                            $my_requests = $track_stmt->fetchAll();

                            if ($my_requests) {
                                foreach ($my_requests as $req) {
                                    // Color logic for badges
                                    $badgeClass = 'issued';
                                    if ($req['status'] == 'approved') $badgeClass = 'available';
                                    if ($req['status'] == 'rejected') $badgeClass = 'issued';
                                    
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars(substr($req['title'], 0, 30)) . "</td>";
                                    echo "<td style='text-align:center'>" . $req['copies_requested'] . "</td>";
                                    echo "<td><span class='status $badgeClass'>" . ucfirst($req['status']) . "</span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' style='text-align:center'>No requests found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript to handle the popup
        function openModal() {
            document.getElementById('trackModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('trackModal').style.display = 'none';
        }
        // Close modal if user clicks outside the white box
        window.onclick = function(event) {
            if (event.target == document.getElementById('trackModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>