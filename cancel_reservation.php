<?php
//Set the title of the webpage
$pagetitle = "Cancel reservation"; 
//Start the session..
session_start();
//Include the header of the page
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//======================================================================================================================
//======================================================================================================================
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
//======================================================================================================================
//======================================================================================================================
if(isset($_GET['reservation_del']) && is_numeric($_GET['reservation_del'])) {
	$reservation_del = $_GET['reservation_del'];
} elseif (isset($_POST['reservation_del']) && is_numeric($_POST['reservation_del'])) {
	$reservation_del = $_POST['reservation_del'];
} else {
	print '<h3>The page has been access in error</h3>';
}
//Check if the form is submitted..
if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	if($_POST['choice'] == 'Yes') {
		$lname = $_SESSION['last_name2'];
		$fname = $_SESSION['first_name2'];
		$type  = 'Customer';
		$query = "DELETE FROM customer_reservation_table WHERE reservation_id = $reservation_del LIMIT 1;";
		$result = mysqli_query($dbc, $query);
		$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
				   VALUES('$audit_id','$lname','$fname','Cancel reservation',NOW(),'$type')";
		$result2 = mysqli_query($dbc, $query2);	
		if(mysqli_affected_rows($dbc) == 1) {
			unset($_SESSION['last_name2']);
			unset($_SESSION['first_name2']);
			//print '<h3><div class="col-md-2"></div>The user has been successfully delete in the database</h3>';
			header('Location: index.php');
			exit();
		} else {
			print '<h3>The user could not be deleted due to a system error.
					We apologize for any inconvenience.</h3>';
					//Display the debugging message..
			print '<h1>There was error in line ' . mysqli_error($dbc) . '<br />Query: ' . $query . ' </h1>';
		}
	} else {
		header('Location: index.php');
		exit();
	}
} else {
?>
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header_5.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="panel panel-default" id="detail11">
						<div class="panel-heading" id="title11"><h3 style="color: #FFF;">CANCEL RESERVATION</h3></div>
							<div class="panel-body" id="panel">
							    <form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							    	<h3>
							    		<span style="font-weight:bold; color:rgb(182,0,97);">Cancellation Policy: </span>&nbsp<br />
							    	Cancellation and refund of the payment is only applicable for the reservation that was reserved 1 week before the event,
							    	otherwise cancellation will not be applied. You can get your refund 3 days(minimum) before the event if not,
							    	it will not be refunded anymore
							    	</h3>
							    	<h3 style="font-weight:bold; color:rgb(182,0,97);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							    	Are you sure that you want to cancel your reservation<span style="font-family:arial;">?</span></h3>
							    	
									<div class="col-md-4"></div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
									<input type="radio" name="choice" id="inputYes" value="Yes" />
									<span class="choice">&nbspYES</span>
									&nbsp<input type="radio" name="choice" id="inputNo" value="No" checked="checked"/>
									<span class="choice">&nbspNO</span>
									<button type="submit" class="btn btn-block" id="btn_cancel">CANCEL RESERVATION</button>
									<input type="hidden" name="reservation_del" class="form-control" value="<?php print $reservation_del; ?>"/>
								</form>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
}
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>