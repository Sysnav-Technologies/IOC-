<?php 
	// Include Currency Helper
	require_once 'CurrencyHelper.php';
	
	class Bootstrap{
		function __construct(){
			// Initialize Currency Helper
			CurrencyHelper::init();
			$url = isset($_GET['url']) ? $_GET['url'] : '';
			$url = explode('/', $url);
			
			//if empty redirect to index
			if(empty($url[0])){	
				// Check authentication before loading index
				Session::init();
				if(!isset($_SESSION['loggedIn'])){
					require 'controllers/login.php';
					$controller = new Login();
					$controller->index();
					return;
				}
				require 'controllers/index.php';
				$controller = new Index();
				$controller->index();
				return;
			} 
			$file = 'controllers/'. $url[0] .'.php';
			if(file_exists($file)){
				require $file;
				$controller = new $url[0]();
				
				// Ensure $url[1] is a string, not an array
				if(isset($url[1]) && !is_array($url[1]) && $url[1] != ""){
					$method = $url[1];
					if(isset($url[2]) && !is_array($url[2]) && $url[2] != ""){			
						if(method_exists($controller, $method)){
							$controller->$method($url[2]);
						}
						else{
							require_once 'controllers/error.php';
							$controller = new IOC_ErrorController();
							$controller->index();
							return;
						}
					}
					else{
						if(method_exists($controller, $method)){
							$controller->$method();
						}
						else{
							require_once 'controllers/error.php';
							$controller = new IOC_ErrorController();
							$controller->index();
							return;
						}	
					}	
				}
				else{
					$controller->index();
				}	
			}
			else{
				require_once 'controllers/error.php';
				$controller = new IOC_ErrorController();
				$controller->index();
				return;
			}
		}
	}
?>