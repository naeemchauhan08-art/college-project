<?php
require_once 'db.php';
if (!isAdmin()) { header("Location: index.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO books (title, author, accession_no, publisher, copies) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['author'], $_POST['acc_no'], $_POST['publisher'], $_POST['copies']]);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fas fa-plus-circle"></i> Add New Book</div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>

    <div class="container">
        <div class="auth-card" style="margin-top: 20px;">
            <h2>Add New Book</h2>
            <form method="POST">
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="acc_no" placeholder="Accession Number" required>
                <input type="text" name="publisher" placeholder="Publisher">
                <input type="number" name="copies" placeholder="Number of Copies" min="1" value="1" required>
                <button type="submit" class="btn btn-primary">Add Book</button>
                <a href="index.php" class="btn">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>