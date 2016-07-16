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
// Set the page title and include the HTML header..
$page_title = "Edit User";
//Include the header..
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
//Get the user id in the address bar and check it is numeric..
if(isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
} elseif (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
	$user_id = $_POST['user_id'];
} else {
	print '<h3><div class="col-md-2"></div>The page has been access in error</h3>';
} //End of isset($_GET['admin_id']) ..

//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
//Set the boolean Flag to false..
$problem = FALSE;

//Validation of form..
if(!empty($_POST['last_name'])) {
	$last_name = mysqli_real_escape_string($dbc, trim(ucwords($_POST['last_name'])));
} else {
	$problem = TRUE;
}
if(!empty($_POST['first_name'])) {
	$first_name = mysqli_real_escape_string($dbc, ucwords($_POST['first_name']));
} else {
	$problem = TRUE;
}
if(!empty($_POST['email_address'])) {
	$email_address = mysqli_real_escape_string($dbc, trim($_POST['email_address']));
} else {
	$problem = TRUE;
}

if(!empty($_POST['user_type'])) {
	$user_type = mysqli_real_escape_string($dbc, trim(ucwords($_POST['user_type'])));
} else {
	$problem = TRUE;
}

if(!empty($_POST['username'])) {
	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
} else {
	$problem = TRUE;
}

if(!empty($_POST['gender'])) {
	$gender = mysqli_real_escape_string($dbc, trim(ucwords($_POST['gender'])));
} else {
	$problem = TRUE;
}

if(!empty($_POST['pass'])) {
	$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
} else {
	$problem = TRUE;
}

if($_POST['confirm'] != $_POST['pass'] || empty($_POST['confirm'])){
	$problem = TRUE;
}

if(!empty($_POST['address'])) {
	$address = mysqli_real_escape_string($dbc, trim(ucfirst($_POST['address'])));
} else {
	$problem = TRUE;
}
if(!empty($_POST['sample'])) {
	$problem = TRUE;
	$invalid1 = "Password must contain atleast one characters or numbers.";
} else {
	$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
}

if(!empty($_POST['sample2'])) {
	$problem = TRUE;
	$invalid2 = "Invalid cellphone number.";
} else {
	$cellphone_no = mysqli_real_escape_string($dbc, trim($_POST['cellphone_no']));
}

if(!empty($_POST['fname2'])) {
	$problem = TRUE;
	$invalid3 = "Enter a valid first name.";
}

if(!empty($_POST['lname2'])) {
	$problem = TRUE;
	$invalid4 = "Enter a valid last name.";
}

if(!empty($_POST['mname2'])) {
	$problem = TRUE;
	$invalid5 = "Enter a valid middle name.";
}

if(!empty($_POST['uname2'])) {
	$problem = TRUE;
	$invalid6 = "Username must contain atleast one characters or numbers.";
}

// Check if error is empty..
	if(!$problem) {
	//Make a query statement and check for the unique email address..
	$middle_name = ucfirst($_POST['middle_name']);
	$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
	$query = "SELECT user_id FROM user_info_table 
	          WHERE email_address = '$email_address' AND user_id != '$user_id' LIMIT 1";
	$result = mysqli_query($dbc, $query);
	$num = mysqli_num_rows($result);
		if($num == 0) {
			$lname = $_SESSION['last_name'];
			$fname = $_SESSION['first_name'];
			$type  = $_SESSION['user_type'];
			//Make a query..
			$query2 = "UPDATE user_info_table SET last_name = '$last_name',
					   first_name = '$first_name', middle_name = '$middle_name',
					   gender = '$gender', cellphone_no = '$cellphone_no', 
					   address = '$address' , email_address = '$email_address'
					   WHERE user_id = '$user_id' LIMIT 1";
			$query3 = "UPDATE user_account_table SET username = '$username',
					   pass = AES_ENCRYPT('$pass','$key'), user_type = '$user_type'
					   WHERE user_id = $user_id LIMIT 1";
			$result2 = mysqli_query($dbc, $query2);
			$result3 = mysqli_query($dbc, $query3);
			$query3 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
						   VALUES('$audit_id','$lname','$fname','edit user',NOW(),'$type')";
			$result3 = mysqli_query($dbc, $query3);	
			if(mysqli_affected_rows($dbc) == 1) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The user has been edited successfully !</h3>';
			} elseif (mysqli_affected_rows($dbc) == 0) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The user has been edited successfully !</h3>'; 
			} else {
				print '<h1>The user could not be edited due to a system error.
						 We apologize for any inconvenience.</h1>';
						//Print the debugging message..
				print '<h2>' . mysqli_error($dbc) . '<br />Query: '. $query2 . ''; 
			}
		} else {
			print '<h1>The email address has already been registered</h1>';
		}


	} //End of if(!$problem)..

}
//Retrieve the admin information and display it into the form..
$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
$query = "SELECT last_name, first_name, middle_name, 
		  gender, cellphone_no, address, email_address
          FROM user_info_table WHERE user_id = '$user_id' LIMIT 1";

