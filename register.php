<?php
session_start();
//Set the title of the webpage
$pagetitle = "Register your account"; 
//Include the header of the page
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Set the admin id to Auto Increment..
$querys = "SELECT customer_id FROM customer_info_table";
$results = mysqli_query($dbc, $querys);
$num = mysqli_num_rows($results);
if($num <= 0) {
	$customer_id = 2015001;
} else {
	$query2 = "SELECT MAX(customer_id) FROM customer_info_table";
	$result2 = mysqli_query($dbc, $query2);
	$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
	$customer_id = $row2[0] + 1;
}
//======================================================================================================
$q = "SELECT account_id FROM customer_account_table";
$r = mysqli_query($dbc, $q);
$n = mysqli_num_rows($r);
if($n <= 0) {
	$account_id = 10001;
} else {
	$q2 = "SELECT MAX(account_id) FROM customer_account_table";
	$r2 = mysqli_query($dbc, $q2);
	$row3 = mysqli_fetch_array($r2, MYSQLI_NUM);
	$account_id = $row3[0] + 1;
}
//=======================================================================================================
//=======================================================================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$problem = FALSE;
//=======================================================================================================
	if (!empty($_POST['fname'])) {
		$fname = mysqli_real_escape_string($dbc, trim(ucfirst($_POST['fname'])));
	} else {
		$problem = TRUE;
	}
	if (!empty($_POST['sample'])) {
		$problem = TRUE;
		$invalid5 = "Password must contain atleast one characters or numbers";
	}

	if (!empty($_POST['fname2'])) {
		$problem = TRUE;
		$invalid1 = "Enter a valid first name";
	}

	if (!empty($_POST['lname2'])) {
		$problem = TRUE;
		$invalid2 = "Enter a valid last name";
	}

	if (!empty($_POST['mname2'])) {
		$problem = TRUE;
		$invalid3 = "Enter a valid middle name";
	}

	if (!empty($_POST['uname2'])) {
		$problem = TRUE;
		$invalid4 = "Username must contain atleast one characters or numbers";
	}

	if (!empty($_POST['eaddress2'])) {
		$problem = TRUE;
		$invalid7 = "Enter a valid email address";
	}
//=======================================================================================================
	if (!empty($_POST['lname'])) {
		$lname = mysqli_real_escape_string($dbc, trim(ucfirst($_POST['lname'])));
	} else {
		$problem = TRUE;
	}
//=======================================================================================================
	if (!empty($_POST['email_address'])) {
		$email_address = mysqli_real_escape_string($dbc, trim($_POST['email_address']));
		$query3 = "SELECT customer_id FROM customer_info_table WHERE email_address = '$email_address'";
		$result3 = mysqli_query($dbc, $query3);
		$num3 = mysqli_num_rows($result3);
		if($num3 > 0) {
			$problem = TRUE;
			$_POST['email_address'] = "";
			$error2 = "Your email adress is already used.";
		}
	} else {
		$problem = TRUE;
	}
//=======================================================================================================
	if (!empty($_POST['username'])) {
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$query4 = "SELECT customer_id FROM customer_account_table WHERE  = '$username'";
		$result4 = mysqli_query($dbc, $query3);
		$num3 = mysqli_num_rows($result3);
		if($num3 > 0) {
			$problem = TRUE;
			$_POST['username'] ="";
			$error3 = "Your username is already used.";
		}
	} else {
		$problem = TRUE;
	}
//=======================================================================================================
	if(!empty($_POST['gender'])) {
		$gender = mysqli_real_escape_string($dbc, trim(ucfirst($_POST['gender'])));
	} else {
		$problem = TRUE;
	}
//=======================================================================================================
	if(!empty($_POST['address'])) {
		$address = mysqli_real_escape_string($dbc, trim(ucwords($_POST['address'])));
	} else {
		$problem = TRUE;
	}
//=======================================================================================================
	if(!empty($_POST['sample2']) ) {
		$problem = TRUE;
		$invalid6 = "Invalid cellphone number";
	} else {
		$cellphone_number = mysqli_real_escape_string($dbc, trim($_POST['cellphone_number']));
	}
//========================================================================================================
	if(!empty($_POST['pass'])) {
		if($_POST['confirm'] != $_POST['pass'] || empty($_POST['confirm'])){
			$problem = TRUE;
		} else {
			$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
		}
		
	} else {
		$problem = TRUE;
	}
