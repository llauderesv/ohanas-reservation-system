<?php 
//Start the session..
session_start();
//Set the title of the webpage..
$pagetitle = "Payment procedure"; 
//Include the header of the page..
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//===================================================================================================
//===================================================================================================
function itexmo($number,$message,$apicode){
    $url = 'https://www.itexmo.com/php_api/api.php';
    $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
    $param = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($itexmo),
        ),
    );
    $context  = stream_context_create($param);
    return file_get_contents($url, false, $context);
}
//===================================================================================================
//===================================================================================================
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
//===================================================================================================
//===================================================================================================
$q5 = "SELECT reservation_id FROM customer_reservation_table";
$r5 = mysqli_query($dbc, $q5);
$n5 = mysqli_num_rows($r5);
if($n5 <= 0) {
	$reservation_id = 30001;
} else {
	$q6 = "SELECT MAX(reservation_id) FROM customer_reservation_table";
	$r6 = mysqli_query($dbc, $q6);
	$row6 = mysqli_fetch_array($r6, MYSQLI_NUM);
	$reservation_id = $row6[0] + 1;
}

//===================================================================================================
//===================================================================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$problem = FALSE;

	if (empty($_POST['arrival_date1'])) {
		$problem = TRUE;
	} else {
		$arrival_date1 = $_POST['arrival_date1'];
	}
	if (empty($_POST['departure_date1'])) {
		$problem = TRUE;
	} else {
		$departure_date1 = $_POST['departure_date1'];
	}
	if (empty($_POST['at'])) {
		$problem = TRUE;
	} else {
		$at = $_POST['at'];
	}
	if (empty($_POST['dt'])) {
		$problem = TRUE;
	} else {
		$dt = $_POST['dt'];
	}
	if (empty($_POST['days_of_rent'])) {
		$problem = TRUE;
	} else {
		$day = $_POST['days_of_rent'];
	}
	if (empty($_POST['total'])) {
		$problem = TRUE;
	} else {
		$total = $_POST['total'];
	}
	if (empty($_POST['down_payment'])) {
		$problem = TRUE;
	} else {
		$down_payment = $_POST['down_payment'];
	}
	if (empty($_POST['no_of_persons'])) {
		$problem = TRUE;
	} else {
		$no_of_persons = $_POST['no_of_persons'];
	}
	if (empty($_POST['customer_id'])) {
		$problem = TRUE;
	} else {
		$customer_id = $_POST['customer_id'];
	}
	//================================================================================================================	
	//================================================================================================================
	if (!$problem) {
		//==============================================================================================================
		//==============================================================================================================
		date_default_timezone_set('America/New_York');
		$query10 = "SELECT cellphone_no FROM customer_info_table WHERE customer_id = '$customer_id'";
		$result10 = mysqli_query($dbc, $query10);
		$rows = mysqli_fetch_array($result10, MYSQLI_NUM);
		$number = 0 . $rows[0];
		$message = "Pay your downpayment in the bank with account number 1883188204989 to approved your reservation";
    	$apicode = "091057929804B4H8GHL"; // To get api code go to http://www.itexmo.com/developers_api_php.php. You will see how to get api code. Just read it.
    	$result = itexmo($number, $message, $apicode);
		//============================================================================================================
		//==============================================================================================================
		$query8 = "INSERT INTO customer_reservation_table 
		(reservation_id, customer_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent, total_payment, status, down_payment) 
		VALUES
		('$reservation_id', '$customer_id', '$arrival_date1', '$at', '$departure_date1', '$dt', '$no_of_persons', '$day', '$total', 'Pending', '$down_payment')";
		$result8 = mysqli_query($dbc, $query8);

		$lname = $_SESSION['lname'];
		$fname = $_SESSION['fname'];
		$type  = 'Customer';
		$query2 = "INSERT INTO audit_trail(audit_id, last_name, first_name, action, action_date, type)
				   VALUES('$audit_id', '$lname', '$fname', 'RESERVE', NOW(), '$type')";
		$result2 = mysqli_query($dbc, $query2);	
		//============================================================================================================
		//============================================================================================================
		if (!empty($_POST['no_rooms'])) {
			$q7 = "SELECT room_id FROM customer_room_paid_table";
			$r7 = mysqli_query($dbc, $q7);
			$n7 = mysqli_num_rows($r7);
			if($n7 <= 0) {
				$room_id = 40001;
			} else {
				$q8 = "SELECT MAX(room_id) FROM customer_room_paid_table";
				$r8 = mysqli_query($dbc, $q8);
				$row8 = mysqli_fetch_array($r8, MYSQLI_NUM);
				$room_id = $row8[0] + 1;
			}
			$no_rooms = $_POST['no_rooms'];
			$query9 = "INSERT INTO customer_room_paid_table 
			(room_id, reservation_id, no_of_rooms) 
			VALUES
			('$room_id', '$reservation_id', '$no_rooms')";
			$result9 = mysqli_query($dbc, $query9);
		}
		//============================================================================================================
		//============================================================================================================
		//Check if the query is work..
		if($result8) {
			//$_SESSION = array();
			unset($_SESSION['arrival_date']);
			unset($_SESSION['departure_date']);
			unset($_SESSION['arrival_time']);
			unset($_SESSION['departure_time']);
			unset($_SESSION['days_of_rent']);
			unset($_SESSION['total']);
			unset($_SESSION['no_rooms']);
			unset($_SESSION['days_of_rent']);
			unset($_SESSION['no_of_persons']);
			unset($_SESSION['reservation_price']);
			unset($_SESSION['id_number']);
			header('Location: choose_date.php');
			exit();
		} else {			
			print '<h3><div class="col-md-2"></div>System error you could not be registered 
					at this time due to a system error. <br />
					We apologize for any inconvenience </h3>';
			print '<p><div class="col-md-2"></div>The error has been occured '. mysqli_error($dbc). $query2 . '...</p>';
		}

	}
}

