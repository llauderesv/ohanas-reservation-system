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

$page_title = "Add package facilities";
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
$query = "SELECT facilities_id FROM facilities_package_table";
$result = mysqli_query($dbc, $query);
$num = mysqli_num_rows($result);
if($num <= 0) {
	$facilities_id = 2015001;
} else {
	$query2 = "SELECT MAX(facilities_id) FROM facilities_package_table";
	$result2 = mysqli_query($dbc, $query2);
	$row = mysqli_fetch_array($result2, MYSQLI_NUM);
	$facilities_id = $row[0] + 1;
}

//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
//Set the boolean Flag to false..
$problem = FALSE;

//Validation of form..
if(!empty($_POST['facilities_name'])) {
	$facilities_name = mysqli_real_escape_string($dbc, trim(ucwords($_POST['facilities_name'])));
} else {
	$problem = TRUE;
}
if(!empty($_POST['this_capacity'])) {
	$problem = TRUE;
} else {
	$capacity = mysqli_real_escape_string($dbc, trim(ucwords($_POST['capacity'])));
}
if(!empty($_POST['description'])) {
	$description = mysqli_real_escape_string($dbc, ucfirst($_POST['description']));
} else {
	$problem = TRUE;
	$error3 = "Description is required.";
}
if(is_uploaded_file($_FILES['image']['tmp_name'])) {

		//Create a temporary file name:
		$allowed = array('image/pjpeg','image/jpeg','image/JPG',
			             'image/X-PNG','image/PNG','image/PNG','image/png');

		if(in_array($_FILES['image']['type'], $allowed)) {

			//Move the file over:
			if(move_uploaded_file($_FILES['image']['tmp_name'], "../../frontEnd/uploads_facilities/{$_FILES['image']['name']}")) {
				//Set the i$ variable to the image's name:

				$image = $_FILES['image']['name'];
			} else {
				$problem = TRUE;
				$temp = $_FILES['image']['name'];
			}

		} else {
			$error4 = "Please upload a JPEG or PNG image.";
		}

	} else {
		$temp = NULL;
		$problem = TRUE;
	}
	//Delete the file if it still exists:
	if(file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name'])) {
		unlink ($_FILES['image']['tmp_name']);
	}

// Check if problem is false insert data information to database..
if(!$problem) {
	$lname = $_SESSION['last_name'];
	$fname = $_SESSION['first_name'];
	$type  = $_SESSION['user_type'];
	//Make a query..
	$query3 = "INSERT INTO facilities_package_table 
	(facilities_id, facilities_name, description, capacity, image) 
	VALUES
	('$facilities_id', '$facilities_name', '$description', '$capacity', '$image')";
	$result3 = mysqli_query($dbc, $query3);
	$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
				VALUES('$audit_id','$lname','$fname','add facilities',NOW(),'$type')";
	$result2 = mysqli_query($dbc, $query2);	
	//Check if the query is work..
	if($result3) {
		print '<h3 class="success"><div class="col-md-2"></div>NEW PACKAGE SUCCESSFULLY ADDED !</h3>';
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

<div class="col-md-12">
<!--Display the registration form -->
    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" data-toggle="validator" enctype="multipart/form-data">
		<div class="col-md-2"></div>
			<h2 id="register">ADD PACKAGE FACILITIES</h3>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="facilities_name" class="form-control" maxlength="45" id="inputName" placeholder="Facilities Name :" data-error="Facilities name is required."
									 value="<?php if(isset($_POST['facilities_name'])) { print $_POST['facilities_name'];}?>" required />
								<div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="capacity" class="form-control" maxlength="4" onblur="isNumber()" id="inputCapacity" placeholder="Capacity :" data-error="Capacity is required."
							 		value="<?php if(isset($_POST['capacity'])) { print $_POST['capacity'];}?>" required />
							 		<span class="error" id="validate"></span><br />
							 		<input type="hidden" name="this_capacity" id="errors2" />
									<div class="help-block with-errors"></div>
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-8">
							<div class="form-group">
									<textarea name="description" class="form-control" maxlength="495" id="inputAddress" placeholder="Description :" data-error="Description is required." required></textarea>
									<span class="error"><?php if(isset($error3)) print $error3; ?></span><br />
									<div class="help-block with-errors"></div>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="file" name="image" id="file" class="form-control" data-error="Please choose an image." required/>
								<span class="error"><?php if(isset($error4)) print $error4; ?></span><br />
								<div class="help-block with-errors"></div>
								<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
							</div>
						</div>
				</div>
				<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				<div class="form-group">
						<button type="submit" id="btnSign" class="btn btn-block">ADD FACILITIES</button>
				</div>
				</div>
				</div>
	</form>
	</div>
<script type="text/javascript">
	function isNumber() {
		if (isNaN(document.getElementById('inputCapacity').value)) {
			document.getElementById('validate').innerHTML = "Enter a number only";
			document.getElementById('errors2').value = "Invalid capacity";
		} else {
			document.getElementById('validate').innerHTML = "";
			document.getElementById('errors2').value = "";
		}
	}
</script>
<?php
//Include the footer of the webpage..
include ('../templates/footer.html');
?>
