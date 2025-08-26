<?php 
	class Login_model extends Model{
		function __construct(){
			parent::__construct();
		}
		
	public function login($username,$password){
		try {
			$st = $this->db->prepare("SELECT * FROM employee_list WHERE userName=? AND userPassword=?");
			$st->execute([$username, $password]);
			$data = $st->fetchAll();
			
			if(count($data) == 1){
				Session::init();
				$_SESSION['loggedIn'] = $username;
				$_SESSION['user_name'] = $data[0]['userName']; // Store user name for display
				$_SESSION['employeeCode'] = $data[0]['employeeCode']; // Store employee code
				
				// Clean any output buffer before redirect
				if (ob_get_level()) {
					ob_clean();
				}
				header('location: ' . URL);
				exit;
			} else {
				// Login failed - redirect with error
				if (ob_get_level()) {
					ob_clean();
				}
				header('location: ' . URL . 'login?error=invalid');
				exit;
			}
		} catch(PDOException $e) {
			// Database error - redirect with error
			if (ob_get_level()) {
				ob_clean();
			}
			header('location: ' . URL . 'login?error=database&msg=' . urlencode($e->getMessage()));
			exit;
		}
	}
	public function loadProfileDetails($employeeCode){
			$st = $this->db->prepare("SELECT * FROM employee_list WHERE employeeCode=:empCode");
			$st->execute(array(
				':empCode' => $employeeCode
			));
			return $st->fetchAll();
		}
		public function signup(){
			$st = $this->db->prepare("");
			$st->execute(array(
		
			));
		}
		public function getEmployeeCode($username){
			$st = $this->db->prepare("SELECT employeeCode FROM employee_list WHERE userName=:username");
			$st->execute(array(
				':username' => $username
			));
			return $st->fetchAll();
		}
	}
?>



