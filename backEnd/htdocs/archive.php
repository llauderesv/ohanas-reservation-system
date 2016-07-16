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
$page_title = "Archive reservation";
//Include the header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
///===============================================================================
//===============================================================================
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
//===============================================================================
//===============================================================================
if(isset($_GET['archive_id']) && is_numeric($_GET['archive_id'])) {
	$archive_id = $_GET['archive_id'];
} elseif (isset($_POST['archive_id']) && is_numeric($_POST['archive_id'])) {
	$archive_id = $_POST['archive_id'];
} else {
	print '<h3>The page has been access in error</h3>';
}
//===============================================================================
//===============================================================================
if(isset($_GET['customer_id']) && is_numeric($_GET['customer_id'])) {
	$customer_id = $_GET['customer_id'];
} elseif (isset($_POST['customer_id']) && is_numeric($_POST['customer_id'])) {
	$customer_id = $_POST['customer_id'];
} else {
	print '<h3>The page has been access in error</h3>';
}
//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($_POST['choice'] == 'Yes') {
			//===========================================================================================
			//===========================================================================================
			$query = "SELECT history_id FROM customer_history_reservation_table";
			$result = mysqli_query($dbc, $query);
			$num = mysqli_num_rows($result);
			if($num <= 0) {
				$history_id = 50001;
			} else {
				$query2 = "SELECT MAX(history_id) FROM customer_history_reservation_table";
				$result2 = mysqli_query($dbc, $query2);
				$row = mysqli_fetch_array($result2, MYSQLI_NUM);
				$history_id = $row[0] + 1;
			}
			$query3  = "SELECT arrival_date, arrival_time, departure_date, departure_time,
			            no_of_persons, days_of_rent, total_payment, status, reference_no,
			            down_payment FROM customer_reservation_table
			            WHERE reservation_id = '$archive_id' LIMIT 1";
			$result3 = mysqli_query($dbc, $query3);
			if ($result3) {
				$row = mysqli_fetch_array($result3, MYSQLI_NUM);
				$arrival_date =  $row[0];
				$arrival_time = $row[1];
				$departure_date = $row[2];
				$departure_time = $row[3];
				$no_of_persons = $row[4];
				$days_of_rent = $row[5];
				$total_payment = $row[6];
				$status = $row[7];
				$reference_no = $row[8];
				$down_payment = $row[9];
				$lname = $_SESSION['last_name'];
				$fname = $_SESSION['first_name'];
				$type  = $_SESSION['user_type'];
				//Make a query..
				$query4 = "INSERT INTO customer_history_reservation_table
				           (history_id, customer_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
				           total_payment, status, reference_no, down_payment)
						   VALUES
						   ('$history_id', '$customer_id', '$arrival_date', '$arrival_time', '$departure_date', '$departure_time',
						   	'$no_of_persons', '$days_of_rent', '$total_payment', '$status', '$reference_no', '$down_payment')";
				$result4 = mysqli_query($dbc, $query4);
				$query6 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
						   VALUES('$audit_id','$lname','$fname','archive reservation',NOW(),'$type')";
				$result6 = mysqli_query($dbc, $query6);	
				if ($result4) {
					$query5 = "DELETE FROM customer_reservation_table WHERE reservation_id = '$archive_id' LIMIT 1";
					$result5 = mysqli_query($dbc, $query5);
					if (mysqli_affected_rows($dbc) == 1) {
						header('Location: reservation.php');
						exit();
					} else {
						print '<h3>The reservation could not be archive due to a system error.
								We apologize for any inconvenience.</h3>';
						print '<h1>There was error in line ' . mysqli_error($dbc) . '<br />Query: ' . $query . ' </h1>';
					}
				}
			}
			//===========================================================================================
			//===========================================================================================
	} else {
		header('Location: reservation.php');
		exit();
	}
} else {
	//Display the information..
	$query2 = "SELECT last_name, first_name, middle_name FROM reservation WHERE reservation_id = '$archive_id' LIMIT 1";
	$result2 = mysqli_query($dbc, $query2);
	$num2 = @mysqli_num_rows($result2);
	//Check if num rows is equals to 1..
	if($num2 == 1){
		$row = mysqli_fetch_array($result2, MYSQLI_NUM);
		$name = $row[0] .  ", " . $row[1] . " " . $row[2];
	?>
		<div class="col-md-3"></div>
			<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading" style="background-color: rgb(0,164,156);">
							<h3 style="color: rgb(255,255,255); font-weight: 700;"><div class="col-md-3"></div>&nbspARCHIVE RESERVATION</h3></div>
							<div class="panel-body">
							    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							    	<h3 style="font-weight:bold; color:rgb(182,0,97);">
							    	&nbsp&nbsp&nbsp&nbspAre you sure you want to archive this record<span style="font-family:arial;">?</span></h3>
							    	<div class="col-md-3"></div><h4>Name: <?php print $name; ?></h4>
									<div class="col-md-5"></div><input type="radio" name="choice" id="inputYes" value="Yes" /><span class="choice">Yes</span>
									<input type="radio" name="choice" id="inputNo" value="No" checked="checked"/><span class="choice">No</span>
									<button type="submit" class="btn btn-block" id="delete" style="font-weight:700; font-family: Proxima Nova;">ARCHIVE RESERVATION</button>
									<input type="hidden" name="archive_id" class="form-control" value="<?php print $archive_id; ?>" />
									<input type="hidden" name="customer_id" class="form-control" value="<?php print $customer_id; ?>" />
								</form>
							</div>
					</div>
				</div>
<?php				
			} //End of if($num == 1)..
}		
//Close the database connection..
mysqli_close($dbc);
//Include the footer of the webpage..
include('../templates/footer.html');
?>


















