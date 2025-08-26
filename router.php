<?php
// Router script for PHP built-in server
// This mimics the .htaccess behavior

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Remove leading slash
$path = ltrim($path, '/');

// Check if it's a static file that exists
if (file_exists(__DIR__ . '/' . $path) && is_file(__DIR__ . '/' . $path)) {
    // Let the built-in server handle static files
    return false;
}

// Check for static directories with file extensions
if (preg_match('/^(assets|views|bower_components|libs)\/.*\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
    // Let the built-in server handle static files
    return false;
}

// For all other requests, route through index.php with url parameter
if (!empty($path)) {
    $_GET['url'] = $path;
}

// Include the main application
require_once __DIR__ . '/index.php';
?>