//========================================================================================================
	if(!$problem) {
		$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
		$mname = ucfirst($_POST['mname']);
		$_SESSION['uname'] = $username;
		$_SESSION['pass'] = $pass;
//========================================================================================================
		$query5 = "INSERT INTO customer_info_table 
		(customer_id, last_name, first_name, middle_name, gender, cellphone_no, address, email_address) 
		VALUES
		('$customer_id', '$lname', '$fname', '$mname', '$gender', '$cellphone_number', '$address', '$email_address')";
		$result5 = mysqli_query($dbc, $query5);
//========================================================================================================
		$query6 = "INSERT INTO customer_account_table
		(account_id, customer_id, username, pass)
		VALUES
		('$account_id', '$customer_id', '$username', AES_ENCRYPT('$pass','$key'))";
		$result6 = mysqli_query($dbc, $query6);
		//Check if the query is work..
		if($result5 && $result6) {
			$success2 = 'YOU ARE NOW REGISTERED! YOUR MAY NOW PROCEED TO THE LOGIN.';
			$_POST = array();
		} else {
			print '<h3><div class="col-md-2"></div>System error you could not be registered 
					at this time due to a system error. <br />
					We apologize for any inconvenience </h3>';
			print '<p><div class="col-md-2"></div>The error has been occured '. mysqli_error($dbc).'...</p>';
		}
		if ($result6) {
			$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
			$query = "	SELECT account_id, customer_id FROM customer_account_table 
					 	WHERE username = '$username' AND pass = AES_ENCRYPT('$pass','$key')
					 ";
			$result = mysqli_query($dbc, $query);

			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				$_SESSION['account_id'] = $row[0];
				$_SESSION['customer_id'] = $row[1];
				header('Location: choose_date.php');
				exit();
			}
		}
	}
}
/*
			 */
			//========================================================================================================
