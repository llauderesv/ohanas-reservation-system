<?php
//Start the session..
session_start();
// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {
	//require the login function..
	require ('../templates/login_functions.inc.php');
	redirect_user();	
}
$page_title = "Register user";
// Set the page title and include the HTML header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//
$query = "SELECT audit_id FROM audit_trail";
$result = mysqli_query($dbc, $query);
$num = mysqli_num_rows($result);
if($num <= 0) {
	$audit_id = 50001;
} else {
	$query2 = "SELECT MAX(audit_id) FROM audit_trail";
	$result2 = mysqli_query($dbc, $query2);
	$row = mysqli_fetch_array($result2, MYSQLI_NUM);
	$audit_id = $row[0] + 1;
}
//Set the admin id to Auto Increment..
$query = "SELECT user_id FROM user_info_table";
$result = mysqli_query($dbc, $query);
$num = mysqli_num_rows($result);
if($num <= 0) {
	$user_id = 2015001;
} else {
	$query2 = "SELECT MAX(user_id) FROM user_info_table";
	$result2 = mysqli_query($dbc, $query2);
	$row = mysqli_fetch_array($result2, MYSQLI_NUM);
	$user_id = $row[0] + 1;
}
//Set the account id to Auto Increment..
$q = "SELECT account_id FROM user_account_table";
$r = mysqli_query($dbc, $q);
$n = mysqli_num_rows($r);
if($n <= 0) {
	$account_id = 1001;
} else {
	$q2 = "SELECT MAX(account_id) FROM user_account_table";
	$r2 = mysqli_query($dbc, $q2);
	$row = mysqli_fetch_array($r2, MYSQLI_NUM);
	$account_id = $row[0] + 1;
}

//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
//Set the boolean Flag to false..
$problem = FALSE;