?>
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd//image/page-header_4.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd//image/one.png" alt="img_one" height="70" class="number"/>
					</div>
				</div> 
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Choose your date</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd//image/two.png" alt="img_two" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Choose your additional room</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd//image/three.png" alt="img_three" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">reservation details</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd//image/four_active.png" alt="imga_four" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Payment procedure</h3>
					</div>
				</div>
			</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="col-md-1"></div>
				<div class="row">
					<div class="col-md-4" id="instruc">
						<div class="row">
							<div class="col-md-12" id="head">
								<h3 id="headers3"><div class="col-md-2"></div>
									&nbsp&nbsp&nbsp&nbsp
									Payment Instructions</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3><span class="instruc">Step 1.</span> &nbspYou must pay first the down payment 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										worth <strong>₱<?php if (isset($_SESSION['down_payment'])) { print number_format($_SESSION['down_payment']); }; ?></strong> &nbsp&nbspand it will be
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdeducted
										in the total amount of the 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspreservation.</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3><span class="instruc">Step 2.</span> &nbspYou can pay your reservation at any 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										bank nationwide.</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3><span class="instruc">Step 3.</span> &nbspPlace this account number 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<span class="acc_no">188 3 188 204 98 9</span> in your deposit slip.</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3><span class="instruc">Step 4.</span>&nbspAfter you pay at the bank log in your
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										account here then input your 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspreference number that was stated in
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspyour payment slip to confirm 
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspyour reservation.
									</h3>
							</div>	
						</div>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-5" id="instruc2">
						<div class="row">
							<div class="col-md-12" id="head2">
								<h3 id="headers3">Sample Payment Format</h3>
							</div>
						</div><br />
						<img src="frontEnd/image/payslip.gif" alt="payslip" class="img-responsive">
						<div class="row">
							<div class="col-md-1">
								<p style="color:#00a2d3">a</p>
							</div>
						</div>
					</div>
				</div>
			</div><br /><br /><br />
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-3">
					<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							<?php
								//================================================================================================================
									if (isset($_SESSION['arrival_date'])) {
										$arrival_date = mysqli_real_escape_string($dbc, trim($_SESSION['arrival_date']));	
										$adate = date_create($arrival_date);
										$arrival_date1 = date_format($adate,'Y/m/d');
										print '<input type="hidden" name="arrival_date1" value="' . $arrival_date1 . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['arrival_time'])) {
										$arrival_time = mysqli_real_escape_string($dbc, trim($_SESSION['arrival_time']));	
										$atime = date_create($arrival_time);
										$arrival_time1 = date_format($atime, 'H:i:s');
										$at = $arrival_time1;
										print '<input type="hidden" name="at" value="' . $at . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['departure_date'])) {
										$departure_date = mysqli_real_escape_string($dbc, trim($_SESSION['departure_date']));	
										$ddate = date_create($departure_date);
										$departure_date1 = date_format($ddate,'Y/m/d');
										print '<input type="hidden" name="departure_date1" value="' . $departure_date1 . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['departure_time'])) {
										$departure_time = mysqli_real_escape_string($dbc, trim($_SESSION['departure_time']));	
										$dtime = date_create($departure_time);
										$departure_time1 = date_format($dtime, 'H:i:s');
										$dt = $departure_time1;
										print '<input type="hidden" name="dt" value="' . $dt . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['days_of_rent'])) {
										$days_of_rent = mysqli_real_escape_string($dbc, trim($_SESSION['days_of_rent']));
										print '<input type="hidden" name="days_of_rent" value="' . $days_of_rent . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['total'])) {
										$total = mysqli_real_escape_string($dbc, trim($_SESSION['total']));
										print '<input type="hidden" name="total" value="' . $total . '">';
									}	
								//================================================================================================================
									if (isset($_SESSION['down_payment'])) {
										$down_payment = mysqli_real_escape_string($dbc, trim($_SESSION['down_payment']));
										print '<input type="hidden" name="down_payment" value="' . $down_payment . '">';
									}	
								//================================================================================================================
									if (isset($_SESSION['no_rooms'])) {
										$no_rooms = mysqli_real_escape_string($dbc, trim($_SESSION['no_rooms']));
										print '<input type="hidden" name="no_rooms" value="' . $no_rooms . '">';
									}
								//======================================================================================================
									if (isset($_SESSION['customer_id'])) {
										$customer_id = mysqli_real_escape_string($dbc, trim($_SESSION['customer_id']));
										print '<input type="hidden" name="customer_id" value="' . $customer_id . '">';
									}
								//================================================================================================================	
									if (isset($_SESSION['no_of_persons'])) {
										$no_of_persons = mysqli_real_escape_string($dbc, trim($_SESSION['no_of_persons']));
										print '<input type="hidden" name="no_of_persons" value="' . $no_of_persons . '">';
									} 
							?>			
						<button type="submit" name="button" class="btn btn-block" id="next1">Finish</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>
