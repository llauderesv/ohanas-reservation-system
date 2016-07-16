<?php 
//Set the title of the webpage
$pagetitle = "Print Document"; 
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
//
date_default_timezone_set('America/New_York');
if (isset($_GET['customer_id']) || is_numeric($_GET['customer_id'])) {
	$customer_id = $_GET['customer_id'];
} elseif (isset($_POST['customer_id']) || is_numeric($_POST['customer_id'])) {
	$customer_id = $_POST['customer_id'];
} else {
	print '<h3>The page has been access in error</h3>';
}

$query = " SELECT a.last_name, a.first_name, a.middle_name, b.reservation_id,
			DATE_FORMAT(b.arrival_date,'%b.%e,%Y'), DATE_FORMAT(b.departure_date,'%b.%e,%Y'),
			DATE_FORMAT(b.arrival_time,'%l:%i %p'), DATE_FORMAT(b.departure_time,'%l:%i %p'),
			b.no_of_persons, b.days_of_rent, b.total_payment, b.status,
			b.reference_no, b.down_payment FROM
			customer_info_table AS a 
			INNER JOIN customer_reservation_table AS b
			ON a.customer_id = b.customer_id WHERE a.customer_id = '$customer_id'
		 ";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result, MYSQLI_NUM);
$customer_name = $row[0] .", ".$row[1] ." ".$row[2];
$nowDate = date('m/d/Y');
print '<div class="container" id="document">
			<div class="row">
			<div class="col-md-2"></div>
				<div class="col-md-8" id="print_document">
					<div class="row">
						<div class="col-md-12">
							<h4><img src="frontEnd/image/logo.png" alt="logo" style="height:100px;" />
							319 Sitio Bitukang Manok Cacarong Matanda, Pandi Bulacan</h4>
						</div>
					</div>
					<div class="col-md-2"></div>
					<div class="row">
						<div class="col-md-5">
							<h4><strong>Reservation number:</strong> &nbsp' . $row[3] . '</h4>
							<h4><strong>Customer name:</strong> ' . $customer_name . '</h4>
						</div>
						<div class="col-md-4">
							<h4><strong>Date:</strong> &nbsp&nbsp' . $nowDate. '</h4>
						</div>
					</div>
					<div class="col-md-2"></div>
					<div class="row">
					<div class="col-md-1"></div>
						<div class="col-md-5">
							<h2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								Reservation Details</h2>
						</div>
					</div>
					<div class="col-md-2"></div>
					<div class="row">
						<div class="col-md-8">
							<h4><strong>Status:</strong> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp' . $row[11] . '</h4>
							<h4><strong>Days of rent:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[9] . '</h4>
							<h4><strong>Arrival date:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[4] . '</h4>
							<h4><strong>Departure date:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[5] . '</h4>
							<h4><strong>Arrival time:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[6] . '</h4>
							<h4><strong>Departure time:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[7] . '</h4>
							<h4><strong>Number of person:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[8] . '</h4>
							<h4><strong>Down payment:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							₱ ' . number_format($row[13]) . '</h4>
							<h4><strong>Total payment:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							₱ ' . number_format($row[10]) . '</h4>
							<h4><strong>Reference number:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							' . $row[12] . '</h4>
							<h4><img src="frontEnd//image/print.png" alt="print" style="height:50px;" onclick="printContent(\'document\')"/></h4>
						</div>
					</div>
				</div>
			</div>
		</div>';
?>
<script type="text/javascript">
  function printContent(el) {
  	var restorePage = document.body.innerHTML;
  	var thisPrintContent = document.getElementById(el).innerHTML;
  	document.body.innerHTML = thisPrintContent;
  	window.print();
  	document.body.innerHTML = restorePage;
  }
</script>
<?php 
//Include the footer of the webpage
include('frontEnd/templates/footer.html');
?>