//Validation of form..
if (!empty($_POST['sample'])) {
	$problem = TRUE;
	$invalid6 = "Password must contain atleast one characters or numbers.";
}
//=================================================================================================================
if(!empty($_POST['last_name'])) {
	$last_name = mysqli_real_escape_string($dbc, trim(ucwords($_POST['last_name'])));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['first_name'])) {
	$first_name = mysqli_real_escape_string($dbc, ucwords($_POST['first_name']));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['email_address'])) {
	//if (preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $_POST['email_id'])) {
		$email_address = mysqli_real_escape_string($dbc, trim($_POST['email_address']));
		$query3 = "SELECT user_id FROM user_info_table WHERE email_address = '$email_address'";
		$result3 = mysqli_query($dbc, $query3);
		$num2 = mysqli_num_rows($result3);
		if($num2 > 0) {
			$problem = TRUE;
			$_POST['email_address'] ="";
			$error = "Your email adress is already used.";
		}
	//} 
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['user_type'])) {
	$user_type = mysqli_real_escape_string($dbc, trim(ucwords($_POST['user_type'])));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['username'])) {
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$query5 = "SELECT user_id FROM user_account_table WHERE username = '$username'";
		$result5 = mysqli_query($dbc, $query5);
		$num5 = mysqli_num_rows($result5);
		if($num5 > 0) {
			$problem = TRUE;
			$_POST['username'] ="";
			$error4 = "Your username is already used.";
		}
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['gender'])) {
	$gender = mysqli_real_escape_string($dbc, trim(ucwords($_POST['gender'])));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['pass'])) {
	$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if($_POST['confirm'] != $_POST['pass'] || empty($_POST['confirm'])){
	$problem = TRUE;
}
//=================================================================================================================
if (!empty($_POST['invalidLot'])) {
	$problem = TRUE;
	$invalid7 = "Enter a valid lot number.";
} else {
	$lot_no = mysqli_real_escape_string($dbc, trim($_POST['lot_no']));
}
//=================================================================================================================
if(!empty($_POST['street'])) {
	$street = mysqli_real_escape_string($dbc, trim(ucfirst($_POST['street'])));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['city'])) {
	$city = mysqli_real_escape_string($dbc, trim(ucwords($_POST['city'])));
} else {
	$problem = TRUE;
}
//=================================================================================================================
if(!empty($_POST['sample2'])) {
	$problem = TRUE;
	$invalid8 = "Invalid Cellphone number.";
} else {
	$cellphone_no = mysqli_real_escape_string($dbc, trim($_POST['cellphone_no']));
}
//=================================================================================================================
if (!empty($_POST['fname2'])) {
	$problem = TRUE;
	$invalid1 = "Enter a valid first name.";
}
//=================================================================================================================
if (!empty($_POST['lname2'])) {
	$problem = TRUE;
	$invalid2 = "Enter a valid last name.";
}
//=================================================================================================================
if (!empty($_POST['mname2'])) {
	$problem = TRUE;
	$invalid3 = "Enter a valid middle name.";
}
//=================================================================================================================
if (!empty($_POST['uname2'])) {
	$problem = TRUE;
	$invalid4 = "Username must contain atleast one characters or numbers.";
}
//=================================================================================================================
if (!empty($_POST['city2'])) {
	$problem = TRUE;
	$invalid5 = "Enter a valid city.";
}
//=================================================================================================================
// Check if problem is false insert data information to database..
if(!$problem) {
	$address = $lot_no . ' ' . $street . ' ' . $city;
	$lname = $_SESSION['last_name'];
	$fname = $_SESSION['first_name'];
	$type  = $_SESSION['user_type'];
	//Make a query..
	$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
	$middle_name = ucfirst($_POST['middle_name']);

	$query4 = "INSERT INTO user_info_table 
	(user_id, last_name, first_name, middle_name, gender, cellphone_no, address, email_address) 
	VALUES
	('$user_id', '$last_name', '$first_name', '$middle_name', '$gender', '$cellphone_no', '$address', '$email_address')";
	$result4 = mysqli_query($dbc, $query4);

	$query5 = "INSERT INTO user_account_table
	(account_id, user_id, username, pass, user_type)
	VALUES
	('$account_id', '$user_id', '$username', AES_ENCRYPT('$pass','$key'), '$user_type')";

	$result5 = mysqli_query($dbc, $query5);
	$query6 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
				VALUES('$audit_id','$lname','$fname','add user',NOW(),'$type')";
	$result6 = mysqli_query($dbc, $query6);	

	//Check if the query is work..
	if($result4 && $result5) {
		print '<h3 class="success"><div class="col-md-2"></div>THE USER HAS SUCCESSFULLY REGISTERED!</h3>';

			    $_POST = array();
	} else {
		print '<h3><div class="col-md-2"></div>System error you could not be registered 
				at this time due to a system error. <br />
				We apologize for any inconvenience </h3>';
		print '<p><div class="col-md-2"></div>The error has been occured '. mysqli_error($dbc).'...</p>';
	}
} 
mysqli_close($dbc); // Close the database connection..

}// End of if statement..

?>

