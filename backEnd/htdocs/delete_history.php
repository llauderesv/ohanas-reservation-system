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
$page_title = "Paid Rooms";
// Set the page title and include the HTML header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
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
if (isset($_GET['history_id']) && is_numeric($_GET['history_id'])) {
	$history_id = $_GET['history_id'];
} elseif (isset($_POST['history_id']) && is_numeric($_POST['history_id'])) {
	$history_id = $_POST['history_id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$problem = FALSE;
	if (!empty($_POST['history_id']) && is_numeric($_POST['history_id'])) {
		$history_id = mysqli_real_escape_string($dbc, trim($_POST['history_id']));
		if($_POST['choice'] == 'Yes') {
			$lname = $_SESSION['last_name'];
			$fname = $_SESSION['first_name'];
			$type  = $_SESSION['user_type'];
			$query = "DELETE FROM customer_history_reservation_table WHERE history_id = $history_id LIMIT 1";
			$result = mysqli_query($dbc, $query);
			$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
						   VALUES('$audit_id','$lname','$fname','delete history',NOW(),'$type')";
			$result2 = mysqli_query($dbc, $query2);	
			if(mysqli_affected_rows($dbc) == 1) {
				//print '<h3><div class="col-md-2"></div>The user has been successfully delete in the database</h3>';
				header('Location: history.php');
				exit();
			} else {
				print '<h3>The user could not be deleted due to a system error.
						We apologize for any inconvenience.</h3>';

						//Display the debugging message..
				print '<h3>There was error in line ' . mysqli_error($dbc) . '<br />Query: ' . $query . ' </h3>';
			}
		} else {
			header('Location: history.php');
			exit();
		}
	}
} else {
	$query2 = "SELECT last_name, first_name, middle_name FROM history_reservation WHERE history_id = '$history_id'";
	$result2 = mysqli_query($dbc, $query2);
	$num2 = @mysqli_num_rows($result2); 
	if ($num2 == 1) {
		$row = mysqli_fetch_array($result2, MYSQLI_NUM);
		$name = $row[0] . ", " . $row[1] . " " . $row[2];
?>
<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: rgb(0,164,156);"><h3 style="color: rgb(255,255,255); font-weight:bold;">Delete History</h3></div>
				<div class="panel-body">
					<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<h3 style="font-weight:bold; color:rgb(182,0,97); font-size: 23px;">&nbsp
							Are you sure you want to delete this history<span style="font-family:arial;">?</span></h3>
							<div class="col-md-3"></div><h4>Name:&nbsp<?php print $name; ?></h4>
							<div class="col-md-5"></div><input type="radio" name="choice" id="inputYes" value="Yes" /><span class="choice">Yes</span>
							<input type="radio" name="choice" id="inputNo" value="No" checked="checked"/><span class="choice">No</span>
							<button type="submit" class="btn btn-block" id="delete">DELETE HISTORY</button>
							<input type="hidden" name="history_id" class="form-control" value="<?php print $history_id; ?>"/>
					</form>
				</div>
		</div>
	</div>
<?php 
	}
}
//Include the footer of the webpage..
include('../templates/footer.html');
?>