<?php
	// Load environment variables from .env file
	$envFile = __DIR__ . '/../.env';
	if (file_exists($envFile)) {
		$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($lines as $line) {
			if (strpos($line, '#') === 0) continue; // Skip comments
			if (strpos($line, '=') !== false) {
				list($key, $value) = explode('=', $line, 2);
				$_ENV[trim($key)] = trim($value);
			}
		}
	}
	
	// Database configuration with fallback to original values
	define('host', isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost');
	define('dbname', isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : 'IOC');
	define('username', isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root');
	define('password', isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '');
?>



