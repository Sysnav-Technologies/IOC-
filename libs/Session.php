<?php 
	class Session{
		public static function init(){
			// Check if session is already started and headers not sent
			if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
				session_start();
			}
		}
		public static function set($key,$value){
			self::init(); // Ensure session is started
			$_SESSION[$key] = $value;
		}
		public static function get($key){
			self::init(); // Ensure session is started
			return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
		}
		public static function destroy(){
			self::init(); // Ensure session is started before destroying
			// Clear all session variables
			$_SESSION = array();
			
			// Delete the session cookie if it exists
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			
			// Destroy the session
			session_destroy();
		}
		
		/**
		 * Check if a session variable exists
		 */
		public static function exists($key){
			self::init();
			return isset($_SESSION[$key]);
		}
		
		/**
		 * Remove a specific session variable
		 */
		public static function delete($key){
			self::init();
			if(isset($_SESSION[$key])){
				unset($_SESSION[$key]);
			}
		}
	}
?>



