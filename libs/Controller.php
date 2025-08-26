<?php 
	class Controller{
		protected $view;
		
		function __construct(){
			$this->view = new View();
		}
		
		/**
		 * Check if user is authenticated and redirect to login if not
		 */
		protected function requireAuth(){
			Session::init();
			if(!isset($_SESSION['loggedIn'])){
				header('location:'.URL.'login');
				exit;
			}
		}
		
		/**
		 * Check if user is authenticated
		 * @return bool
		 */
		protected function checkAuth(){
			Session::init();
			return isset($_SESSION['loggedIn']);
		}
	}
?>



