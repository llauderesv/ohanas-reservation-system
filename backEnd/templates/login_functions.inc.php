<?php 

function redirect_user ($page = 'login.php') {
	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

}
function check_login($dbc, $username = '', $pass = '') {

	 $problem = FALSE;

	// Validate the email address:
	if (empty($username)) {
		$problem = TRUE;
	} else {
		$username = mysqli_real_escape_string($dbc, trim(strtolower($username)));
	}

	// Validate the password:
	if (empty($pass)) {
		$problem = TRUE;
	} else {
		$pass = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (!$problem) {
		$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
		$query = "SELECT user_id, last_name, first_name, user_type FROM user_table
				  WHERE username = '$username' AND pass = AES_ENCRYPT('$pass','$key')";		

		$result = mysqli_query($dbc, $query);
		
		
		if (mysqli_num_rows($result) == 1) {
			
			$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
	
			
			return array(true, $row);
		} else {
			$error = "Your username or password is incorrect !";
			include ('../htdocs/login_form.php');
		}
	}
} 