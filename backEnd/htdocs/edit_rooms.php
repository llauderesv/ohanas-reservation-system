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
$page_title = "Edit rooms";
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
if(isset($_GET['room_id']) && is_numeric($_GET['room_id'])) {
	$room_id = $_GET['room_id'];
} elseif (isset($_POST['room_id']) && is_numeric($_POST['room_id'])) {
	$room_id = $_POST['room_id'];
} else {
	print '<h3><div class="col-md-2"></div>The page has been access in error</h3>';
} //End of isset($_GET['admin_id']) ..

//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
//Set the boolean Flag to false..
$problem = FALSE;

//Validation of form..
if(!empty($_POST['room_name'])) {
	$room_name = mysqli_real_escape_string($dbc, trim(ucwords($_POST['room_name'])));
} else {
	$problem = TRUE;
}
if(!empty($_POST['description'])) {
	$description = mysqli_real_escape_string($dbc, ucfirst($_POST['description']));
} else {
	$problem = TRUE;
	$error1 = "Description is required.";
}
//========================================================================================
if(!empty($_POST['this_capacity'])) {
	$problem = TRUE;
} else {
	$capacity = mysqli_real_escape_string($dbc, trim($_POST['capacity']));
}
//========================================================================================
if(!empty($_POST['this_price'])) {
	$problem = TRUE;
} else {
	$price = mysqli_real_escape_string($dbc, trim($_POST['price']));
}
//========================================================================================
if(!empty($_POST['room_type'])) {
	$room_type = mysqli_real_escape_string($dbc, ucfirst($_POST['room_type']));
} else {
	$problem = TRUE;
}
//========================================================================================
if (!empty($_POST['thisPrice'])) {
	$problem = TRUE;
}
//========================================================================================
if(is_uploaded_file($_FILES['image']['tmp_name'])) {

		//Create a temporary file name:
		$allowed = array('image/pjpeg','image/jpeg','image/JPG',
			             'image/X-PNG','image/PNG','image/PNG','image/png');

		if(in_array($_FILES['image']['type'], $allowed)) {

			//Move the file over:
			if(move_uploaded_file($_FILES['image']['tmp_name'], "../../frontEnd/uploads_rooms/{$_FILES['image']['name']}")) {
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
			$lname = $_SESSION['last_name'];
			$fname = $_SESSION['first_name'];
			$type  = $_SESSION['user_type'];
			//Make a query..
			$query = "UPDATE paid_room_table SET room_name = '$room_name',
					   description = '$description', capacity = '$capacity', price = '$price'
					   ,room_type = '$room_type' ,image = '$image'
					   WHERE room_id = '$room_id' LIMIT 1";
			$result = mysqli_query($dbc, $query);
			$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
						   VALUES('$audit_id','$lname','$fname','edit rooms',NOW(),'$type')";
			$result2 = mysqli_query($dbc, $query2);	
			if(@mysqli_affected_rows($dbc) == 1) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The room has been edited successfully !</h3>';
			} elseif (@mysqli_affected_rows($dbc) == 0) {
				//Print a message..
				print '<h3 class="success"><div class="col-md-2"></div>The room has been edited successfully !</h3>'; 
			} else {
				print '<h1>The user could not be edited due to a system error.
						 We apologize for any inconvenience.</h1>';
						//Print the debugging message..
				print '<h2>' . mysqli_error($dbc) . '<br />Query: '. $query2 . ''; 
			}


}
}

//Retrieve the admin information and display it into the form..
$query = "SELECT room_name, description, capacity, price, room_type, 
		  image FROM paid_room_table WHERE room_id = '$room_id' LIMIT 1";
$result = mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1) {
	//Get the user information..
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	

?>	

<div class="col-md-12">
<!--Display the registration form -->
    <form action="<?php print htmlspecialchars("edit_rooms.php?room_id=$room_id"); ?>" method="post" data-toggle="validator" enctype="multipart/form-data">
		<div class="col-md-2"></div>
			<h2 id="register">Edit Paid Rooms</h3>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="room_name" class="form-control" maxlength="50" id="inputName" placeholder="Facilities Name" data-error="Facilities name is required."
									 value="<?php print $row[0]; ?>" required />
								<div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="capacity" class="form-control" onblur="isCapacity()" maxlength="4" id="inputCapacity" placeholder="Capacity" data-error="Capacity is required."
							 		value="<?php print $row[2]; ?>" required />
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
									<textarea name="description" class="form-control" maxlength="100" id="inputAddress" placeholder="Description" data-error="Description is required." required><?php print $row[1]; ?></textarea>		
									<div class="help-block with-errors"><div class="help-block with-errors"><span class="error"><?php if(isset($error1)) print $error1; ?></span></div></div>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-4">
						<div class="form-group">
								<input type="text" name="price" class="form-control" maxlength="4" onblur="isPrice()" id="inputPrice" placeholder="Price" data-error="Price is required."
									 value="<?php print $row[3]; ?>" required />
								<span class="error" id="validate2"></span>
								<span class="error" id="validate23"></span>
								<input type="hidden" name="this_price" id="errors3" />
								<input type="hidden" name="thisPrice" id="errors23" />
								<br /><div class="help-block with-errors"></div>
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
							<select name="room_type" id="room_type" class="form-control" data-error="Please select your room type."
								required>
								<?php if($row[4] == "Condo type") {
										  	print '<option value="Condo type">Condo type</option>
								                   <option value="Dorm type">Dorm type</option>'; 
									      	}
							 	          else {
							 	          	print '<option value="Air condition">Air condition</option>
							 	          	       <option value="Dorm type">Dorm type</option>';
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
						<div class="col-md-8">
							<div class="form-group">
								<input type="file" name="image" id="file" class="form-control" data-error="Please choose a image" required/>
								<div class="help-block with-errors"></div>
								<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
								<?php print '<img src="../../frontEnd/uploads_rooms/' . $row[5] . '" class="img-responsive" alt="image" style="height:350px; width:1000px;" />'; ?>
							</div>
						</div>
						
				</div>
				<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-2">
				<div class="form-group">
						<button type="submit" id="btnSign" class="btn btn-block">Edit room</button>
				</div>
				<input type="hidden" name="room_id" class="form-control" id="inputRoomid"
				              value="<?php print $room_id; ?>" />
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
		function isPrice() {
			var regNum = /^[0-9]+$/;
			var thisPrice = document.getElementById('inputPrice').value;
		  	if (!regNum.test(thisPrice)) {
		  		document.getElementById('validate23').innerHTML = "Invalid price";
				document.getElementById('errors23').value = "Invalid price";
		  	} else {
		  		document.getElementById('validate23').innerHTML = "";
				document.getElementById('errors23').value = "";
		  	}
			if (isNaN(document.getElementById('inputPrice').value)) {
				document.getElementById('validate2').innerHTML = "Enter a number only";
				document.getElementById('errors3').value = "Invalid price";
			} else {
				document.getElementById('validate2').innerHTML = "";
				document.getElementById('errors3').value = "";
			}
		}
	</script>
<?php
} else {
	print '<h1>This page has been accessed in error.</h1>';
}	
mysqli_close($dbc); // Close the database connection..
//Include the footer of the webpage..
include('../templates/footer.html');
?>



















