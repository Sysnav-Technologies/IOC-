<?php 
	class Login extends Controller{
		function __construct(){
			parent::__construct();
		}
		public function index(){
			Session::init();
			if(!isset($_SESSION['loggedIn'])){
				$this->view->render('login/index',false);	
			}
			else{
				header('location:'.URL);
			}
		}
		public function login(){

		}
		public function checkin(){
			// Debug logging for cPanel troubleshooting
			$logFile = __DIR__ . '/../debug_cpanel.log';
			$timestamp = date('Y-m-d H:i:s');
			
			file_put_contents($logFile, "\n[$timestamp] Login checkin started", FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] POST data: " . print_r($_POST, true), FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'], FILE_APPEND);
			file_put_contents($logFile, "\n[$timestamp] REQUEST_URI: " . $_SERVER['REQUEST_URI'], FILE_APPEND);
			
			// Clear any previous output
			if (ob_get_level()) {
				ob_clean();
			}
			
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = trim($_POST['username']);
				$password = trim($_POST['password']);	
				
				file_put_contents($logFile, "\n[$timestamp] Processing login for user: $username", FILE_APPEND);
				
				// Basic validation
				if(empty($username) || empty($password)){
					file_put_contents($logFile, "\n[$timestamp] Empty username or password", FILE_APPEND);
					header('location: ' . URL . 'login?error=empty');
					exit;
				}
				
				try {
					require_once __DIR__ . '/../models/Login_model.php';
					$model = new Login_model();
					
					file_put_contents($logFile, "\n[$timestamp] About to call model->login()", FILE_APPEND);
					
					// Let the model handle the complete login process
					$model->login($username, $password);
					exit; // Ensure no further execution after model handles redirect
				} catch(Exception $e) {
					// Log the error and redirect with database error
					file_put_contents($logFile, "\n[$timestamp] Exception: " . $e->getMessage(), FILE_APPEND);
					header('location: ' . URL . 'login?error=exception&msg=' . urlencode($e->getMessage()));
					exit;
				}
			} else {
				file_put_contents($logFile, "\n[$timestamp] Missing username or password in POST", FILE_APPEND);
				header('location: ' . URL . 'login?error=missing');
				exit;
			}
		}
		//example for how to use a model
		public function signup(){
			require 'models/Login_model.php';
			$model = new Login_model();
			$model->signup();
			header('location:'.URL);
		}
	}
?>



