<?php 
	// Include Currency Helper
	require_once 'CurrencyHelper.php';
	
	class Bootstrap{
		function __construct(){
			// Debug logging for cPanel troubleshooting
			$logFile = __DIR__ . '/../debug_cpanel.log';
			$timestamp = date('Y-m-d H:i:s');
			
			file_put_contents($logFile, "\n[$timestamp] Bootstrap->__construct() called", FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] GET parameters: " . print_r($_GET, true), FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] SERVER REQUEST_URI: " . $_SERVER['REQUEST_URI'], FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] HTTP_HOST: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'not set'), FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] SCRIPT_NAME: " . (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : 'not set'), FILE_APPEND);
			
			// Initialize Currency Helper
			CurrencyHelper::init();
			$url = isset($_GET['url']) ? $_GET['url'] : '';
			
			// Fallback for cPanel environments where .htaccess might not work properly
			if(empty($url) && isset($_SERVER['REQUEST_URI'])) {
				$requestUri = $_SERVER['REQUEST_URI'];
				// Remove the script name from the URI if present
				if(isset($_SERVER['SCRIPT_NAME'])) {
					$scriptName = dirname($_SERVER['SCRIPT_NAME']);
					if($scriptName !== '/') {
						$requestUri = str_replace($scriptName, '', $requestUri);
					}
				}
				// Remove leading slash and query parameters
				$url = trim($requestUri, '/');
				$url = explode('?', $url)[0]; // Remove query string
				file_put_contents($logFile, "\n[$timestamp] Fallback URL extraction from REQUEST_URI: '" . $url . "'", FILE_APPEND);
			}
			
			file_put_contents($logFile, "\n[$timestamp] Raw URL from GET: '" . $url . "'", FILE_APPEND);
			
			$url = explode('/', $url);
			
			file_put_contents($logFile, "\n[$timestamp] URL array: " . print_r($url, true), FILE_APPEND);
			
			//if empty redirect to index
			if(empty($url[0])){	
				file_put_contents($logFile, "\n[$timestamp] Empty URL, checking authentication", FILE_APPEND);
				// Check authentication before loading index
				Session::init();
				if(!isset($_SESSION['loggedIn'])){
					file_put_contents($logFile, "\n[$timestamp] Not logged in, loading login controller", FILE_APPEND);
					require __DIR__ . '/../controllers/login.php';
					$controller = new Login();
					$controller->index();
					return;
				}
				file_put_contents($logFile, "\n[$timestamp] Logged in, loading index controller", FILE_APPEND);
				require __DIR__ . '/../controllers/index.php';
				$controller = new Index();
				$controller->index();
				return;
			} 
			$file = __DIR__ . '/../controllers/'. $url[0] .'.php';
			
			file_put_contents($logFile, "\n[$timestamp] Looking for controller file: " . $file, FILE_APPEND);
			
			if(file_exists($file)){
				file_put_contents($logFile, "\n[$timestamp] Controller file exists, requiring it", FILE_APPEND);
				require $file;
				// Handle case sensitivity - capitalize first letter for class name
				$className = ucfirst($url[0]);
				file_put_contents($logFile, "\n[$timestamp] Creating controller instance: " . $className, FILE_APPEND);
				$controller = new $className();
				
				// Ensure $url[1] is a string, not an array
				if(isset($url[1]) && !is_array($url[1]) && $url[1] != ""){
					$method = $url[1];
					file_put_contents($logFile, "\n[$timestamp] Method specified: " . $method, FILE_APPEND);
					if(isset($url[2]) && !is_array($url[2]) && $url[2] != ""){			
						if(method_exists($controller, $method)){
							file_put_contents($logFile, "\n[$timestamp] Calling method " . $method . " with parameter", FILE_APPEND);
							$controller->$method($url[2]);
						}
						else{
							file_put_contents($logFile, "\n[$timestamp] Method " . $method . " does not exist", FILE_APPEND);
							require_once __DIR__ . '/../controllers/error.php';
							$controller = new IOC_ErrorController();
							$controller->index();
							return;
						}
					}
					else{
						if(method_exists($controller, $method)){
							file_put_contents($logFile, "\n[$timestamp] Calling method " . $method . " without parameter", FILE_APPEND);
							$controller->$method();
						}
						else{
							file_put_contents($logFile, "\n[$timestamp] Method " . $method . " does not exist", FILE_APPEND);
							require_once __DIR__ . '/../controllers/error.php';
							$controller = new IOC_ErrorController();
							$controller->index();
							return;
						}	
					}	
				}
				else{
					file_put_contents($logFile, "\n[$timestamp] No method specified, calling index()", FILE_APPEND);
					$controller->index();
				}	
			}
			else{
				file_put_contents($logFile, "\n[$timestamp] Controller file not found: " . $file, FILE_APPEND);
				require_once __DIR__ . '/../controllers/error.php';
				$controller = new IOC_ErrorController();
				$controller->index();
				return;
			}
		}
	}
?>