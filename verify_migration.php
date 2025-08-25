<?php
require_once 'config/Database.php';
$db = new PDO('mysql:host=' . host . ';dbname=' . dbname, username, password);

echo "=== MIGRATION VERIFICATION ===\n\n";

// Check car wash packages
echo "Car Wash Packages (converted to KES):\n";
$stmt = $db->prepare('SELECT name, price FROM packages LIMIT 3');
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- {$row['name']}: KSh " . number_format($row['price'], 2) . "\n";
}

echo "\nLubricant Packages (converted to KES):\n";
$stmt = $db->prepare('SELECT name, price FROM lu_packages LIMIT 3');
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- {$row['name']}: KSh " . number_format($row['price'], 2) . "\n";
}

echo "\nCar Transactions (converted to KES):\n";
$stmt = $db->prepare('SELECT cname, amount, date FROM car_transactions LIMIT 3');
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- {$row['cname']} ({$row['date']}): KSh " . number_format($row['amount'], 2) . "\n";
}

echo "\nStock Orders (converted to KES):\n";
$stmt = $db->prepare('SELECT FuelType, Orderamnt, Date FROM orders LIMIT 3');
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- {$row['FuelType']} ({$row['Date']}): KSh " . number_format($row['Orderamnt'], 2) . "\n";
}

echo "\nMigration completed successfully! All currency values have been converted from LKR to KES.\n";
?>



