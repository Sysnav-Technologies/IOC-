<?php
/**
 * IOC System Status Check
 * Quick diagnostic for cPanel deployment
 */
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>IOC System Status</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .status { background: white; padding: 20px; margin: 15px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .pass { color: #28a745; font-weight: bold; }
        .fail { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; }
        .test-btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
        .test-btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<h1>🏥 IOC System Health Check</h1>

<?php
// Basic system info
echo '<div class="status">';
echo '<h3>� System Environment</h3>';
echo '<p><strong>Server:</strong> ' . ($_SERVER['HTTP_HOST'] ?? 'Unknown') . '</p>';
echo '<p><strong>PHP Version:</strong> ' . PHP_VERSION . '</p>';
echo '<p><strong>Current Time:</strong> ' . date('Y-m-d H:i:s T') . '</p>';
echo '</div>';

// Load paths
echo '<div class="status">';
echo '<h3>🔗 URL Configuration</h3>';
try {
    require_once 'config/paths.php';
    echo '<p class="pass">✅ Configuration loaded successfully</p>';
    echo '<p><strong>Base URL:</strong> ' . URL . '</p>';
} catch (Exception $e) {
    echo '<p class="fail">❌ Configuration failed: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// Test critical files
echo '<div class="status">';
echo '<h3>📁 Core System Files</h3>';

$coreFiles = [
    'Static Server' => 'serve-static.php',
    'Main Index' => 'index.php',
    'URL Routing' => '.htaccess',
    'jQuery Library' => 'bower_components/jquery/dist/jquery.min.js',
    'Material CSS' => 'views/dist/css/material.min.css'
];

$allGood = true;
foreach ($coreFiles as $name => $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file));
        echo "<p class='pass'>✅ $name: Ready ($size bytes)</p>";
    } else {
        echo "<p class='fail'>❌ $name: Missing ($file)</p>";
        $allGood = false;
    }
}

if ($allGood) {
    echo '<p class="pass"><strong>🎉 All core files are present!</strong></p>';
}
echo '</div>';

// Live tests
echo '<div class="status">';
echo '<h3>🧪 Live Asset Tests</h3>';
echo '<p>Click these buttons to test if static files load correctly:</p>';

$testAssets = [
    'jQuery' => 'bower_components/jquery/dist/jquery.min.js',
    'Material CSS' => 'views/dist/css/material.min.css',
    'Bootstrap JS' => 'bower_components/bootstrap.min.js',
    'SweetAlert' => 'bower_components/sweetalert/dist/sweetalert.min.js'
];

foreach ($testAssets as $name => $path) {
    $testUrl = URL . 'serve-static.php?file=' . urlencode($path);
    echo "<button class='test-btn' onclick=\"window.open('$testUrl', '_blank')\">Test $name</button>";
}
echo '</div>';

// JavaScript test
echo '<div class="status">';
echo '<h3>⚡ JavaScript Functionality Test</h3>';
echo '<div id="js-results">Testing JavaScript loading...</div>';
echo '</div>';
?>

<div class="status">
    <h3>� System Status Summary</h3>
    <div id="summary">
        <?php if ($allGood): ?>
            <p class="pass">✅ System appears ready for production!</p>
            <p class="info">All critical files found. Static file server is configured.</p>
        <?php else: ?>
            <p class="fail">❌ Some issues detected. Check missing files above.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// Test jQuery loading
var jqueryUrl = '<?php echo URL; ?>serve-static.php?file=bower_components/jquery/dist/jquery.min.js';
var script = document.createElement('script');
script.src = jqueryUrl;

script.onload = function() {
    document.getElementById('js-results').innerHTML = 
        '<p class="pass">✅ jQuery loaded successfully!</p>' +
        '<p class="info">Static file server is working correctly.</p>';
};

script.onerror = function() {
    document.getElementById('js-results').innerHTML = 
        '<p class="fail">❌ jQuery failed to load from static server.</p>' +
        '<p>URL tested: ' + jqueryUrl + '</p>';
};

document.head.appendChild(script);
</script>

</body>
</html>