?>
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header7.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div><br />
<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10" id="registration">
			<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" data-toggle="validator" id="forms">
				<div class="row">
					<div class="col-md-12 bg-warning" id="per_title">
						PERSONAL INFORMATION<br />
						<?php if (isset($success2)) print $success2; ?>
					</div>
				</div><br />
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="fname" class="form-control" onblur="validateFname()" placeholder="First name :" maxlength="25" data-error="Your first name is required."
									 value="<?php if (isset($_POST['fname'])) { print $_POST['fname']; }?>" id="txtfname" required />
								<span class="span2" id="fname" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid1)){ print $invalid1; } ?></span>
								<input type="hidden" id="fname2" name="fname2" value="<?php if (isset($_POST['fname2'])) { print $_POST['fname2']; }?>" />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="email_address" class="form-control" placeholder="Email Address :" onblur="validateEmail()" maxlength="45" data-error="Your email address is required."
									value="<?php if (isset($_POST['email_address'])) { print $_POST['email_address']; }?>" id="txtemail" required />
								<span class="span2" id="eaddress" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid7)){ print $invalid7; } ?></span>
								<input type="hidden" id="eaddress2" name="eaddress2" value="<?php if (isset($_POST['eaddress2'])) { print $_POST['eaddress2']; }?>" />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
								<span class="span2"><?php if (isset($error2)) { print $error2; }?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="lname" class="form-control" onblur="validateLname()" placeholder="Last name :" maxlength="35" data-error="Your last name is required."
									value="<?php if (isset($_POST['lname'])) { print $_POST['lname']; }?>" id="txtlname" required />
								<span class="span2" id="lname" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid2)){ print $invalid2; } ?></span>
								<input type="hidden" id="lname2" name="lname2" value="<?php if (isset($_POST['lname2'])) { print $_POST['lname2']; }?>" />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="username" class="form-control" onblur="validateUname()" placeholder="Username :" maxlength="35" data-error="Your username is required." 
									value="<?php if (isset($_POST['username'])) { print $_POST['username']; }?>" id="txtuname" required />
								<span class="span2" id="uname" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid4)){ print $invalid4; } ?></span>
								<input type="hidden" id="uname2" name="uname2" value="<?php if (isset($_POST['uname2'])) { print $_POST['uname2']; }?>" />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
								<span class="span2"><?php if (isset($error3)) { print $error3; }?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="mname" class="form-control" onblur="validateMname()" placeholder="Middle name : (Optional)" maxlength="15" 
									value="<?php if (isset($_POST['mname'])) { print $_POST['mname']; }?>" id="txtmname" />
								<span class="span2" id="mname" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid3)){ print $invalid3; } ?></span>
								<input type="hidden" id="mname2" name="mname2" value="<?php if (isset($_POST['mname2'])) { print $_POST['mname2']; }?>" />
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="password" name="pass" onblur="regPass()"  id="inputPassword" class="form-control" placeholder="Password :" data-minlength="8" maxlength="35" data-error="Enter a valid password." 
									value="<?php if (isset($_POST['pass'])) { print $_POST['pass']; }?>" required />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
								<div class="help-block" style="font-weight: 700; color: #FFF">
								<span class="span2" id="reg" style="color:#ffa8a8; font-weight: 700;"><?php if(isset($invalid5)){ print $invalid5; } ?></span>
								<input type="hidden" id="sample" name="sample" value="<?php if (isset($_POST['sample'])) { print $_POST['sample']; }?>" />	
								<a href="#" class="button"name="show" onclick="showPass()" value="show password" id="showBtn">Show password</a><br /><br />Password is minimum of 8 Characters</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<select name="gender" class="form-control" data-error="Select your gender" id="gender" required>
									<option value="">Select Gender</option>
									<option value="female">Female</option>
									<option value="male">Male</option>
								</select>
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="password" name="confirm" data-match="#inputPassword" id="inputConfirm" class="form-control" placeholder="Confirm Password :" maxlength="35" data-error="Your confirm password didn't match" 
								value="<?php if (isset($_POST['confirm'])) { print $_POST['confirm']; }?>"  required/>
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" name="cellphone_number" onblur="regCp()" class="form-control" placeholder="Cellphone number :" maxlength="11" data-error="Your cellphone number is empty" 
								value="<?php if (isset($_POST['cellphone_number'])) { print $_POST['cellphone_number']; }?>" id="cellphone" required />
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
								<input type="hidden" id="sample2" name="sample2" value="<?php if (isset($_POST['sample2'])) { print $_POST['sample2']; }?>"/>
								<span id="invalidCp" style="color:#ffa8a8; font-weight: 700;" name="invalidCp"><?php if(isset($invalid6)){ print $invalid6; } ?></span>
								<div class="help-block" style="font-weight: 700; color: #FFF" id="regCp">
									<p>Your cellphone number must start in 09</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group">
								<textarea name="address" placeholder="Address :" class="form-control" maxlength="95" data-error="Your address is required."
								id="address" rows="1" required><?php if (isset($_POST['address'])) {print $_POST['address']; }?></textarea>
								<div class="help-block with-errors" style="color:#ffa8a8; font-weight: 700;"></div>
							</div>
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-block" id="next2" name="register">REGISTER ACCOUNT</button><br />
						</div><br />
					</div><br /><br /><br />
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
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

	function regCp() {
		var regCp = /^09/;
		var regNum = /^[0-9]+$/;
		var thisCellphone = document.getElementById('cellphone');
		//var show_confirm = document.getElementById('inputConfirm');
		if (thisCellphone.value != "") {
			if (regNum.test(thisCellphone.value)) {
				if (isNaN(thisCellphone.value) || thisCellphone.value.length != 11) {
					document.getElementById('invalidCp').innerHTML = "Invalid cellphone number";
					document.getElementById('sample2').value = "Invalid cellphone number";
				} else if (thisCellphone.value == "" || thisCellphone.value.length == 11) {
					document.getElementById('invalidCp').innerHTML = "";
					document.getElementById('sample2').value = "";
				} else {
					if (!regCp.test(thisCellphone.value)) {
						document.getElementById('regCp').style.color = "#ffa8a8";
						document.getElementById('sample2').value = "Cellphone number must start in 09.";
					} else {
						document.getElementById('regCp').style.color = "#FFF";
						document.getElementById('sample2').value = "";
					}
				}
			} else {
				document.getElementById('invalidCp').innerHTML = "Invalid cellphone number";
				document.getElementById('sample2').value = "Invalid cellphone number";
			}
		}
	}

	window.onload = init;
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

	function validateFname() {
		var thisFname = document.getElementById('txtfname');
		var regFname = /^[A-Za-z. -]+$/;
		if (thisFname.value != "") {
			if (!regFname.test(thisFname.value)) {
				document.getElementById('fname').innerHTML = "Enter a valid first name";
				document.getElementById('fname2').value = "Enter a valid first name";
			} else {
				document.getElementById('fname').innerHTML = "";
				document.getElementById('fname2').value = "";
			}
		}
	}

	function validateLname() {
		var thisLname = document.getElementById('txtlname');
		var regLname = /^[A-Za-z. -]+$/;
		if (thisLname.value != "") {
			if (!regLname.test(thisLname.value)) {
				document.getElementById('lname').innerHTML = "Enter a valid last name";
				document.getElementById('lname2').value = "Enter a valid last name";
			} else {
				document.getElementById('lname').innerHTML = "";
				document.getElementById('lname2').value = "";
			}
		}
	}

	function validateUname() {
		var thisUname = document.getElementById('txtuname');
		var regUname = /^(?=.*\d)(?=.*[a-z])\w{6,}$/;
		if (thisUname.value != "") {
			if (!regUname.test(thisUname.value)) {
				document.getElementById('uname').innerHTML = "Username must contain atleast one characters or numbers.";
				document.getElementById('uname2').value = "Enter a valid name";
			} else {
				document.getElementById('uname').innerHTML = "";
				document.getElementById('uname2').value = "";
			}
		}
	}

	function validateMname() {
		var thisMname = document.getElementById('txtmname');
		var regMname = /^[A-Za-z. -]+$/;
		if (thisMname.value != "") {
			if (!regMname.test(thisMname.value)) {
				document.getElementById('mname').innerHTML = "Enter a valid middle name.";
				document.getElementById('mname2').value = "Enter a valid name";
			} else {
				document.getElementById('mname').innerHTML = "";
				document.getElementById('mname2').value = "";
			}
		}
	}

	function validateEmail() {
		var regEmail = /^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/;
		var thisEmail = document.getElementById('txtemail');

		if (thisEmail.value != "") {
			if (!regEmail.test(thisEmail.value)) {
				document.getElementById('eaddress').innerHTML = "Enter a valid email address.";
				document.getElementById('eaddress2').value = "Enter a valid middle name.";
			} else {
				document.getElementById('eaddress').innerHTML = "";
				document.getElementById('eaddress2').value = "";
			}
		} else {
			document.getElementById('eaddress').innerHTML = "";
			document.getElementById('eaddress2').value = "";
		}
	}
</script>
<?php
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>