<!--Display the registration form -->
<div class="col-md-12">
    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" data-toggle="validator">
		<div class="col-md-2"></div>
			<h2 id="register">REGISTER USER</h3>

				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-3">
						<div class="form-group">
								<input type="text" name="last_name" class="form-control" onblur="validateLname()" maxlength="35" id="inputLastname" placeholder="Last Name :" data-error="Your last name is required."
									 value="<?php if(isset($_POST['last_name'])) { print $_POST['last_name'];}?>" required />
								<span  id="lname" style="color: DarkRed;"><?php if(isset($invalid2)) { print $invalid2; } ?></span>
								<input type="hidden" id="lname2" name="lname2" value="<?php if (isset($_POST['lname2'])) { print $_POST['lname2']; }?>" />
								<div class="help-block with-errors"></div>
						</div>
					</div>	

					<div class="col-md-3">
						<div class="form-group">
								<input type="text" name="first_name" class="form-control" onblur="validateFname()" maxlength="25" id="inputFirstname" placeholder="First Name :" data-error="Your first name is required."
							 		value="<?php if(isset($_POST['first_name'])) { print $_POST['first_name'];}?>" required />
							 	<span  id="fname" style="color: DarkRed;"><?php if(isset($invalid1)) { print $invalid1; } ?></span>
								<input type="hidden" id="fname2" name="fname2" value="<?php if (isset($_POST['fname2'])) { print $_POST['fname2']; }?>" />
								<div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-2">
						<div class="form-group">
								<input type="text" name="middle_name" class="form-control" onblur="validateMname()" maxlength="15" id="inputMiddlename" placeholder="Middle Name(optional) :" 
							 		value="<?php if(isset($_POST['middle_name'])) { print $_POST['middle_name'];}?>" />
								<span  id="mname" style="color: DarkRed;"><?php if(isset($invalid3)) { print $invalid3; } ?></span>
								<input type="hidden" id="mname2" name="mname2" value="<?php if (isset($_POST['mname2'])) { print $_POST['mname2']; }?>" />
						</div>
					</div>	
				</div>

				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="email" name="email_address" class="form-control" pattern="^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$" maxlength="45" id="inputEmail" placeholder="Email Address :" data-error="Enter a valid email address." 
						       value="<?php if(isset($_POST['email_address'])) { print $_POST['email_address'];} ?>" required />
							<span class="span2"><?php if(isset($error)) print $error; ?></span><br />
							<div class="help-block with-errors"></div>	
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
							<select name="user_type" id="selectUser" class="form-control" data-error="Select a user type."
							 required>
							 	<option value="">Select position</option>
								<option value="Administrator">Administrator</option>
								<option value="Book manager">Booking manager</option>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="username" class="form-control" onblur="validateUname()" maxlength="35" id="inputUsername" placeholder="Username : " data-error="Your username is required."
								value="<?php if(isset($_POST['username'])) { print $_POST['username'];}?>" required />	
							<span class="span2"><?php if(isset($error4)) print $error4; ?></span><br />
							<span  id="uname" style="color: DarkRed;"><?php if(isset($invalid4)) { print $invalid4; } ?></span>
							<input type="hidden" id="uname2" name="uname2" value="<?php if (isset($_POST['uname2'])) { print $_POST['uname2']; }?>" />
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<select name="gender" id="gender" class="form-control" data-error="Select your gender."
								required>
								 <option value="">Select gender</option>
								<option value="female">Female</option>
								<option value="male">Male</option>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-4">
						<div class="form-group">
							<input type="password" name="pass" class="form-control" maxlength="35" data-minlength="8" id="inputPassword" placeholder="Password :" data-error="Your password is required."
						  	  value="<?php if(isset($_POST['pass'])) { print $_POST['pass'];} ?>" onblur="regPass()"required />
						  	<div class="help-block">
							<span  id="reg" style="color: DarkRed;"><?php if(isset($invalid6)) { print $invalid6; } ?></span><br />
							<input type="hidden" id="sample" name="sample" value="<?php if (isset($_POST['sample'])) { print $_POST['sample']; }?>" />	
						  	<a style="text-decoration:none; background-"href="#" name="show" onclick="showPass()" value="show password" id="showBtn">Show password</a>&nbsp&nbsp&nbspPassword is minimum of 8 Characters</div>
							
						</div>
					</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="password" name="confirm" class="form-control" maxlength="35" id="inputConfirm" data-match="#inputPassword" placeholder="Confirm Password :" data-error="Your confirm password didn't match."
						 			value="<?php if(isset($_POST['confirm'])) { print $_POST['confirm'];} ?>" required />
									<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-2">
							<div class="form-group">
									<input type="text" name="lot_no" class="form-control" onblur="isLotNumber()" maxlength="4" id="inputLotno" placeholder="Lot no :" data-error="Your lot no. is required."
							 		value="<?php if(isset($_POST['lot_no'])) { print $_POST['lot_no'];}?>" required />	
									<span class="span2"><?php if(isset($error2)) print $error2; ?></span><br />
									<span id="invalidLot" style="color: DarkRed;"><?php if(isset($invalid7)) { print $invalid7; } ?></span>
									<input type="hidden" name="invalidLot" id="invalidLot2" value="<?php if (isset($_POST['invalidLot'])) { print $_POST['invalidLot']; }?>"/>
									<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
									<input type="text" name="street" class="form-control" maxlength="40" id="inputStreet" placeholder="Street :" data-error="Your street is required."
							 		value="<?php if(isset($_POST['street'])) { print $_POST['street'];}?>" required />	
									<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
									<input type="text" name="city" class="form-control" onblur="validateCity()" maxlength="40" id="inputCity" placeholder="City :" data-error="Your city is required."
							 		value="<?php if(isset($_POST['city'])) { print $_POST['city'];}?>" required />	
									<span  id="city" style="color: DarkRed;"><?php if(isset($invalid5)) { print $invalid5; } ?></span>
									<input type="hidden" id="city2" name="city2" value="<?php if (isset($_POST['city2'])) { print $_POST['city2']; }?>" />
									<div class="help-block with-errors"></div>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-5">
						<div class="form-group">
								<input type="text" name="cellphone_no" class="form-control" onblur="regCp()" maxlength="11" id="cellphone" data-minlength="11" placeholder="Cellphone Number :"
							 	data-error="Your cellphone number is empty"value="<?php if(isset($_POST['cellphone_no'])){ print $_POST['cellphone_no']; }?>" required />
								<span class="span2"><?php if(isset($error3)) print $error3; ?></span><br />
								<div class="help-block with-errors"></div>
								<input type="hidden" id="sample2" name="sample2" value="<?php if (isset($_POST['sample2'])) { print $_POST['sample2']; }?>"/>
								<span id="invalidCp" style="color: DarkRed;" name="invalidCp"><?php if(isset($invalid8)) { print $invalid8; } ?></span>
								<div class="help-block" id="regCp">Cellphone number must start in (09)</div>
								
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				<div class="form-group">
						<button type="submit" id="btnSign" class="btn btn-block">CREATE ACCOUNT</button>
				</div>
				</div>
				</div>
	</form>
	</div>
