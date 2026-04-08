<?php
require_once 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("Access Denied");
}

$message = "";

if (isset($_POST['import'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, "r");
        
        fgetcsv($handle);
        
        $count = 0;
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            if (empty($row[0]) || empty($row[1])) {
                continue; 
            }

            $accession = trim($row[0]);
            $title     = isset($row[1]) ? trim($row[1]) : "Unknown Title";
            $author    = isset($row[2]) ? trim($row[2]) : "Unknown Author";
            $publisher = isset($row[3]) ? trim($row[3]) : '';
            $isbn      = isset($row[4]) ? trim($row[4]) : '';
            $copies    = isset($row[5]) && is_numeric($row[5]) ? (int)$row[5] : 1;

            if (strlen($accession) > 50 || strlen($title) > 200 || strlen($author) > 100) {
                continue;
            }
            
            if (preg_match('/[^\x20-\x7E]/', $accession) || 
                preg_match('/[^\x20-\x7E]/', $title) || 
                preg_match('/[^\x20-\x7E]/', $author)) {
                continue;
            }

            try {
                $stmt = $pdo->prepare("INSERT INTO books (accession_no, title, author, publisher, isbn, copies) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE copies = ?");
                $stmt->execute([$accession, $title, $author, $publisher, $isbn, $copies, $copies]);
                $count++;
            } catch (Exception $e) {
                continue; 
            }
        }
        fclose($handle);
        $message = "Successfully imported $count books!";
    } else {
        $message = "Please upload a valid CSV file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Import</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="images/logo.png" alt="SGJ Logo" class="header-logo" onerror="this.style.display='none'">
            <span class="header-text">SGJ LIBRARY</span>
        </div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>

    <div class="container container-wide">
        <div class="auth-card" style="margin-top: 20px;">
            <h2>Import Books (Simple Version)</h2>
        <?php if($message) echo "<p style='color:green; font-weight:bold;'>$message</p>"; ?>
        
        <form method="post" enctype="multipart/form-data" style="color: #0B3C5D;">
            <label style="color: #0B3C5D; font-weight: 600; display: block; margin-bottom: 8px;">Select CSV File:</label>
            <input type="file" name="csv_file" accept=".csv" required style="color: #212529; background: #f8f9fa; margin-bottom: 16px;">
            <button type="submit" name="import" class="btn btn-primary">Upload &amp; Import</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-info" style="display:inline-block; margin-top: 15px;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>