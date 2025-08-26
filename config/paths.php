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
?>