<script type="text/javascript">
	//=======================================================================================================================
	//=======================================================================================================================
	function showPass() {
		var show_pass = document.getElementById('inputPassword');
		var show_confirm = document.getElementById('inputConfirm');
		var show_Btn = document.getElementById('showBtn');
		if(show_Btn.innerHTML == 'Show password') {
			show_pass.getAttribute("type");
			show_pass.setAttribute("type","text");
			show_confirm.getAttribute("type");
			show_confirm.setAttribute("type","text");
			show_Btn.innerHTML = 'Hide password';
		} else {
			show_pass.getAttribute("type");
			show_pass.setAttribute("type","password");
			show_confirm.getAttribute("type");
			show_confirm.setAttribute("type","password");
			show_Btn.innerHTML = 'Show password';
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function regPass() {
		var re = /^(?=.*\d)(?=.*[a-z])\w{6,}$/;
		var show_pass = document.getElementById('inputPassword');
		if (show_pass.value != "") {
			if (!re.test(show_pass.value)) {
				document.getElementById('reg').innerHTML = "Password must contain atleast one characters or numbers.";
				document.getElementById('sample').value = "Enter a vali password.";
			} else {
				document.getElementById('reg').innerHTML = "";
				document.getElementById('sample').value = "";
			}
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function regCp() {
		var regCp = /^09/;
		var thisCellphone = document.getElementById('cellphone');
		if (thisCellphone.value != "") {
			if (isNaN(thisCellphone.value) || thisCellphone.length == 11) {
				document.getElementById('invalidCp').innerHTML = "Invalid cellphone number.";
				document.getElementById('sample2').value = "Invalid cellphone number.";
			} else if (thisCellphone.value == "") {
				document.getElementById('invalidCp').innerHTML = "";
				document.getElementById('sample2').value = "";
			} else {
				if (!regCp.test(thisCellphone.value)) {
					document.getElementById('regCp').style.color = "#ffa8a8";
					document.getElementById('sample2').value = "Cellphone number must start in 09.";
				} else {
					document.getElementById('regCp').style.color = "#000";
					document.getElementById('sample2').value = "";
				}
			}
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function isLotNumber() {
		var thisLotnumber = document.getElementById('inputLotno');
		if (thisLotnumber.value != "") {
			if (isNaN(thisLotnumber.value)) {
				document.getElementById('invalidLot').innerHTML = "Invalid lot number.";
				document.getElementById('invalidLot2').value = "Invalid lot number.";
			} else if (thisLotnumber.value == ""){
				document.getElementById('invalidLot').innerHTML = "";
				document.getElementById('invalidLot2').value = "Invalid lot number.";
			} else {
				document.getElementById('invalidLot').innerHTML = "";
				document.getElementById('invalidLot2').value = "";
			}
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function validateFname() {
		var thisFname = document.getElementById('inputFirstname');
		var regFname = /^[A-Za-z. -]+$/;
		if (thisFname.value != "") {
			if (!regFname.test(thisFname.value)) {
				document.getElementById('fname').innerHTML = "Enter a valid first name.";
				document.getElementById('fname2').value = "Enter a valid first name.";
			} else {
				document.getElementById('fname').innerHTML = "";
				document.getElementById('fname2').value = "";
			}
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function validateLname() {
		var thisLname = document.getElementById('inputLastname');
		var regLname = /^[A-Za-z. -]+$/;
		if (thisLname.value != "") {
			if (!regLname.test(thisLname.value)) {
				document.getElementById('lname').innerHTML = "Enter a valid last name.";
				document.getElementById('lname2').value = "Enter a valid last name.";
			} else {
				document.getElementById('lname').innerHTML = "";
				document.getElementById('lname2').value = "";
			}
		}
	}
	//=======================================================================================================================
	//=======================================================================================================================
	function validateMname() {
		var thisMname = document.getElementById('inputMiddlename');
		var regMname = /^[A-Za-z. -]+$/;
		if (thisMname.value != "") {
			if (!regMname.test(thisMname.value)) {
				document.getElementById('mname').innerHTML = "Enter a valid middle name.";
				document.getElementById('mname2').value = "Enter a valid name.";
			} else {
				document.getElementById('mname').innerHTML = "";
				document.getElementById('mname2').value = "";
			}
		}
	}
	//========================================================================================================================
	//========================================================================================================================
	function validateUname() {
		var thisUname = document.getElementById('inputUsername');
		var regUname = /^(?=.*\d)(?=.*[a-z])\w{6,}$/;
		if (thisUname.value != "") {
			if (!regUname.test(thisUname.value)) {
				document.getElementById('uname').innerHTML = "Username must contain atleast one characters or numbers.";
				document.getElementById('uname2').value = "Enter a valid name.";
			} else {
				document.getElementById('uname').innerHTML = "";
				document.getElementById('uname2').value = "";
			}
		}
	}
	//=========================================================================================================================
	//=========================================================================================================================
	function validateCity() {
		var thisCity = document.getElementById('inputCity');
		var regCity = /^[A-Za-z. -]+$/;
		if (thisCity.value != "") {
			if (!regCity.test(thisCity.value)) {
				document.getElementById('city').innerHTML = "Enter a valid city.";
				document.getElementById('city2').value = "Enter a valid city.";
			} else {
				document.getElementById('city').innerHTML = "";
				document.getElementById('city2').value = "";
			}
		}
	}
</script>
<?php 
//Inlude the footer of the webpage..
include ('../templates/footer.html'); 
?>
