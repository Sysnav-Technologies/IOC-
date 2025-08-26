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
			// Clear any previous output
			if (ob_get_level()) {
				ob_clean();
			}
			
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = trim($_POST['username']);
				$password = trim($_POST['password']);	
				
				// Basic validation
				if(empty($username) || empty($password)){
					header('location: ' . URL . 'login?error=empty');
					exit;
				}
				
				try {
					require_once __DIR__ . '/../models/Login_model.php';
					$model = new Login_model();
					
					// Let the model handle the complete login process
					$model->login($username, $password);
					exit; // Ensure no further execution after model handles redirect
				} catch(Exception $e) {
					// Log the error and redirect with database error
					header('location: ' . URL . 'login?error=exception&msg=' . urlencode($e->getMessage()));
					exit;
				}
			} else {
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



