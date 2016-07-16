<?php
//Start the session..
session_start();
//Set the title of the webpage
$pagetitle = "Reservation History";
// Set the page title and include the HTML header..
include ('frontEnd/templates/header.html');
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Display a message to the user..
if (isset($_GET['history_id']) && is_numeric($_GET['history_id'])) {
	$history_id = $_GET['history_id'];
} else if (isset($_POST['history_id']) && is_numeric($_POST['history_id'])) {
	$history_id = $_POST['history_id'];
}
?>
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header0.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div>
<br /><br /><br /><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8" id="detail11">
					<div class="row" id="title11">
						<div class="col-md-5">
							<h2>RESERVATION HISTORY</h2>
						</div>
					</div>
					<?php 
						if ($history_id) {
							$query =  "SELECT last_name, first_name, middle_name,
									   DATE_FORMAT(arrival_date,'%b.%e,%Y') AS Arrival_Date,
									   DATE_FORMAT(arrival_time,'%l:%i:%p') AS Arrival_Time,
									   DATE_FORMAT(departure_date,'%b.%e,%Y') AS Departure_Date,
									   DATE_FORMAT(departure_time,'%l:%i:%p') AS Departure_Time,no_of_persons,
									   days_of_rent, total_payment, reference_no,
									   down_payment FROM history_reservation WHERE history_id = '$history_id' ";
							$result = mysqli_query($dbc, $query);
							if ($result) {
								$row = mysqli_fetch_array($result, MYSQLI_NUM);
								if ($row[11] == 0) {
									$row[11] = 'None';
								}
								$customer_name = $row[0] . ", " . $row[1] . " ". $row[2];
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">NAME: </span>'.$customer_name.'</h4>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">NUMBER OF PERSONS: </span>' . $row[7] . " persons" .'</h4>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">ARRIVAL DATE: </span>'. $row[3] . '</h4>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">DAYS OF RENT: </span>' . $row[8] .'</h4>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">ARRIVAL TIME: </span>'. $row[4] . '</h4>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">TOTAL PAYMENT: </span>' . "₱ " . number_format($row[9]) .'</h4>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">DEPARTURE DATE: </span>'. $row[5] . '</h4>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">DOWN PAYMENT: </span>' . "₱ " . number_format($row[11]) .'</h4>
											</div>
									   </div>';
								print '<div class="row">
										<div class="col-md-1"></div>
											<div class="col-md-5">
												<h4><span class="labels">DEPARTURE TIME: </span>'. $row[6] . '</h4>
											</div>
											<div class="col-md-1"></div>
										   <div class="col-md-5">
												<h4><span class="labels">REFERENCE NUMBER: </span>' . $row[10] .'</h4>
											</div>
									   </div><br />';

							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
//Include the footer of the webpage
include('frontEnd/templates/footer.html');
?>