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

$page_title = "Reservation history";
// Set the page title and include the HTML header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//Display a message to the user..
print "<div class=\"col-md-12\">";
print 		"<h3 id=\"header3\"><img src=\"../icon/user.png\" height=\"100px\" alt=\"user_icon\" />Welcome back {$_SESSION['user_type']}, {$_SESSION['last_name']} ". " "."{$_SESSION['first_name']} !</h3>";
print "</div>";
	   
$display = 10;

if(isset($GET['p']) && is_numeric($_GET['p'])){	
	$pages = $_GET['p'];
} else {
	$q = "SELECT COUNT(history_id) FROM customer_history_reservation_table";
	$r = mysqli_query($dbc,$q);
	$row = @mysqli_fetch_array($r,MYSQLI_NUM);
	$records = $row[0];
	if($records > $display){
		$pages = ceil($records/$display);
	} else {
		$pages = 1;
	}
}
if(isset($_GET['s']) && is_numeric($_GET['s'])){
	$start = $_GET['s'];
} else {
		$start = 0;
}
?>
<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<div class="col-md-7">
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<select name="choice" id="choice" class="form-control">
				<option value="">Select Category</option>
				<?php 
				$thisMonths = array('January','Febraury','March','April','May','June','July','August','September','October','November','December');
				foreach ($thisMonths as $key => $value) {
					print '<option value="'.$key.'">'.$value.'</option>';
				}
				?>
		 	</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="searchs" id="search" placeholder="Search for year" />
				<span class="input-group-addon" id="span"><button class="btn" id="btnSearch" name="search" type="submit"><i class="fa fa-search"></i></button></span>
			</div>
		</div>
	</div>
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="POST") {
	//Set the boolean to false..
	$problem = FALSE;
	if(!empty($_POST['searchs'])) {
		$search = htmlentities($_POST['searchs']);
	} else {
		$problem = TRUE;
		$query = mysqli_query($dbc,"SELECT * FROM history_reservation");
		$num = mysqli_num_rows($query);
		$r = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation LIMIT $start, $display");
		$num1 = @mysqli_num_rows($r);
		table($r,$num);
	}
	if(!$problem) {
	switch ($_POST['choice']) {
		case 0:
		//Retrieve the users information and display it into the form..
		$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-01%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
			break;
		case 1:
		$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-02%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    		break;
    	case 2:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-03%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 3:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-04%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 4:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-05%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 5:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-06%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 6:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-07%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 7:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-08%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 8:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-08%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 9:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-10%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 10:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-11%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

    	case 11:
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE arrival_date AND departure_date LIKE '%2015-12%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;

		default:
		$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation");
		$num3 = @mysqli_num_rows($result2);
		table($result2,$num3);
		break;
	}
 }
} else {
	$query = mysqli_query($dbc,"SELECT * FROM history_reservation");
	$num = mysqli_num_rows($query);
	$r = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
	Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
	total_payment, status, reference_no, down_payment, customer_id FROM history_reservation LIMIT $start, $display");
	$num1 = @mysqli_num_rows($r);
	table($r,$num);
}					


