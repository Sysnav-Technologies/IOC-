<div id="profile-card-custom">
<div class="profile-card-wrap">
	<input id="check" type="checkbox" class="check"><label for="check" class="toggle"> + </label>
	<div class="content" data-text="">
		<p><?php Session::init(); //echo $_SESSION['loggedIn']?></p>

		<?php
			//Session::init();
			Session::init();
			
			// Check if user is logged in
			if (!isset($_SESSION['loggedIn']) || empty($_SESSION['loggedIn'])) {
				echo "<h3>Not logged in</h3>";
				echo "<b>Please log in to view your profile.</b>";
				echo '<br/><a href="' . URL . 'login" class="btn btn-primary">Login</a>';
			} else {
				$employeeName = $_SESSION['loggedIn'];
				require 'models/Login_model.php';
				$model = new Login_model();
				$empCodeData = $model->getEmployeeCode($employeeName);
				
				if (!empty($empCodeData) && isset($empCodeData[0]['employeeCode'])) {
					$empCode = $empCodeData[0]['employeeCode'];
					$data = $model->loadProfileDetails($empCode);
					
					if (!empty($data) && isset($data[0])) {
						echo "<h3>" . (isset($data[0]['firstName']) ? $data[0]['firstName'] : '') . " " . (isset($data[0]['lastName']) ? $data[0]['lastName'] : '') . "</h3>";
						echo "<b> Type : " . (isset($data[0]['emptype']) ? $data[0]['emptype'] : 'N/A') . "</b><br/>"; 			
						echo "<b> NIC : " . (isset($data[0]['nicNumber']) ? $data[0]['nicNumber'] : 'N/A') . "</b><br/>"; 			
						echo "<b> Birthday : " . (isset($data[0]['birthDate']) ? $data[0]['birthDate'] : 'N/A') . "</b><br/>";
					} else {
						echo "<h3>Profile not found</h3>";
						echo "<b>Employee Code: " . htmlspecialchars($empCode) . "</b><br/>";
						echo "<b>No profile details available.</b>";
					}
				} else {
					echo "<h3>Employee not found</h3>";
					echo "<b>Username: " . htmlspecialchars($employeeName) . "</b><br/>";
					echo "<b>Please contact administrator.</b>";
				}
			}
		?>
	</div>
	<div class="link-info">
		<div class="social">
		<!--	<a class="link oc" href="https://openclassrooms.com/membres/igormarty" target="_blank"><i class="fa fa-graduation-cap"></i></a>
			<a class="link tw" href="https://twitter.com/igor_marty" target="_blank"><i class="fa fa-twitter"></i></a>
			<a class="link cp" href="http://codepen.io/IMarty/" target="_blank"><i class="fa fa-codepen"></i></a>
			<a class="link gh" href="https://github.com/IMarty" target="_blank"><i class="fa fa-github"></i></a>
			<a class="link li" href="https://fr.linkedin.com/in/igormarty" target="_blank"><i class="fa fa-linkedin"></i></a>
			<a class="link gp" href="https://plus.google.com/u/0/+IgorMarty" target="_blank"><i class="fa fa-google-plus"></i></a>
		-->
		</div>
		<div class="photo"></div>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$.getJSON('profile/loadProfileCode',function(data){
			console.log(data);
			//firstname = data[0].firstName;
			//lastname = data[0].lastName;
		});
		//$("#username").append(firstname + lastname);
	});

</script>





