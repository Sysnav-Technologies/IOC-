<?php 
	// Include the database configuration
	require_once __DIR__ . '/../config/Database.php';
	
	class Database extends PDO{
		function __construct(){
			try{
				parent::__construct('mysql:host='.host.';dbname='.dbname, username, password, array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				));
			}
			catch(PDOException $e){
				// Log error and redirect to show database connection issue
				error_log("Database connection failed: " . $e->getMessage());
				die("Database connection failed. Please check your database configuration.");
			}
		}
		
	}
?>



