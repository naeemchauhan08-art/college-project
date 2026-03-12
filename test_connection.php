<?php
// Test script to check database connection and errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

try {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'sgj_library_db');
    
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Test if users table exists and has data
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Users table exists</p>";
        
        // Count users
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch()['count'];
        echo "<p style='color: blue;'>Found $count users in database</p>";
        
        // Show sample users
        $stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY role, name LIMIT 10");
        $users = $stmt->fetchAll();
        
        echo "<h3>Sample Users:</h3>";
        echo "<table border='1' style='background: white; color: black;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
        foreach ($users as $user) {
            echo "<tr style='background: white;'>";
            echo "<td style='color: black;'>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td style='color: black;'>" . htmlspecialchars($user['name']) . "</td>";
            echo "<td style='color: black;'>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td style='color: black;'>" . htmlspecialchars($user['role']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>✗ Users table does not exist</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<h2>PHP Info</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Check session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo "<p>Session status: " . session_status() . "</p>";

?>
