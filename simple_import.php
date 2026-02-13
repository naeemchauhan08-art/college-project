<?php
// simple_import.php
require_once 'db.php';

// Remove session_start() because db.php already starts it!
// session_start(); 

// Only Admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("Access Denied");
}

$message = "";

if (isset($_POST['import'])) {
    // Check if file is uploaded
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, "r");
        
        // Skip the first row (Header)
        fgetcsv($handle);
        
        $count = 0;
        // Loop through the file
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            // --- SAFETY CHECK 1: Skip empty rows ---
            // If the first column (Accession No) or second (Title) is empty, skip this row.
            if (empty($row[0]) || empty($row[1])) {
                continue; 
            }

            // --- SAFETY CHECK 2: Validate Data ---
            // Mapping CSV columns to Database variables
            // CSV Order: Accession No, Title, Author, Publisher, ISBN, Copies
            $accession = trim($row[0]);
            $title     = isset($row[1]) ? trim($row[1]) : "Unknown Title";
            $author    = isset($row[2]) ? trim($row[2]) : "Unknown Author";
            $publisher = isset($row[3]) ? trim($row[3]) : '';
            $isbn      = isset($row[4]) ? trim($row[4]) : '';
            $copies    = isset($row[5]) && is_numeric($row[5]) ? (int)$row[5] : 1;

            // --- CORRUPTION PREVENTION: Additional Safety Checks ---
            // Prevent binary data from being inserted into text fields
            if (strlen($accession) > 50 || strlen($title) > 200 || strlen($author) > 100) {
                continue; // Skip rows with suspiciously long fields
            }
            
            // Check for binary/non-printable characters
            if (preg_match('/[^\x20-\x7E]/', $accession) || 
                preg_match('/[^\x20-\x7E]/', $title) || 
                preg_match('/[^\x20-\x7E]/', $author)) {
                continue; // Skip rows with binary/garbage data
            }

            // Simple SQL Insert
            try {
                $stmt = $pdo->prepare("INSERT INTO books (accession_no, title, author, publisher, isbn, copies) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE copies = ?");
                $stmt->execute([$accession, $title, $author, $publisher, $isbn, $copies, $copies]);
                $count++;
            } catch (Exception $e) {
                // If one book fails (like a duplicate ID), just continue to the next one
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
        <div class="logo"><i class="fas fa-file-csv"></i> Import Books</div>
        <div class="user-info">
            <a href="index.php" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            

        </div>
    </div>

    <div class="container">
        <div class="auth-card" style="margin-top: 20px;">
            <h2>Import Books (Simple Version)</h2>
        <?php if($message) echo "<p style='color:green; font-weight:bold;'>$message</p>"; ?>
        
        <form method="post" enctype="multipart/form-data">
            <label>Select CSV File:</label>
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit" name="import" class="btn">Upload & Import</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-info" style="display:inline-block; margin-top: 15px;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>