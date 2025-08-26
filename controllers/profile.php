<?php 
	class Profile extends Controller{
		function __construct(){
			parent::__construct();
		}
		public function index(){
			// Require authentication before loading profile
			$this->requireAuth();
			$this->view->render('profile/index',false);
		}
		public function loadProfileCode(){
			Session::init();
			
			// Check authentication for AJAX requests - return JSON error instead of redirect
			if (!isset($_SESSION['loggedIn']) || empty($_SESSION['loggedIn'])) {
				header('Content-Type: application/json');
				echo json_encode(array('error' => 'Not authenticated'));
				return;
			}
			
			$employeeName = $_SESSION['loggedIn'];
			require 'models/Login_model.php';
			$model = new Login_model();
			$data = $model->getEmployeeCode($employeeName);
			
			if (empty($data) || !isset($data[0]['employeeCode'])) {
				header('Content-Type: application/json');
				echo json_encode(array('error' => 'Employee not found'));
				return;
			}
			
			$empCode = $data[0]['employeeCode'];
			$profileData = $model->loadProfileDetails($empCode);
			
			if (empty($profileData)) {
				header('Content-Type: application/json');
				echo json_encode(array('error' => 'Profile not found'));
				return;
			}
			
			// Return the profile data as JSON
			header('Content-Type: application/json');
			echo json_encode($profileData);
		}
	}
?>



