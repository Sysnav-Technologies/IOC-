<?php
// Simple test to verify file access
header('Content-Type: text/plain');

echo "=== IOC File Access Test ===\n\n";

// Test 1: Check if files exist
$testFiles = [
    'bower_components/jquery/dist/jquery.min.js',
    'bower_components/bootstrap.min.js',
    'bower_components/bootstrap-material-design/dist/js/material.min.js',
    'bower_components/bootstrap-material-design/dist/js/ripples.min.js',
    '.htaccess',
    'index.php'
];

echo "File Existence Test:\n";
foreach ($testFiles as $file) {
    $exists = file_exists($file) ? '✅ EXISTS' : '❌ MISSING';
    $size = file_exists($file) ? ' (' . filesize($file) . ' bytes)' : '';
    echo "  $file: $exists$size\n";
}

echo "\nURL Constants Test:\n";
require_once 'config/paths.php';
echo "  URL: " . URL . "\n";
echo "  BOWER: " . BOWER . "\n";

echo "\nDirect File Content Test:\n";
$jqueryPath = 'bower_components/jquery/dist/jquery.min.js';
if (file_exists($jqueryPath)) {
    $content = file_get_contents($jqueryPath, false, null, 0, 100);
    $isJavaScript = strpos($content, '/*') !== false || strpos($content, 'function') !== false || strpos($content, 'var') !== false;
    echo "  jQuery file starts with: " . htmlspecialchars(substr($content, 0, 50)) . "...\n";
    echo "  Looks like JavaScript: " . ($isJavaScript ? 'YES' : 'NO') . "\n";
} else {
    echo "  jQuery file not found\n";
}

echo "\nServer Environment:\n";
echo "  HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "  REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "\n";
echo "  SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "\n";
echo "  DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set') . "\n";

echo "\n=== Test Complete ===\n";
?>
