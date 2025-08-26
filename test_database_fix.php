<?php
// Test script to verify Database connection and Model inheritance
// Run this to test if the Carwash_model works correctly

// Include all necessary files (same as index.php)
require_once 'libs/Model.php';
require_once 'config/paths.php';
require_once 'libs/Database.php';

echo "Testing Database Connection and Model Inheritance...\n\n";

try {
    // Test Database class directly
    echo "1. Testing Database class:\n";
    $db = new Database();
    echo "   ✅ Database class instantiated successfully\n";
    
    // Test Model class
    echo "\n2. Testing Model class:\n";
    $model = new Model();
    echo "   ✅ Model class instantiated successfully\n";
    echo "   ✅ Model has db property: " . (isset($model->db) ? "Yes" : "No") . "\n";
    
    // Test Carwash_model class
    echo "\n3. Testing Carwash_model class:\n";
    require_once 'models/Carwash_model.php';
    $carwashModel = new Carwash_model();
    echo "   ✅ Carwash_model instantiated successfully\n";
    echo "   ✅ Carwash_model has db property: " . (isset($carwashModel->db) ? "Yes" : "No") . "\n";
    
    // Test a simple database query
    echo "\n4. Testing database query:\n";
    $packages = $carwashModel->getAllPackages();
    echo "   ✅ Database query executed successfully\n";
    echo "   📊 Found " . count($packages) . " packages\n";
    
    echo "\n🎉 All tests passed! The include issue has been resolved.\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
