<?php
require_once 'db.php';
if (!isAdmin()) { header("Location: index.php"); exit(); }

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit();
}

// Fetch book
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    header("Location: index.php");
    exit();
}

// Update book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, accession_no=?, publisher=?, copies=? WHERE id=?");
    $stmt->execute([$_POST['title'], $_POST['author'], $_POST['acc_no'], $_POST['publisher'], $_POST['copies'], $id]);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fas fa-edit"></i> Edit Book</div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>

    <div class="container">
        <div class="auth-card" style="margin-top: 20px;">
            <h2>Edit Book</h2>
            <form method="POST">
                <input type="text" name="title" placeholder="Book Title" value="<?= htmlspecialchars($book['title']) ?>" required>
                <input type="text" name="author" placeholder="Author" value="<?= htmlspecialchars($book['author']) ?>" required>
                <input type="text" name="acc_no" placeholder="Accession Number" value="<?= htmlspecialchars($book['accession_no']) ?>" required>
                <input type="text" name="publisher" placeholder="Publisher" value="<?= htmlspecialchars($book['publisher']) ?>">
                <input type="number" name="copies" placeholder="Number of Copies" min="1" value="<?= $book['copies'] ?>" required>
                <button type="submit" class="btn btn-primary">Update Book</button>
                <a href="index.php" class="btn">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>