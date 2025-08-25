<?php
// Database connection test file
// Delete this file after testing

require_once 'config/Database.php';

echo "=== Database Configuration Test ===\n";
echo "Host: " . host . "\n";
echo "Database: " . dbname . "\n";
echo "Username: " . username . "\n";
echo "Password: " . (empty(password) ? '[EMPTY]' : '[SET - ' . strlen(password) . ' characters]') . "\n";
echo "\n";

try {
    $pdo = new PDO('mysql:host='.host.';dbname='.dbname, username, password);
    echo "✅ Database connection successful!\n";
} catch(PDOException $e) {
    echo "❌ Database connection failed:\n";
    echo $e->getMessage() . "\n";
}
?>
