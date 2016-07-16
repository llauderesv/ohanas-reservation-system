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

$page_title = "Reservation reports";
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

		if (isset($_GET['print']) && is_numeric($_GET['print'])) {

		header('Location: print_document.php');
		exit();
			}

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
	<!--<div class="col-md-2">
		<div class="form-group">
			<select name="choice" id="choice" class="form-control">
				<option value="">Select Category</option>
				<option value="All">All</option>
				<option value="First Name">First Name</option>
				<option value="Last Name">Last Name</option>
		 	</select>
		</div>
	</div>-->
	<div class="col-md-2"></div>
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
		$query = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%2015-10%'
				";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		$year = 2015;
		//==================================================
		$query2 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-11%'
				  ";
		$result2 = mysqli_query($dbc, $query2);
		$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
		table($row[0],$row[1],$row2[0],$row2[1],$year);
	}
	if(!$problem) {
		//Retrieve the users information and display it into the form..
		$query = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-10%'
				 ";
		$year = $search;
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		//====================================================
		$query2 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-11%'
				 ";
		$result2 = mysqli_query($dbc, $query2);
		$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
		//=====================================================
		$query3 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-12%'
				 ";
		$result3 = mysqli_query($dbc, $query3);
		$row3 = mysqli_fetch_array($result3, MYSQLI_NUM);
		//=====================================================
		$query4 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-01%'
					";
		$result4 = mysqli_query($dbc, $query4);
		$row4 = mysqli_fetch_array($result4, MYSQLI_NUM);
		//=====================================================
		$query5 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-02%'
					";
		$result5 = mysqli_query($dbc, $query5);
		$row5 = mysqli_fetch_array($result5, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query6 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-03%'
					";
		$result6 = mysqli_query($dbc, $query6);
		$row6 = mysqli_fetch_array($result6, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query7 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-04%'
					";
		$result7 = mysqli_query($dbc, $query7);
		$row7 = mysqli_fetch_array($result7, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query8 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-05%'
					";
		$result8 = mysqli_query($dbc, $query8);
		$row8 = mysqli_fetch_array($result8, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query9 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-06%'
					";
		$result9 = mysqli_query($dbc, $query9);
		$row9 = mysqli_fetch_array($result9, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query10 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-07%'
					";
		$result10 = mysqli_query($dbc, $query10);
		$row10 = mysqli_fetch_array($result10, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query11 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-08%'
					";
		$result11 = mysqli_query($dbc, $query11);
		$row11 = mysqli_fetch_array($result11, MYSQLI_NUM);
		//=====================================================
		//=====================================================
		$query12 = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%$search-09%'
					";
		$result12 = mysqli_query($dbc, $query12);
		$row12 = mysqli_fetch_array($result12, MYSQLI_NUM);
		//=====================================================
		if($result) {
			table($row[0],$row[1],$row2[0],$row2[1],$row3[0],$row3[1],$row4[0],
			  $row4[1],$row5[0],$row5[1],$row6[0],$row6[1],$row7[0],$row7[1],
			  $row8[0],$row8[1],$row9[0],$row9[1],$row10[0],$row10[1],$row11[0],$row11[1],
			  $row12[0],$row12[1],$year);
    	}

		/*case 'First Name':
		$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE first_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    		break;
    	case 'Last Name':
    	$result2 = mysqli_query($dbc,"SELECT CONCAT(last_name, ' ',first_name,' ',middle_name) AS 
		Name, history_id, arrival_date, arrival_time, departure_date, departure_time, no_of_persons, days_of_rent,
		total_payment, status, reference_no, down_payment, customer_id FROM history_reservation WHERE last_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break; */

 }
} else {
	$query = " SELECT SUM(total_payment) AS net_income,
					COUNT(history_id) AS number_of_reseravation
					FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
					LIKE '%2015-10%'
				";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	$year = 2015;
	//==================================================
	$query2 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
				WHERE arrival_date AND departure_date
				LIKE '%2015-11%'
			  ";
	$result2 = mysqli_query($dbc, $query2);
	$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
	//=====================================================
	$query3 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-12%'
				";
	$result3 = mysqli_query($dbc, $query3);
	$row3 = mysqli_fetch_array($result3, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query4 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-01%'
				";
	$result4 = mysqli_query($dbc, $query4);
	$row4 = mysqli_fetch_array($result4, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query5 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-02%'
				";
	$result5 = mysqli_query($dbc, $query5);
	$row5 = mysqli_fetch_array($result5, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query6 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-03%'
				";
	$result6 = mysqli_query($dbc, $query6);
	$row6 = mysqli_fetch_array($result6, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query7 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-04%'
				";
	$result7 = mysqli_query($dbc, $query7);
	$row7 = mysqli_fetch_array($result7, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query8 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-05%'
				";
	$result8 = mysqli_query($dbc, $query8);
	$row8 = mysqli_fetch_array($result8, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query9 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-06%'
				";
	$result9 = mysqli_query($dbc, $query9);
	$row9 = mysqli_fetch_array($result9, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query10 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-07%'
				";
	$result10 = mysqli_query($dbc, $query10);
	$row10 = mysqli_fetch_array($result10, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query11 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-08%'
				";
	$result11 = mysqli_query($dbc, $query11);
	$row11 = mysqli_fetch_array($result11, MYSQLI_NUM);
	//=====================================================
	//=====================================================
	$query12 = " SELECT SUM(total_payment) AS net_income,
				COUNT(history_id) AS number_of_reseravation
				FROM customer_history_reservation_table
					WHERE arrival_date AND departure_date
				LIKE '%2015-09%'
				";
	$result12 = mysqli_query($dbc, $query12);
	$row12 = mysqli_fetch_array($result12, MYSQLI_NUM);
	//=====================================================
	table($row[0],$row[1],$row2[0],$row2[1],$row3[0],$row3[1],$row4[0],
		  $row4[1],$row5[0],$row5[1],$row6[0],$row6[1],$row7[0],$row7[1],
		  $row8[0],$row8[1],$row9[0],$row9[1],$row10[0],$row10[1],$row11[0],$row11[1],
		  $row12[0],$row12[1],$year);
}	

//=====================================================================================================================================
//=====================================================================================================================================			
function table($row1,$rows1,$row2,$rows2,$row3,$rows3,$row4,$rows4,$row5,$rows5,$row6,$rows6,$row7,$rows7,$row8,$rows8,$row9,$rows9,$row10,$rows10,$row11,$rows11,$row12,$rows12,$thisYear) {


	print '<div class="col-md-1"><p style="color:#f2f5f5">a</p></div>';
	print '<div class="col-md-10">';
	print '<div table-responsive">
				<h2>Monthly Report For The Year of '.$thisYear.'
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a class="btn" id="btnSign" href="reports.php?print=1001">PRINT REPORT</a></h2>';
	print '';
		/*if($nums > 1) {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> records registered customers..</p>';
		} else {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> record registered customer..</p>';
		} 
		*/
		
			print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
					print		'<thead>';
					print			'<tr class="active" align="center">';
					//print				'<td><b>Edit</b></td>';
					//print				'<td><b>Delete</b></td>';
					print				'<td><b>Month</b></td>';
					print				'<td><b>Net Income</b></td>';
					print				'<td><b>Number Of Reservation</b></td>';
					//print				'<td><b>Address</b></td>';
					//print				'<td><b>Email Address</b></td>';
					//print				'<td><b>Username</b></td>';
					print			'</tr>';
					print		'</thead>';
				//while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
					@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
					@$font = ($font == 'white' ? 'black' : 'white');
					@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
					print 	  '<tbody>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>JANUARY</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row4).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows4.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>FEBRAURY</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row5).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows5.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>MARCH</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row6).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows6.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>APRIL</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row7).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows7.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>MAY</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row8).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows8.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>JUNE</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row9).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows9.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>JULY</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row10).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows10.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>AUGUST</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row11).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows11.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>SEPTEMBER</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row12).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows12.'</strong></td>';
					print			'</tr>';

					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>OCTOBER</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row1).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows1.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>NOVEMBER</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row2).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows2.'</strong></td>';
					print			'</tr>';
					print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
					//print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?customer_id=' . $row[0] .'">Edit</a></td>';
					//print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_customer.php?customer_id=' . $row[0] .'">Delete</a></td>';
					//print				'<td width="200">' . $row[1] .'</td>';
					//print				'<td width="50">'  . $row[2] .'</td>';
					//print				'<td width="100">' . $row[3] .'</td>';
					print				'<td width="110" align="center"><strong>DECEMBER</strong></td>';
					print				'<td width="250" align="center"><strong>'.number_format($row3).'</strong></td>';
					print				'<td width="120" align="center"><strong>'.$rows3.'</strong></td>';
					print			'</tr>';

					print  	'</tbody>';
				//}
		
				print '</table>';
		print '</div>';
	print '</div>';
	print '</div>';
		$_SESSION['january'] = $rows4;
		$_SESSION['febraury'] = $rows5;
		$_SESSION['march'] = $rows6;
		$_SESSION['april'] = $rows7;
		$_SESSION['may'] = $rows8;
		$_SESSION['june'] = $rows9;
		$_SESSION['july'] = $rows10;
		$_SESSION['august'] = $rows11;
		$_SESSION['september'] = $rows12;
		$_SESSION['october'] = $rows1;
		$_SESSION['november'] = $rows2;
		$_SESSION['december'] = $rows3;
		$_SESSION['net1'] =  number_format($row4);
		$_SESSION['net2'] =  number_format($row5);
		$_SESSION['net3'] =  number_format($row6);
		$_SESSION['net4'] =  number_format($row7);
		$_SESSION['net5'] =  number_format($row8);
		$_SESSION['net6'] =  number_format($row9);
		$_SESSION['net7'] =  number_format($row10);
		$_SESSION['net8'] =  number_format($row11);
		$_SESSION['net9'] =  number_format($row12);
		$_SESSION['net10'] = number_format($row1);
		$_SESSION['net11'] = number_format($row2);
		$_SESSION['net12'] = number_format($row3);
	
}
//=====================================================================================================================================
//=====================================================================================================================================
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
			print '<li><a href="reports.php?s=' . ($start - $display) . '&p=' . $pages . '" ><i class="glyphicon glyphicon-backward"></i></a></li>';
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
			print '<li><a href="reports.php?s=' . ($start + $display) . '&p=' . ' '.$pages . '" ><i class="glyphicon glyphicon-forward"></i></a></li>';
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
//Include the footer..
include('../templates/footer.html');
//Close the database connection..	
mysqli_close($dbc); 
?>