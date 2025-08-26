<?php 
	class Login_model extends Model{
		function __construct(){
			parent::__construct();
		}
		
	public function login($username,$password){
		// Debug logging for cPanel troubleshooting
		$logFile = __DIR__ . '/../debug_cpanel.log';
		$timestamp = date('Y-m-d H:i:s');
		
		file_put_contents($logFile, "\n[$timestamp] Login_model->login() called with username: $username", FILE_APPEND);
		
		try {
			file_put_contents($logFile, "\n[$timestamp] Preparing database query", FILE_APPEND);
			$st = $this->db->prepare("SELECT * FROM employee_list WHERE userName=? AND userPassword=?");
			$st->execute([$username, $password]);
			$data = $st->fetchAll();
			
			file_put_contents($logFile, "\n[$timestamp] Query executed, found " . count($data) . " records", FILE_APPEND);
			
			if(count($data) == 1){
				file_put_contents($logFile, "\n[$timestamp] Login successful, setting session", FILE_APPEND);
				
				Session::init();
				$_SESSION['loggedIn'] = $username;
				$_SESSION['user_name'] = $data[0]['userName']; // Store user name for display
				$_SESSION['employeeCode'] = $data[0]['employeeCode']; // Store employee code
				
				file_put_contents($logFile, "\n[$timestamp] Session set, redirecting to: " . URL, FILE_APPEND);
				
				// Clean any output buffer before redirect
				if (ob_get_level()) {
					ob_clean();
				}
				header('location: ' . URL);
				exit;
			} else {
				file_put_contents($logFile, "\n[$timestamp] Login failed - invalid credentials", FILE_APPEND);
				// Login failed - redirect with error
				if (ob_get_level()) {
					ob_clean();
				}
				header('location: ' . URL . 'login?error=invalid');
				exit;
			}
		} catch(PDOException $e) {
			file_put_contents($logFile, "\n[$timestamp] Database error: " . $e->getMessage(), FILE_APPEND);
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



