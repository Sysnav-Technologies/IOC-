<?php 
	class View{
		function __construct(){
			
		}
		public function render($name,$arg = false){
			$viewsPath = __DIR__ . '/../views/';
			if($arg == false){
				require $viewsPath . $name. '.php';
				require_once $viewsPath . 'footer/footer.php';
			}
			else{
				require $viewsPath . 'header/header.php';
				require $viewsPath . $name. '.php';
				require $viewsPath . 'footer/footer.php';
			}
		}
	}
?>



