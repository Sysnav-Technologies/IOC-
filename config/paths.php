<?php
	// Auto-detect environment
	$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1');
	
	if ($isLocal) {
		// Local environment - include /IOC/ in path
		$baseUrl = 'http://localhost/IOC/';
	} else {
		// Production environment - domain root
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
		$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
	}
	
	define('URL', $baseUrl);
	define('CSS', $baseUrl . 'views/');
	define('IMG', $baseUrl . 'views/');
	define('FLOATING', $baseUrl . 'node_modules/mfb/src/');
	define('CSS1', $baseUrl . 'views/css/');
	define('BRANCHIMG', $baseUrl . 'views/transport/branches/img/branchimg.jpg');
	define('JQuery', $baseUrl . 'bower_components/jquery/dist/jquery.min.js');
	define('BOWER', $baseUrl . 'bower_components/');
	define('ChartJS', $baseUrl . 'bower_components/Chart.js/Chart.js');
?>



