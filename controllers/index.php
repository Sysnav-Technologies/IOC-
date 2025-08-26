<?php 
	class Index extends Controller{
		function __construct(){
			parent::__construct();
		}
		public function index(){
			// Check if user is logged in, if not redirect to login
			$this->requireAuth();
			$this->view->render('index/index',true);
		}
		public function logout(){
			Session::init();
			if(isset($_SESSION['loggedIn'])){
				Session::destroy();
				header('location:'.URL.'login');
				exit;
			}
			else{
				// Instead of showing error, redirect to login
				header('location:'.URL.'login');
				exit;
			}
		}
		public function signUp(){
			$this->view->render('index/signUp',false);
		}
	}
?>