$result = mysqli_query($dbc, $query);
$num = mysqli_num_rows($result);
//Retrieve the admin account and display it into the form..
$query2 = "SELECT username, AES_DECRYPT(pass,'$key'),
		   user_type FROM user_account_table 
		   WHERE user_id = '$user_id' LIMIT 1";
$result2 = mysqli_query($dbc, $query2);
$num2 = mysqli_num_rows($result2);


if($num == 1 && $num2 == 1) {
	//Get the user information..
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);

?>	

<div class="col-md-12">
<!--Display the Edit form -->
    <form action="<?php print htmlspecialchars("edit_user.php?user_id=$user_id"); ?>" method="post" data-toggle="validator">
		<div class="col-md-2"></div>
			<h2 id="register">Edit user</h3>

				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-3">
						<div class="form-group">
								<input type="text" name="last_name" class="form-control" maxlength="40" onblur="validateLname()" id="inputLastname" placeholder="Last Name" data-error="Your last name is required."
									 value="<?php print $row[0]; ?>" required />
								<span style="color: DarkRed;" id="lname"><?php if(isset($invalid4)) { print $invalid4; } ?></span><br />
								<input type="hidden" id="lname2" name="lname2" value="<?php if (isset($_POST['lname'])) { print $_POST['lname']; }?>" />
								<div class="help-block with-errors"></div>
						</div>
					</div>	

					<div class="col-md-3">
						<div class="form-group">
								<input type="text" name="first_name" class="form-control" maxlength="20" onblur="validateFname()" id="inputFirstname" placeholder="First Name" data-error="Your first name is required."
							 		value="<?php print $row[1]; ?>" required />
								<span style="color: DarkRed;" id="fname"><?php if(isset($invalid3)) { print $invalid3; } ?></span><br />
								<input type="hidden" id="fname2" name="fname2" value="<?php if (isset($_POST['fname2'])) { print $_POST['fname2']; }?>" />
								<div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-2">
						<div class="form-group">
								<input type="text" name="middle_name" class="form-control" maxlength="20" onblur="validateMname()" id="inputMiddlename" placeholder="Middle Name(optional)" 
							 		value="<?php print $row[2]; ?>" />
								<span style="color: DarkRed;" id="mname"><?php if(isset($invalid5)) { print $invalid5; } ?></span><br />
								<input type="hidden" id="mname2" name="mname2" value="<?php if (isset($_POST['mname2'])) { print $_POST['mname2']; }?>" />
						</div>
					</div>	
				</div>

				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="email" name="email_address" class="form-control" pattern="^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$" maxlength="40" id="inputEmail" placeholder="Email Address" data-error="Please enter a valid email address." 
						       value="<?php print $row[6]; ?>" required />
						    <span class="error"><?php if(isset($error)) print $error; ?></span><br />
							<div class="help-block with-errors"></div>	
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
							<select name="user_type" id="selectUser" class="form-control" data-error="Please select a user type."
							 required>
								    <?php if($row2[2] == "Administrator") {
										  	print '<option value="Administrator">Administrator</option>
								                   <option value="Book manager">Book manager</option>'; 
									      	}
							 	          else {
							 	          	print '<option value="Book manager">Book manager</option>
							 	          	       <option value="Administrator">Administrator</option>';
							 	           }
							 	    ?>
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
							<input type="text" name="username" class="form-control" maxlength="20" onblur="validateUname()" id="inputUsername" placeholder="Username" data-error="Your username is required."
								value="<?php print $row2[0]; ?>" required />	
							<span style="color: DarkRed;" id="uname"><?php if(isset($invalid6)) { print $invalid6; } ?></span><br />
							<input type="hidden" id="uname2" name="uname2" value="<?php if (isset($_POST['uname2'])) { print $_POST['uname2']; }?>" />
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<select name="gender" id="gender" class="form-control" data-error="Please select your gender."
								required>
									<?php if($row[3] == "Male") {
										  	print '<option value="Male">Male</option>
									               <option value="Female">Female</option>'; 
									      	}
							 	          else {
							 	          	print '<option value="Female">Female</option>
							 	          	       <option value="Male">Male</option>';
							 	           }
							 	    ?>
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
							<input type="password" name="pass" onblur="regPass()" class="form-control" maxlength="40" data-minlength="8" id="inputPassword" placeholder="Password" data-error="Your password is required."
						  	  value="<?php print $row2[1]; ?>" required />
						  	<span style="color: DarkRed;" id="reg"><?php if(isset($invalid1)) { print $invalid1; } ?></span><br />
							<input type="hidden" id="sample" name="sample" value="<?php if (isset($_POST['sample'])) { print $_POST['sample']; }?>" />
							<div class="help-block"><a style="text-decoration:none; background-"href="#" name="show" onclick="showPass()" value="show password" id="showBtn">Show password</a>&nbsp&nbsp&nbspPassword is minimum of 8 Characters</div>
						</div>
					</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="password" name="confirm" class="form-control" maxlength="40" id="inputConfirm" data-match="#inputPassword" placeholder="Confirm Password" data-error="Your confirm password didn't match."
						 			value="<?php print $row2[1]; ?>" required />
									<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-8">
							<div class="form-group">
									<textarea name="address" class="form-control" maxlength="100" id="inputAddress" placeholder="Address" data-error="Your address is required."><?php print $row[5];?></textarea>
									<span class="error"><?php if(isset($error2)) print $error2; ?></span><br />
									<div class="help-block with-errors"></div>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-5">
						<div class="form-group">
									<input type="text" name="cellphone_no" class="form-control" onblur="regCp()" maxlength="11" id="inputContact" data-minlength="11" placeholder="Cellphone Number"
							 		data-error="Your cellphone number is empty"value="<?php print $row[4]; ?>" required />
								<span class="span2"><?php if(isset($error3)) print $error3; ?></span><br />
								<span id="invalidCp" style="color: DarkRed;" name="invalidCp"><?php if(isset($invalid2)) { print $invalid2; } ?></span>
								<input type="hidden" id="sample2" name="sample2" value="<?php if (isset($_POST['sample2'])) { print $_POST['sample2']; }?>" />
								<div class="help-block with-errors"></div>
								<div class="help-block" id="regCp">Cellphone number must start in (09)</div>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				<div class="form-group">
						<button type="submit" id="btnSign" class="btn btn-block">Edit Account</button>
				</div>
				<input type="hidden" name="user_id" class="form-control" id="inputAdminid"
				 value="<?php print $user_id; ?>" />
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
</script>
<?php
} else {
	print '<h3>This page has been accessed in error.</h3>';

}	
//Close the database connection..
mysqli_close($dbc);
//Include the footer of the webpage..
include('../templates/footer.html');
?>



















