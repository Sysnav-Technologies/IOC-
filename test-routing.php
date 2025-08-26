<?php
// Test file to check if URL rewriting is working
echo "<h2>URL Rewrite Test</h2>";
echo "<p>Current URL: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>Query String: " . ($_SERVER['QUERY_STRING'] ?? 'none') . "</p>";
echo "<p>GET url parameter: " . ($_GET['url'] ?? 'not set') . "</p>";

// Test if the routing is working
if (isset($_GET['url'])) {
    echo "<p style='color: green;'>✅ URL rewriting is working!</p>";
    echo "<p>URL segments: " . $_GET['url'] . "</p>";
    
    $segments = explode('/', $_GET['url']);
    echo "<p>Controller: " . ($segments[0] ?? 'none') . "</p>";
    echo "<p>Method: " . ($segments[1] ?? 'none') . "</p>";
} else {
    echo "<p style='color: red;'>❌ URL rewriting is NOT working!</p>";
    echo "<p>The .htaccess file may not be working or mod_rewrite is disabled.</p>";
}

echo "<h3>Server Info:</h3>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>HTTP Host: " . $_SERVER['HTTP_HOST'] . "</p>";
?>

<h3>Quick Tests:</h3>
<ul>
    <li><a href="test-routing.php">Direct access (should work)</a></li>
    <li><a href="login/test">Test login route (needs .htaccess)</a></li>
    <li><a href="stocks">Test stocks route (needs .htaccess)</a></li>
</ul>
