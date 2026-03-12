<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';

echo "<h2>Manage Users Debug</h2>";

// Check if user is admin
if (!isAdmin()) {
    echo "<p style='color: red;'>Access denied: Not an admin user</p>";
    echo "<p>Please <a href='index.php'>login as admin</a> first</p>";
} else {
    echo "<p style='color: green;'>✓ Admin access confirmed</p>";
    
    // Fetch Users
    try {
        $users = $pdo->query("SELECT * FROM users ORDER BY role, name")->fetchAll();
        echo "<p style='color: blue;'>Found " . count($users) . " users</p>";
        
        echo "<h3>Users Table (Debug Version)</h3>";
        echo "<table border='1' style='background: white; color: black; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>";
        
        foreach ($users as $u) {
            echo "<tr style='background: white;'>";
            echo "<td style='color: black; background: white;'>" . htmlspecialchars($u['name']) . "</td>";
            echo "<td style='color: black; background: white;'>" . htmlspecialchars($u['email']) . "</td>";
            echo "<td style='color: black; background: white;'>" . htmlspecialchars($u['role']) . "</td>";
            echo "<td style='color: black; background: white;'>";
            if ($u['role'] !== 'Admin') {
                echo "<a href='?delete=" . $u['id'] . "' style='color: red;'>Delete</a>";
            } else {
                echo "Admin";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } catch(PDOException $e) {
        echo "<p style='color: red;'>Error fetching users: " . $e->getMessage() . "</p>";
    }
}

// Show current session info
echo "<h3>Session Info:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
