<?php
// Comprehensive diagnostic for IOC cPanel issues
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>IOC System Diagnostic</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #f5f5f5; }
        .section { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .pass { color: green; }
        .fail { color: red; }
        .warning { color: orange; }
        .code { background: #f0f0f0; padding: 10px; margin: 5px 0; border-radius: 3px; }
        .test-link { color: blue; text-decoration: underline; cursor: pointer; }
    </style>
</head>
<body>

<h1>🔧 IOC System Diagnostic Tool</h1>

<?php
echo '<div class="section">';
echo "<h2>📊 Environment Information</h2>";
echo "<strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "<br>";
echo "<strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "<br>";
echo "<strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "<br>";
echo "<strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "<br>";
echo "<strong>DOCUMENT_ROOT:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set') . "<br>";
echo "<strong>SERVER_SOFTWARE:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'not set') . "<br>";
echo '</div>';

// Test paths configuration
echo '<div class="section">';
echo "<h2>🔗 URL Configuration Test</h2>";
try {
    require_once 'config/paths.php';
    echo "<div class='pass'>✅ paths.php loaded successfully</div>";
    echo "<strong>URL:</strong> " . URL . "<br>";
    echo "<strong>BOWER:</strong> " . BOWER . "<br>";
    echo "<strong>CSS:</strong> " . CSS . "<br>";
} catch (Exception $e) {
    echo "<div class='fail'>❌ Failed to load paths.php: " . $e->getMessage() . "</div>";
}
echo '</div>';

// Test critical files
echo '<div class="section">';
echo "<h2>📁 Critical File Existence Test</h2>";
$criticalFiles = [
    '.htaccess' => '.htaccess',
    'jQuery' => 'bower_components/jquery/dist/jquery.min.js',
    'Bootstrap JS' => 'bower_components/bootstrap.min.js',
    'Material CSS' => 'views/dist/css/material.min.css',
    'Material JS' => 'bower_components/bootstrap-material-design/dist/js/material.min.js',
    'Ripples CSS' => 'views/dist/css/ripples.min.css',
    'Ripples JS' => 'bower_components/bootstrap-material-design/dist/js/ripples.min.js'
];

foreach ($criticalFiles as $name => $path) {
    if (file_exists($path)) {
        $size = filesize($path);
        echo "<div class='pass'>✅ $name: EXISTS ($size bytes)</div>";
        
        // Test if we can read a sample of the file
        if ($size > 0) {
            $sample = file_get_contents($path, false, null, 0, 50);
            $sampleClean = htmlspecialchars(trim($sample));
            echo "<div class='code'>Sample: $sampleClean...</div>";
        }
    } else {
        echo "<div class='fail'>❌ $name: MISSING ($path)</div>";
    }
}
echo '</div>';

// JavaScript/CSS Access Test
echo '<div class="section">';
echo "<h2>🌐 Asset Accessibility Test</h2>";
echo "<p>Click these links to test if static files are accessible:</p>";

$testUrls = [
    'jQuery' => URL . 'bower_components/jquery/dist/jquery.min.js',
    'Bootstrap JS' => URL . 'bower_components/bootstrap.min.js',
    'Material CSS' => URL . 'views/dist/css/material.min.css',
    'Material JS' => URL . 'bower_components/bootstrap-material-design/dist/js/material.min.js'
];

foreach ($testUrls as $name => $url) {
    echo "<div>";
    echo "<strong>$name:</strong> ";
    echo "<a href='$url' target='_blank' class='test-link'>$url</a>";
    echo "</div>";
}
echo '</div>';
?>

<div class="section">
    <h2>📋 Quick Fixes to Try</h2>
    <ol>
        <li><strong>Replace .htaccess:</strong> Copy content from <code>htaccess-simple.txt</code> to <code>.htaccess</code></li>
        <li><strong>Test File Access:</strong> Visit <code><?php echo URL; ?>test-files.php</code></li>
        <li><strong>Check File Permissions:</strong> Ensure 644 for files, 755 for directories</li>
        <li><strong>Clear Browser Cache:</strong> Hard refresh (Ctrl+Shift+R) after changes</li>
    </ol>
</div>

</body>
</html>
