<?php
	// Include cPanel helper
	require_once __DIR__ . '/CPanelHelper.php';
	
	// Use cPanel helper for better environment detection
	$baseUrl = CPanelHelper::getBaseURL();
	
	define('URL', $baseUrl);
	define('CSS', $baseUrl . 'views/');
	define('IMG', $baseUrl . 'views/');
	define('FLOATING', $baseUrl . 'node_modules/mfb/src/');
	define('CSS1', $baseUrl . 'views/css/');
	define('BRANCHIMG', $baseUrl . 'views/transport/branches/img/branchimg.jpg');
	define('JQuery', $baseUrl . 'bower_components/jquery/dist/jquery.min.js');
	define('BOWER', $baseUrl . 'bower_components/');
	define('ChartJS', $baseUrl . 'bower_components/Chart.js/Chart.js');
	
	// Helper function for URL generation that works with or without URL rewriting
	function getRouteURL($route) {
		// Check if we're testing for URL rewriting by seeing if current script is index.php
		if (isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) {
			// URL rewriting is working or we're being called through index.php
			return URL . $route;
		} else {
			// URL rewriting not working, use query parameter format
			return URL . 'index.php?url=' . $route;
		}
	}
	
	// Helper function for static file URLs when .htaccess isn't working
	function getStaticFileURL($filePath) {
		// If we're having .htaccess issues, use the PHP static file server
		if (defined('USE_STATIC_SERVER') && USE_STATIC_SERVER) {
			return URL . 'serve-static.php?file=' . urlencode($filePath);
		}
		// Otherwise use direct file access
		return URL . $filePath;
	}
	
	// Detect if we should use the static file server (can be overridden)
	if (!defined('USE_STATIC_SERVER')) {
		// You can set this to true if .htaccess is not working
		define('USE_STATIC_SERVER', false);
	}
?>