function table($rows, $nums) {
	print '<div class="col-md-12">';
	print '<div table-responsive">
				<h2>Reservation History</h2>';
		if($nums > 1) {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> records..</p>';
		} else {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> record..</p>';
		}

		if ($_SESSION['user_type'] == "Administrator") {
				print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
				print		'<thead>';
				print			'<tr class="active" align="center">';
				print				'<td><b>Delete history</b></td>';
				print				'<td><b>Reference number</b></td>';
				print				'<td><b>Name</b></td>';
				print				'<td><b>Arrival Date</b></td>';
				print				'<td><b>Arrival Time</b></td>';
				print				'<td><b>Departure Date</b></td>';
				print				'<td><b>Departure Time</b></td>';
				print			'</tr>';
				print		'</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
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
				//print	   		    '<td width="150"><a style="color: '. $ancolor .';" class="action" href="view_customer.php?reser_id=' . $row[1] .'" ><i class="fa fa-eye" style="color: #FFF"></i>&nbspView Details</a></td>';
				//print	   	        '<td width="100"><a style="color: '. $ancolor .';" class="action" href="archive.php?archive_id=' . $row[1] .'&customer_id='. $row[12].'"><i class="fa fa-download" style="color: #FFF"></i>&nbspArchive</a></td>';
				//print	   	        '<td width="50"><a style="color: '. $ancolor .';" class="action" href="confirm.php?reservation_id=' . $row[1] .'"><i class="fa fa-check-square-o" style="color: #FFF"></i>&nbspConfirm</a></td>';
				print	   		    '<td width="100"><a style="color: '. $ancolor .';" class="action" href="delete_history.php?history_id=' . $row[1] .'"><i class="fa fa-trash" style="color: #FFF"></i>&nbspDelete</a></td>';
				//print				'<td width="100">' . $row[9] .'</td>';
				print				'<td width="100" align="right">' . $row[10] .'</td>';
				print				'<td width="150">' . $row[0] .'</td>';
				print				'<td width="120" align="right">' . $arrival_date .'</td>';
				print				'<td width="120" align="right">' . $arrival_time .'</td>';
				print				'<td width="120" align="right">' . $departure_date .'</td>';
				print				'<td width="120" align="right">' . $departure_time .'</td>';
				/*print				'<td width="120">' . $row[6] .'</td>';
				print				'<td width="120">' . $row[7] .'</td>';
				print				'<td width="120">' . number_format($row[11],2) .'</td>';		
				print				'<td width="120">' . number_format($row[8],2) .'</td>';	*/
				print			'</tr>';
				print  	'</tbody>';
			}
		} else {
				print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
				print		'<thead>';
				print			'<tr class="active" align="center">';
				print				'<td><b>Delete history</b></td>';
				print				'<td><b>Reference number</b></td>';
				print				'<td><b>Name</b></td>';
				print				'<td><b>Arrival Date</b></td>';
				print				'<td><b>Arrival Time</b></td>';
				print				'<td><b>Departure Date</b></td>';
				print				'<td><b>Departure Time</b></td>';
				/*print				'<td><b>Number of persons</b></td>';
				print				'<td><b>Days of rent</b></td>';
				print				'<td><b>down_payment</b></td>';
				print				'<td><b>Total payment</b></td>';*/
				print			'</tr>';
				print		'</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
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
				//print	   		    '<td width="150"><a style="color: '. $ancolor .';" class="action" href="view_customer.php?reser_id=' . $row[1] .'" ><i class="fa fa-eye" style="color: #FFF"></i>&nbspView Details</a></td>';
				//print	   	        '<td width="100"><a style="color: '. $ancolor .';" class="action" href="archive.php?archive_id=' . $row[1] .'&customer_id='. $row[12].'"><i class="fa fa-download" style="color: #FFF"></i>&nbspArchive</a></td>';
				//print	   	        '<td width="50"><a style="color: '. $ancolor .';" class="action" href="confirm.php?reservation_id=' . $row[1] .'"><i class="fa fa-check-square-o" style="color: #FFF"></i>&nbspConfirm</a></td>';
				print	   		    '<td width="100"><a style="color: '. $ancolor .';" class="action" href="delete_history.php?history_id=' . $row[1] .'"><i class="fa fa-trash" style="color: #FFF"></i>&nbspDelete</a></td>';
				//print				'<td width="100">' . $row[9] .'</td>';
				print				'<td width="100" align="right">' . $row[10] .'</td>';
				print				'<td width="150">' . $row[0] .'</td>';
				print				'<td width="120" align="right">' . $arrival_date .'</td>';
				print				'<td width="120" align="right">' . $arrival_time .'</td>';
				print				'<td width="120" align="right">' . $departure_date .'</td>';
				print				'<td width="120" align="right">' . $departure_time .'</td>';
				/*print				'<td width="120">' . $row[6] .'</td>';
				print				'<td width="120">' . $row[7] .'</td>';
				print				'<td width="120">' . number_format($row[11],2) .'</td>';		
				print				'<td width="120">' . number_format($row[8],2) .'</td>';	*/
				print			'</tr>';
				print  	'</tbody>';
			}
		}
			print '</table>';
		print '</div>';
	print '</div>';
	print '</div>';
}
if($pages > 1) {	
	print '<div class="col-md-5">';
	print '</div>';	
	$current_page = ($start/$display) + 1;
	
	if($current_page != 1 ) {
			print '<div class="container">';
			print '<div class="row">';
			print '<div class="col-md-12">';
			print '<div class="col-md-5">';
			print '</div>';	
			print '<li><a href="history.php?s=' . ($start - $display) . '&p=' . $pages . '" ><i class="glyphicon glyphicon-backward"></i></a></li>';
			print '</div>';
			print '</div>';
			print '</div>';
	
	}
	if($current_page != $pages) {
			print '<div class="container">';
			print '<div class="row">';
			print '<div class="col-md-12">';
			print '<div class="col-md-5">';
			print '</div>';	
			print '<li><a href="history.php?s=' . ($start + $display) . '&p=' . ' '.$pages . '" ><i class="glyphicon glyphicon-forward"></i></a></li>';
			print '</div>';
			print '</div>';
			print '</div>';
	}
}
if($pages == 1 ) {
	print '<div class="container">';
	print '<div class="row">';
	print '<div class="col-md-12">';
	print '<div class="col-md-5">';
	print '</div>';	
	print '<p class="pages">Page  1  of   ' . $pages .'</p>';
	print '</div>';
	print '</div>';
	print '</div>';
} else {
	print '<div class="container">';
	print '<div class="row">';
	print '<div class="col-md-12">';
	print '<div class="col-md-5">';
	print '</div>';	
	print '<p class="pages">Page ' . $current_page . '  of   ' .$pages .'</p>';
	print '</div>';
	print '</div>';
	print '</div>';

}	
?>
<?php
//Include the footer of the webpage..
include('../templates/footer.html');
//Close the database connection..	
mysqli_close($dbc); 
?>