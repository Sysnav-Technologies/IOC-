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
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = $_POST['username'];
				$password = $_POST['password'];	
				
				require 'models/Login_model.php';
				$model = new Login_model();
				
				// Let the model handle the complete login process
				$model->login($username, $password);
				exit; // Ensure no further execution after model handles redirect
			} else {
				header('location:' . URL . 'login');
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



