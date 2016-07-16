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
$page_title = "Delete Customerr";
//Include the header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Get the user id in the address bar and check it is numeric..
if(isset($_GET['customer_id']) && is_numeric($_GET['customer_id'])) {
	$customer_id = $_GET['customer_id'];
} elseif (isset($_POST['customer_id']) && is_numeric($_POST['customer_id'])) {
	$customer_id = $_POST['customer_id'];
} else {
	print '<h3>The page has been access in error</h3>';
}
//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$problem = FALSE;
		if($_POST['choice'] == 'Yes') {
			if (!$problem) {
				$lname = $_SESSION['last_name'];
				$fname = $_SESSION['first_name'];
				$type  = $_SESSION['user_type'];
				$query = "DELETE FROM customer_info_table WHERE customer_id = $customer_id LIMIT 1";
				$result = mysqli_query($dbc, $query);
				$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
						   VALUES('$audit_id','$lname','$fname','delete customer',NOW(),'$type')";
				$result2 = mysqli_query($dbc, $query2);	
				if(mysqli_affected_rows($dbc) == 1) {
					header('Location: registered_customers.php');
					exit();
				} else {
					print '<h1>The user could not be deleted due to a system error.
							We apologize for any inconvenience.</h1>';
							//Display the debugging message..
					print '<h1>There was error in line ' . mysqli_error($dbc) . '<br />Query: ' . $query . ' </h1>';
				}
			} 
		} else {
			header('Location: registered_customers.php');
			exit();
		}
} else {
	//Display the information..
	$query2 = "SELECT CONCAT(last_name , ' ', first_name) AS Name FROM customer WHERE customer_id = $customer_id LIMIT 1";
	$result2 = mysqli_query($dbc, $query2);
	$num = @mysqli_num_rows($result2);
	//Check if num rows is equals to 1..
	if($num == 1){
		$row = mysqli_fetch_array($result2, MYSQLI_NUM);
	?>
		<div class="col-md-3"></div>
		
			<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading" style="background-color: rgb(0,164,156);"><h3 style="color: rgb(255,255,255); font-weight:bold;">Delete Customer</h3></div>
							<div class="panel-body">
							    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							    	<h3 style="font-weight:bold; color:rgb(182,0,97);">
							    	&nbsp&nbspAre you sure you want to delete this account<span style="font-family:arial;">?</span></h3>
							    	<div class="col-md-4"></div><h4>Name: <?php print $row[0]; ?></h4>
									<div class="col-md-5"></div><input type="radio" name="choice" id="inputYes" value="Yes" /><span class="choice">Yes</span>
									<input type="radio" name="choice" id="inputNo" value="No" checked="checked"/><span class="choice">No</span>
									<button type="submit" class="btn btn-block" id="delete">Delete Account</button>
									<input type="hidden" name="customer_id" class="form-control" value="<?php print $customer_id; ?>"/>
								</form>
							</div>
					</div>
				</div>
<?php				
	} //End of if($num == 1)..
}		
//Include the footer of the webpage..
include('../templates/footer.html');
// Close the database connection..
mysqli_close($dbc); 
?>


















