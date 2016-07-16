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

$page_title = "View customers";
// Set the page title and include the HTML header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Display a message to the user..

if (isset($_GET['reser_id']) && is_numeric($_GET['reser_id'])) {
	$reservation_id = $_GET['reser_id'];
} else if (isset($_POST['reser_id']) && is_numeric($_POST['reser_id'])) {
	$reservation_id = $_POST['reser_id'];
}

?>
<br /><br /><br /><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8" id="details">
					<div class="row" id="title2">
						<div class="col-md-5">
							<h4>RESERVATION DETAILS</h4>
						</div>
					</div>
					<?php 
						if ($reservation_id) {
							$query = "SELECT a.last_name, a.first_name, a.middle_name,
									   DATE_FORMAT(b.arrival_date,'%b.%e,%Y') AS Arrival_Date,
									   DATE_FORMAT(b.arrival_time,'%l:%i:%p') AS Arrival_Time,
									   DATE_FORMAT(b.departure_date,'%b.%e,%Y') AS Departure_Date,
									   DATE_FORMAT(b.departure_time,'%l:%i:%p') AS Departure_Time, b.no_of_persons,
									   b.days_of_rent, b.total_payment, b.status, b.reference_no,
									   b.down_payment FROM customer_info_table AS a
									   INNER JOIN customer_reservation_table AS b 
									   ON a.customer_id = b.customer_id WHERE b.reservation_id = '$reservation_id' ";
							$result = mysqli_query($dbc, $query);
							if ($result) {
								$row = mysqli_fetch_array($result, MYSQLI_NUM);
								if ($row[11] == 0) {
									$row[11] = 'None';
								}
								$customer_name = $row[0] . ", " . $row[1] . " ". $row[2];
								print '<div class="row">
										<div class="col-md-2"></div>
											<div class="col-md-3">
												
											</div>
											<div class="col-md-5">
												<h5><span class="labels">STATUS: </span>' . $row[10] .'</h5>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">NAME: </span>'.$customer_name.'</h5>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">NUMBER OF PERSONS: </span>' . $row[7] . " persons" .'</h5>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">ARRIVAL DATE: </span>'. $row[3] . '</h5>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">DAYS OF RENT: </span>' . $row[8] .'</h5>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">ARRIVAL TIME: </span>'. $row[4] . '</h5>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">TOTAL PAYMENT: </span>' . "₱ " . number_format($row[9]) .'</h5>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">DEPARTURE DATE: </span>'. $row[5] . '</h5>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">DOWN PAYMENT: </span>' . "₱ " . number_format($row[12]) .'</h5>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h5><span class="labels">DEPARTURE TIME: </span>'. $row[6] . '</h5>
											</div>
											<div class="col-md-1"></div>
										   <div class="col-md-5">
												<h5><span class="labels">REFERENCE NUMBER: </span>' . $row[11] .'</h5>
											</div>
									   </div><br /><br />';

							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
//Include the footer of the webpage..
include('../templates/footer.html');
?>