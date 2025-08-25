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
		public static function isLoggedIn(){
			Session::init();
			if(isset($_SESSION['loggedIn'])){
				return true;
			}
			else{
				return false;
			}
		}
		public function checkin(){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = $_POST['username'];
				$password = $_POST['password'];	
				require 'models/Login_model.php';
				$model = new Login_model();
				$empCode = $model->getEmployeeCode($username);
				
				// Check if employee code was found
				if($empCode && is_array($empCode) && count($empCode) > 0){
					// Extract the actual employeeCode value from the array
					$employeeCodeRow = $empCode[0];
					$employeeCode = $employeeCodeRow['employeeCode'];
					
					Session::init();
					$_SESSION['loggedIn'] = $employeeCode;
					$model->login($username,$password);
				} else {
					// Redirect back to login with error (you can enhance this later)
					header('location:' . URL . 'login');
				}
			} else {
				header('location:' . URL . 'login');
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



