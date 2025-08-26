<?php 
	// Include the database configuration
	require_once __DIR__ . '/../config/Database.php';
	
	class Database extends PDO{
		function __construct(){
			try{
				parent::__construct('mysql:host='.host.';dbname='.dbname, username, password);
			}
			catch(PDOException $e){
				echo $e;
			}
		}
		
	}
?>



