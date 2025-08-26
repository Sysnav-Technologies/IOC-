<?php
/**
 * Universal Static File Server for IOC System
 * Handles all CSS, JS, images, fonts when .htaccess fails
 */

// Get the requested file path
$requestPath = $_GET['file'] ?? '';

if (empty($requestPath)) {
    http_response_code(400);
    die('No file specified. Usage: serve-static.php?file=path/to/file.js');
}

// Security: prevent directory traversal
if (strpos($requestPath, '..') !== false || strpos($requestPath, '\\') !== false) {
    http_response_code(403);
    die('Access denied: Invalid path');
}

// Clean the path
$requestPath = ltrim($requestPath, '/');

// Map of allowed directories and their patterns
$allowedPaths = [
    'bower_components/',
    'views/dist/',
    'views/css/',
    'views/img/', 
    'views/js/',
    'node_modules/'
];

// Check if the request is for an allowed directory
$isAllowed = false;
foreach ($allowedPaths as $allowedPath) {
    if (strpos($requestPath, $allowedPath) === 0) {
        $isAllowed = true;
        break;
    }
}

if (!$isAllowed) {
    http_response_code(403);
    die('Access denied: Directory not allowed');
}

// Full file path
$filePath = __DIR__ . '/' . $requestPath;

// Check if file exists
if (!file_exists($filePath) || !is_file($filePath)) {
    http_response_code(404);
    die('File not found: ' . htmlspecialchars($requestPath));
}

// Get file extension and set appropriate content type
$extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

$mimeTypes = [
    // JavaScript
    'js'    => 'application/javascript; charset=utf-8',
    // CSS
    'css'   => 'text/css; charset=utf-8',
    // Images
    'png'   => 'image/png',
    'jpg'   => 'image/jpeg',
    'jpeg'  => 'image/jpeg',
    'gif'   => 'image/gif',
    'ico'   => 'image/x-icon',
    'svg'   => 'image/svg+xml',
    'webp'  => 'image/webp',
    // Fonts
    'woff'  => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf'   => 'font/ttf',
    'otf'   => 'font/otf',
    'eot'   => 'application/vnd.ms-fontobject',
    // Other
    'map'   => 'application/json',
    'txt'   => 'text/plain',
    'json'  => 'application/json'
];

$contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

// Set headers for proper loading
header('Content-Type: ' . $contentType);
header('Content-Length: ' . filesize($filePath));

// Cache headers for performance
header('Cache-Control: public, max-age=86400'); // Cache for 1 day
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

// CORS headers for cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Output the file
readfile($filePath);
exit;
?>
