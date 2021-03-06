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
$page_title = "Edit facilities";
//Include the header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Set the admin id to Auto Increment..
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
if(isset($_GET['facilities_id']) && is_numeric($_GET['facilities_id'])) {
	$facilities_id = $_GET['facilities_id'];
} elseif (isset($_POST['facilities_id']) && is_numeric($_POST['facilities_id'])) {
	$facilities_id = $_POST['facilities_id'];
} else {
	print '<h3><div class="col-md-2"></div>The page has been access in error</h3>';
} //End of isset($_GET['admin_id']) ..

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
//=======================================================================================================
if(!empty($_POST['this_capacity'])) {
	$problem = TRUE;
} else {
	$capacity = mysqli_real_escape_string($dbc, trim($_POST['capacity']));
}
//=======================================================================================================
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
// Check if error is empty..
	if(!$problem) {
			//Make a query..
			$lname = $_SESSION['last_name'];
			$fname = $_SESSION['first_name'];
			$type  = $_SESSION['user_type'];
			$query = "UPDATE facilities_package_table SET facilities_name = '$facilities_name',
					   capacity = '$capacity', description = '$description', image = '$image'
					   WHERE facilities_id = '$facilities_id' LIMIT 1";
			$result = mysqli_query($dbc, $query);
			$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
					   VALUES('$audit_id','$lname','$fname','edit facilities',NOW(),'$type')";
			$result2 = mysqli_query($dbc, $query2);		  
			if(@mysqli_affected_rows($dbc) == 1) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The facilities has been edited successfully !</h3>';
			} elseif (@mysqli_affected_rows($dbc) == 0) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The facilities has been edited successfully !</h3>'; 
			} else {
				print '<h1>The user could not be edited due to a system error.
						 We apologize for any inconvenience.</h1>';
						//Print the debugging message..
				print '<h2>' . mysqli_error($dbc) . '<br />Query: '. $query2 . ''; 
			}


}
}

//Retrieve the admin information and display it into the form..
$query = "SELECT facilities_name, capacity, description, 
		  image FROM facilities_package_table WHERE facilities_id = '$facilities_id' LIMIT 1";
$result = mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1) {
	//Get the user information..
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	

?>	

<div class="col-md-12">
<!--Display the registration form -->
    <form action="<?php print htmlspecialchars("edit_facilities.php?facilities_id=$facilities_id"); ?>" method="post" data-toggle="validator" enctype="multipart/form-data">
		<div class="col-md-2"></div>
			<h2 id="register">Edit Package Facilities</h3>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="facilities_name" class="form-control" maxlength="50" id="inputName" placeholder="Facilities Name" data-error="Facilities name is required."
									 value="<?php print $row[0]; ?>" required />
								<div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="capacity" class="form-control" onblur="isCapacity()" maxlength="4" id="inputCapacity" placeholder="Capacity" data-error="Capacity is required."
							 		value="<?php print $row[1]; ?>" required />
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
									
									<textarea name="description" class="form-control" maxlength="100" id="inputAddress" placeholder="Description" data-error="Description is required." required><?php print $row[2]; ?></textarea>
									<span class="error"><?php if(isset($error3)) print $error3; ?></span>
									<div class="help-block with-errors"></div>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="file" name="image" id="file" class="form-control" data-error="Please choose a image" required/>
								<span class="error"><?php if(isset($error4)) print $error4; ?></span>
								<div class="help-block with-errors"></div>
								<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
								<?php print '<img src="../../frontEnd/uploads_facilities/' . $row[3] . '" class="img-responsive" alt="image" style="height:350px; width:1000px;" />'; ?>
							</div>
						</div>
						
				</div>
				<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				<div class="form-group">
						<button type="submit" id="btnSign" class="btn btn-block">Edit Facilities</button>
				</div>
				<input type="hidden" name="facilities_id" class="form-control" id="inputFacilitiesid"
				              value="<?php print $facilities_id; ?>" />
				</div>
				</div>

	</form>
	</div>
	<script type="text/javascript">
		function isCapacity() {
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
} else {
	print '<h1>This page has been accessed in error.</h1>';
}	
mysqli_close($dbc); // Close the database connection..
//Inlude the footer of the webpage..
include('../templates/footer.html');
?>



















