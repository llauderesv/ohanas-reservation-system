<?php 
//Set the title of the webpage..
$pagetitle = "Reservation History"; 
//Start the session..
session_start();
//Include the header of the page..
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
if (isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])) {
	$customer_id = $_SESSION['customer_id'];
} else {
	header('Location: index.php');
	exit();
	print '<h3>The page has been access in error</h3>';
}
?>
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header0.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div>
<?php 
$q = "SELECT total_payment, history_id, arrival_date, arrival_time,
      departure_date, departure_time, no_of_persons, days_of_rent,
	  total_payment, status, reference_no, down_payment,
	  customer_id FROM history_reservation WHERE customer_id = '$customer_id'";
$r = mysqli_query($dbc,$q);
print '<div class="col-md-12">';
print '<div table-responsive"><br /><br /><br />';
print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
				print		'<thead>';
				print			'<tr class="active" align="center">';
				print				'<td><b>View Details</b></td>';
				print				'<td><b>Reference number</b></td>';
				print				'<td><b>Total Payment</b></td>';
				print				'<td><b>Arrival Date</b></td>';
				print				'<td><b>Departure Date</b></td>';
				print				'<td><b>Arrival Time</b></td>';
				print				'<td><b>Departure Time</b></td>';
				print			'</tr>';
				print		'</thead>';
			while($row = @mysqli_fetch_array($r, MYSQLI_NUM)){
				@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
				@$font = ($font == 'white' ? 'black' : 'white');
				@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
				$adate = date_create($row[2]);
				$arrival_date = date_format($adate,'M. d, Y');
				$ddate = date_create($row[2]);
				$departure_date = date_format($ddate,'M. d, Y'); 
				$atime = new DateTime($row[3]);
				$arrival_time = $atime->format('h:i A');
				$dtime = new DateTime($row[5]);
				$departure_time = $dtime->format('h:i A');
				if ($row[10] == 0) {
					$row[10] = 'None';
				}
				print 	  '<tbody>';
				print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
				print 				'<td width="100"><a style="color: '. $ancolor .';" class="action" href="history_details.php?history_id=' . $row[1] .'" ><i class="fa fa-eye" style="color: #FFF"></i>&nbspView Details</a></td>';
				print				'<td width="100" align="right">' . $row[10] .'</td>';
				print				'<td width="150" align="right">₱ ' . number_format($row[0]) .'</td>';
				print				'<td width="120" align="right">' . $arrival_date .'</td>';
				print				'<td width="120" align="right">' . $departure_date .'</td>';
				print				'<td width="120" align="right">' . $arrival_time .'</td>';
				print				'<td width="120" align="right">' . $departure_time .'</td>';
				print			'</tr>';
				print  	'</tbody>';

			}
			print '</table>';
		print '</div>';
	print '</div>';
	print '</div>';
?>
<?php 
//Include the footer of the webpage..
include('frontEnd/templates/footer.html');
?>