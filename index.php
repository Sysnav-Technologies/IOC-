<?php 
	// Load configuration first
	require __DIR__ . '/config/Config.php';
	Config::loadEnv();
	
	//Libraries
	require __DIR__ . '/libs/Bootstrap.php';
	require __DIR__ . '/libs/Controller.php';
	require __DIR__ . '/libs/Model.php';
	require __DIR__ . '/libs/View.php';
	require __DIR__ . '/libs/Session.php';	
	//configuration files
	require __DIR__ . '/config/paths.php';
	require __DIR__ . '/libs/Database.php';
	
	$app  = new Bootstrap();
?>



