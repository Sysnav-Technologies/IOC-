<?php 
	if (!class_exists('IOC_ErrorController')) {
		class IOC_ErrorController extends Controller{
			function __construct(){
				parent::__construct();
			}
			public function index(){
				$this->view->render('error/index');
			}
		}
	}
?>



