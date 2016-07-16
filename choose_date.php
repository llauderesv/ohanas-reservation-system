<?php 
//Set the title of the webpage
$pagetitle = "Resevation";
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
//===============================================================================================================
//===============================================================================================================
if (!isset($_SESSION['customer_id'])) {
	header('Location: index.php');
	exit();
}
if (isset($_GET['reservation_id'])) {
	$reservation_id = $_GET['reservation_id'];
	$_SESSION['reservation_id'] = $_GET['reservation_id'];
}
if (isset($_GET['reservation_del'])) {
	$reservation_del = $_GET['reservation_del'];
	$_SESSION['reservation_id'] = $_GET['reservation_del'];
}
if (isset($_POST['generate'])) {
	$problem = FALSE;
	
	if (!empty($_POST['reference2'])) {
		$reference2 = mysqli_real_escape_string($dbc, $_POST['reference2']);
	} else {
		$problem = TRUE;
	}

	if (!empty($_POST['ref_hidden'])) {
		$problem = TRUE;
	}

	if (!empty($_POST['reserve_id'])) {
		$problem = FALSE;
		$reserve_id = mysqli_real_escape_string($dbc, trim($_POST['reserve_id']));
	} else {
		$problem = TRUE;
	}
	
	if (!$problem) {
		$query10 = "UPDATE customer_reservation_table SET reference_no = $reference2
		WHERE reservation_id = '$reserve_id' LIMIT 1";
		$result10 = mysqli_query($dbc, $query10);
		if ($result10) {
			$_POST['reference2'] = array();//print '<script>alert("Please wait until your reservation has been Approved");</script>';
		}
	}
}
if(isset($_POST['save'])) {
	//===========================================================
	//===========================================================
	$problem = FALSE;
	date_default_timezone_set('America/New_York');
	$days_of_rent = $_POST['time'];
	$arrival_date = $_POST['arrival_date'];
	$departure_date = $_POST['departure_date'];
    $no_of_persons = $_POST['no_of_persons'];
    $reservation_price = $_POST['price'];
	$arrival_date2 = str_replace("/", "0", $arrival_date);
	$departure_date2 = str_replace("/", "0", $departure_date);
	$date = date('m/d/Y');
	$date2 = str_replace("/", "0", $date);
	//===========================================================
	//===========================================================
	if (!empty($arrival_date)) {
		if($date2 > $arrival_date2) {
			$problem = TRUE;
			//$error = "Your arrival date is invalid. ";
		}
	} else {
		$problem = TRUE;
		$error = "Enter your arrival date.</p>";
	}
	//===========================================================
	//===========================================================
	if (!empty($no_of_persons) && is_numeric($no_of_persons)) {
		$no_of_persons = trim($no_of_persons);
	} else {
		$problem = TRUE;
		//$error3 = "Enter a number only.";
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample2'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample3'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample4'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample13'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample5'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample8'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['arrival_time'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['departure_time'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if ($_POST['time'] == 'day_time') {
		if ($_POST['arrival_date'] != $_POST['departure_date']) {
			$problem = TRUE;
		}
	} elseif ($_POST['time'] == 'night_time') {
		if ($_POST['arrival_date'] == $_POST['departure_date']) {
			$problem = TRUE;		
		}
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['valid_persons'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['price'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if ($_POST['time'] == "day_time") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate, 'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate, 'Y-m-d');
			//===================================================
			//===================================================
			$q6 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND 
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r6 = mysqli_query($dbc, $q6);
			$row6 = mysqli_fetch_array($r6, MYSQLI_NUM);
			if ($row6[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//===================================================
			//===================================================
		}
	//===========================================================
	//===========================================================
	} elseif ($_POST['time'] == "night_time") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate,'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate,'Y-m-d');
			//=================================================================================================================
			//=================================================================================================================
			$q2 = " SELECT status 
					FROM customer_reservation_table 
					WHERE arrival_date = '$arrival_date1' OR 
					arrival_date = '$departure_date1' LIMIT 1
				  ";
			$r2 = mysqli_query($dbc, $q2);
			$row = mysqli_fetch_array($r2, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			$q3 = " SELECT status 
					FROM customer_reservation_table 
					WHERE departure_date = '$arrival_date1' OR 
					departure_date = '$departure_date1' LIMIT 1
				  ";
			$r3 = mysqli_query($dbc, $q3);
			$row3 = mysqli_fetch_array($r3, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved' || $row3[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			} 
			//=================================================================================================================
			//=================================================================================================================
			$q6 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r6 = mysqli_query($dbc, $q6);
			$row6 = mysqli_fetch_array($r6, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//=================================================================================================================
			//=================================================================================================================
			if ($row6[0] == 'Pending') {
				$q4 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE arrival_date = '$arrival_date1' OR
					 	arrival_date = '$departure_date1' LIMIT 1
					  ";
				//=================================================================================================================
				//=================================================================================================================
				$r4 = mysqli_query($dbc, $q4);
				$row4 = mysqli_fetch_array($r4, MYSQLI_NUM);
				$q5 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE departure_date = '$arrival_date1' OR 
						departure_date = '$departure_date1' LIMIT 1
					  ";
				//=================================================================================================================
				//=================================================================================================================
				$r5 = mysqli_query($dbc, $q5);
				$row5 = mysqli_fetch_array($r5, MYSQLI_NUM);
				if ($row4[0] == 'Approved' || $row5[0] == 'Approved') {
					$problem = TRUE;
					$_POST['arrival_date'] = "";
					$_POST['departure_date'] = "";
					$invalid = "Your date is already reserve please specify one.";
				}
			}

		}
	//===========================================================
	//===========================================================
	} elseif ($_POST['time'] == "days_rent") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate,'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate,'Y-m-d');
			//=================================================================================================================
			//=================================================================================================================
			$q4 = " SELECT status 
					FROM customer_reservation_table 
					WHERE arrival_date BETWEEN '$arrival_date1' AND 
				   '$departure_date1' LIMIT 1
				  ";
			$r4 = mysqli_query($dbc, $q4);
			$row4 = mysqli_fetch_array($r4, MYSQLI_NUM);	
			//=================================================================================================================
			//=================================================================================================================
			$q5 = " SELECT status 
					FROM customer_reservation_table 
					WHERE departure_date BETWEEN '$arrival_date1' AND
					'$departure_date1' LIMIT 1
				  ";
			$r5 = mysqli_query($dbc, $q5);
			$row5 = mysqli_fetch_array($r5, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row4[0] == 'Approved' || $row5[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//=================================================================================================================
			//=================================================================================================================
			$q2 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r2 = mysqli_query($dbc, $q2);
			$row = mysqli_fetch_array($r2, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			if ($row[0] == 'Pending') {
				$q2 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE arrival_date = '$arrival_date1' OR
						arrival_date = '$departure_date1' LIMIT 1
					  ";
				$row1 = mysqli_fetch_array($r2, MYSQLI_NUM);
				//=================================================================================================================
			  	//=================================================================================================================
				$q3 = " SELECT (SELECT reservation_id 
					    FROM customer_reservation_table 
						WHERE departure_date = '$arrival_date1' OR departure_date = '$departure_date1' LIMIT 1) AS reservation_id 
						FROM customer_reservation_table WHERE status = 'Approved'";
				$r3 = mysqli_query($dbc, $q3);
				$row2 = mysqli_fetch_array($r3, MYSQLI_NUM);
				//=================================================================================================================
			    //=================================================================================================================
				if ($row1[0] == 'Approved' || $row2[0] == 'Approved') {
					$problem = TRUE;
					$_POST['arrival_date'] = "";
					$_POST['departure_date'] = "";
					$invalid = "Your date is already reserve please specify one.";
				}
			}
		}
	}
	//===========================================================
	//===========================================================
    if (!$problem) {
    	$arrival_time = new DateTime($_POST['arrival_time']);
    	$departure_time = new DateTime($_POST['departure_time']);
        $_SESSION['arrival_date'] = $arrival_date;
        $_SESSION['arrival_time'] = $arrival_time->format('h:i A');
	    $_SESSION['departure_date'] = $departure_date;
        $_SESSION['departure_time'] = $departure_time->format('h:i A');
        $_SESSION['no_of_persons'] = $no_of_persons;
        $_SESSION['reservation_price'] = $reservation_price;
        $_SESSION['days_of_rent'] = $days_of_rent;
        header("Location: choose_rooms.php");
        exit();
    }
    //===========================================================
	//===========================================================
}		
#===============================================================
#===============================================================
if(isset($_POST['next'])) {
	//===========================================================
	//===========================================================
	$problem = FALSE;
	date_default_timezone_set('America/New_York');
	$days_of_rent = $_POST['time'];
	$arrival_date = $_POST['arrival_date'];
	$departure_date = $_POST['departure_date'];
    $no_of_persons = $_POST['no_of_persons'];
    $reservation_price = $_POST['price'];
	$arrival_date2 = str_replace("/", "0", $arrival_date);
	$departure_date2 = str_replace("/", "0", $departure_date);
	$date = date('m/d/Y');
	$date2 = str_replace("/", "0", $date);
	//===========================================================
	//===========================================================
	if (!empty($arrival_date)) {
		if($date2 > $arrival_date2) {
			$problem = TRUE;
			//$error = "Your arrival date is invalid. ";
		}
	} else {
		$problem = TRUE;
		$error = "Enter your arrival date.</p>";
	}
	//===========================================================
	//===========================================================
	if (!empty($no_of_persons) && is_numeric($no_of_persons)) {
		$no_of_persons = trim($no_of_persons);
	} else {
		$problem = TRUE;
		//$error3 = "Enter a number only.";
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample2'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample3'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample4'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample5'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample13'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['sample8'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['arrival_time'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['departure_time'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if ($_POST['time'] == 'day_time') {
		if ($_POST['arrival_date'] != $_POST['departure_date']) {
			$problem = TRUE;
		}
	} elseif ($_POST['time'] == 'night_time') {
		if ($_POST['arrival_date'] == $_POST['departure_date']) {
			$problem = TRUE;		
		}
	}
	//===========================================================
	//===========================================================
	if (!empty($_POST['valid_persons'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if (empty($_POST['price'])) {
		$problem = TRUE;
	}
	//===========================================================
	//===========================================================
	if ($_POST['time'] == "day_time") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate, 'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate, 'Y-m-d');
			//===================================================
			//===================================================
			$q6 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND 
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r6 = mysqli_query($dbc, $q6);
			$row6 = mysqli_fetch_array($r6, MYSQLI_NUM);
			if ($row6[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//===================================================
			//===================================================
		}
	//===========================================================
	//===========================================================
	} elseif ($_POST['time'] == "night_time") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate,'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate,'Y-m-d');
			//=================================================================================================================
			//=================================================================================================================
			$q2 = " SELECT status 
					FROM customer_reservation_table 
					WHERE arrival_date = '$arrival_date1' OR 
					arrival_date = '$departure_date1' LIMIT 1
				  ";
			$r2 = mysqli_query($dbc, $q2);
			$row = mysqli_fetch_array($r2, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			$q3 = " SELECT status 
					FROM customer_reservation_table 
					WHERE departure_date = '$arrival_date1' OR 
					departure_date = '$departure_date1' LIMIT 1
				  ";
			$r3 = mysqli_query($dbc, $q3);
			$row3 = mysqli_fetch_array($r3, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved' || $row3[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			} 
			//=================================================================================================================
			//=================================================================================================================
			$q6 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r6 = mysqli_query($dbc, $q6);
			$row6 = mysqli_fetch_array($r6, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//=================================================================================================================
			//=================================================================================================================
			if ($row6[0] == 'Pending') {
				$q4 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE arrival_date = '$arrival_date1' OR
					 	arrival_date = '$departure_date1' LIMIT 1
					  ";
				//=================================================================================================================
				//=================================================================================================================
				$r4 = mysqli_query($dbc, $q4);
				$row4 = mysqli_fetch_array($r4, MYSQLI_NUM);
				$q5 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE departure_date = '$arrival_date1' OR 
						departure_date = '$departure_date1' LIMIT 1
					  ";
				//=================================================================================================================
				//=================================================================================================================
				$r5 = mysqli_query($dbc, $q5);
				$row5 = mysqli_fetch_array($r5, MYSQLI_NUM);
				if ($row4[0] == 'Approved' || $row5[0] == 'Approved') {
					$problem = TRUE;
					$_POST['arrival_date'] = "";
					$_POST['departure_date'] = "";
					$invalid = "Your date is already reserve please specify one.";
				}
			}

		}
	//===========================================================
	//===========================================================
	} elseif ($_POST['time'] == "days_rent") {
		if (!empty($_POST['arrival_date']) && !empty($_POST['departure_date'])) {
			$arrival_date = mysqli_real_escape_string($dbc, trim($_POST['arrival_date']));	
			$adate = date_create($arrival_date);
			$arrival_date1 = date_format($adate,'Y-m-d');
			$departure_date = mysqli_real_escape_string($dbc, trim($_POST['departure_date']));	
			$ddate = date_create($departure_date);
			$departure_date1 = date_format($ddate,'Y-m-d');
			//=================================================================================================================
			//=================================================================================================================
			$q4 = " SELECT status 
					FROM customer_reservation_table 
					WHERE arrival_date BETWEEN '$arrival_date1' AND 
				   '$departure_date1' LIMIT 1
				  ";
			$r4 = mysqli_query($dbc, $q4);
			$row4 = mysqli_fetch_array($r4, MYSQLI_NUM);	
			//=================================================================================================================
			//=================================================================================================================
			$q5 = " SELECT status 
					FROM customer_reservation_table 
					WHERE departure_date BETWEEN '$arrival_date1' AND
					'$departure_date1' LIMIT 1
				  ";
			$r5 = mysqli_query($dbc, $q5);
			$row5 = mysqli_fetch_array($r5, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row4[0] == 'Approved' || $row5[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			//=================================================================================================================
			//=================================================================================================================
			$q2 = " SELECT status 
				    FROM customer_reservation_table 
				   	WHERE arrival_date <= '$arrival_date1' AND
				   	departure_date >= '$departure_date1' LIMIT 1
				  ";
			$r2 = mysqli_query($dbc, $q2);
			$row = mysqli_fetch_array($r2, MYSQLI_NUM);
			//=================================================================================================================
			//=================================================================================================================
			if ($row[0] == 'Approved') {
				$problem = TRUE;
				$_POST['arrival_date'] = "";
				$_POST['departure_date'] = "";
				$invalid = "Your date is already reserve please specify one.";
			}
			if ($row[0] == 'Pending') {
				$q2 = " SELECT status 
					    FROM customer_reservation_table 
						WHERE arrival_date = '$arrival_date1' OR
						arrival_date = '$departure_date1' LIMIT 1
					  ";
				$row1 = mysqli_fetch_array($r2, MYSQLI_NUM);
				//=================================================================================================================
			  	//=================================================================================================================
				$q3 = " SELECT (SELECT reservation_id 
					    FROM customer_reservation_table 
						WHERE departure_date = '$arrival_date1' OR departure_date = '$departure_date1' LIMIT 1) AS reservation_id 
						FROM customer_reservation_table WHERE status = 'Approved'";
				$r3 = mysqli_query($dbc, $q3);
				$row2 = mysqli_fetch_array($r3, MYSQLI_NUM);
				//=================================================================================================================
			    //=================================================================================================================
				if ($row1[0] == 'Approved' || $row2[0] == 'Approved') {
					$problem = TRUE;
					$_POST['arrival_date'] = "";
					$_POST['departure_date'] = "";
					$invalid = "Your date is already reserve please specify one.";
				}
			}
		}
	}
	//===========================================================
	//===========================================================
    if (!$problem) {
    	$arrival_time = new DateTime($_POST['arrival_time']);
    	$departure_time = new DateTime($_POST['departure_time']);
        $_SESSION['arrival_date'] = $arrival_date;
        $_SESSION['arrival_time'] = $arrival_time->format('h:i A');
	    $_SESSION['departure_date'] = $departure_date;
        $_SESSION['departure_time'] = $departure_time->format('h:i A');
        $_SESSION['no_of_persons'] = $no_of_persons;
        $_SESSION['reservation_price'] = $reservation_price;
        $_SESSION['days_of_rent'] = $days_of_rent;
        header("Location: choose_rooms.php");
        exit();
    }
    //===========================================================
	//===========================================================
}			
?>
<?php 
    $customer_id = $_SESSION['customer_id'];
	$query2 = "SELECT reservation_id 
					 FROM customer_reservation_table WHERE customer_id = '$customer_id' LIMIT 1";
	$result2 = mysqli_query($dbc, $query2);
	$num_rows = mysqli_num_rows($result2);
	if ($num_rows != 1 || isset($_GET['reservation_id'])) {
		print '
		<div class="row">
			<div class="col-md-12">
				<img src="frontEnd/image/page-header.jpg" alt="picture" class="img-responsive" id="steps" />
			</div>
		</div><br />';
	} else {
		print '
		<div class="row">
			<div class="col-md-12">
				<img src="frontEnd/image/page-header_1.jpg" alt="picture" class="img-responsive" id="steps" />
			</div>
		</div><br />';
	}
?>

<?php 
    $customer_id = $_SESSION['customer_id'];
	$query2 = "SELECT reservation_id 
					 FROM customer_reservation_table WHERE customer_id = '$customer_id' LIMIT 1";
	$result2 = mysqli_query($dbc, $query2);
	$num_rows = mysqli_num_rows($result2);
	if ($num_rows != 1 || isset($_GET['reservation_id'])) { 
       		print '
			<div class="container">
				<div class="row">
					<div class="col-md-12">
							<div class="col-md-1">
								<div class="form-group">
									<img src="frontEnd/image/one_active.png" alt="img_one" height="70" class="number"/>
								</div>
							</div> 
							<div class="col-md-2" id="step-1">
								<div class="form-group">
									<h3 class="text">Choose your date</h3>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<img src="frontEnd/image/two.png" alt="img_two" height="70" class="number"/>
								</div>
							</div>
							<div class="col-md-2" id="step-1">
								<div class="form-group">
									<h3 class="text">Choose your additional room</h3>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<img src="frontEnd/image/three.png" alt="img_three" height="70" class="number"/>
								</div>
							</div>
							<div class="col-md-2" id="step-1">
								<div class="form-group">
									<h3 class="text">reservation details</h3>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<img src="frontEnd/image/four.png" alt="imga_four" height="70" class="number"/>
								</div>
							</div>
							<div class="col-md-2" id="step-1">
								<div class="form-group">
									<h3 class="text">Payment procedure</h3>
								</div>
							</div>
					</div>
				</div>
			</div>';

	}

?>
<div class="container">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12"> 
				<div class="col-md-6">
				<?php
					$customer_id = $_SESSION['customer_id'];
					$query2 = "SELECT reservation_id 
							   FROM customer_reservation_table WHERE customer_id = '$customer_id' LIMIT 1";
					$result2 = mysqli_query($dbc, $query2);
					$num_rows = mysqli_num_rows($result2);
					if ($num_rows == 1) {
						if (!isset($_GET['reservation_id'])) {
							$query3 = "SELECT DATE_FORMAT(arrival_date,'%M %e, %Y') AS Arrival_Date,
									   DATE_FORMAT(arrival_time,'%l:%i %p') AS Arrival_Time,
									   DATE_FORMAT(departure_date,'%M %e, %Y') AS Departure_Date,
									   DATE_FORMAT(departure_time,'%l:%i %p') AS Departure_Time,
						               no_of_persons, days_of_rent, total_payment, status, reservation_id, reference_no, down_payment FROM 
						               customer_reservation_table WHERE customer_id = '$customer_id' LIMIT 1";
							$result3 = mysqli_query($dbc, $query3);

							$rows = mysqli_fetch_array($result3, MYSQLI_NUM);
								if ($rows[9] == 0) {
									$hide = '<input type="hidden" class="form-control" name="reserve_id" value="' . $rows[8] . '">';
									$ref  = '<br /><a id="ref" class="title6" href="" data-toggle="modal" data-target="#modal-2" style="color: lightBlue;">Click here to input reference number</a>';
									$reference = "None";
									//print '<button type="submit" class="btn btn-block" id="next1" name="generate">Generate</button>';
								} else {
									$hide = '<input type="hidden" class="form-control" name="reserve_id" value="' . $rows[8] . '">';
									$ref = $rows[9] . '<br /><a id="ref" class="title6" href="" data-toggle="modal" data-target="#modal-2" style="color: lightBlue;">Edit reference number</a>';
									$reference = "";
								}
							$query4 = "SELECT last_name, first_name, middle_name FROM customer_info_table WHERE customer_id = '$customer_id' LIMIT 1 ";		   		   
							$result = mysqli_query($dbc, $query4);
							$row = mysqli_fetch_array($result, MYSQLI_NUM);
							$name = $row[0] . ", " . $row[1] . " " . $row[2].".";

							$_SESSION['last_name2'] = $row[0];
							$_SESSION['first_name2'] = $row[1];

							print '<form action="choose_date.php" method="post">';
							print '<div class="row">';
							print '<div class="col-md-12">';
							$query5 = "SELECT customer_id FROM customer_history_reservation_table WHERE customer_id = '$customer_id'";
							$result5 = mysqli_query($dbc, $query5);
							$row = mysqli_fetch_array($result5, MYSQLI_NUM);
							if ($row[0] != "" ) {
								print '<div class="row">
											<div class="col-md-1"></div>
											<div class="col-md-8">
												<a class="title6" href="reservation_history.php">VIEW RESERVATION HISTORY</a>
											</div>
									   </div>';
							}
							print '<div class="row">
											<div class="col-md-1"></div>';
							print '			<div class="col-md-4">
												<a class="title6" id="edit" href="choose_date.php?reservation_id=' . $rows[8] . '">EDIT RESERVATION</a>
											</div>
											<div class="col-md-5">
												<a class="title6" id="cancel" href="cancel_reservation.php?reservation_del=' . $rows[8] . '">CANCEL RESERVATION</a>
											</div>';
							print '</div>';				
							print '<div id="servation">
										<div class="col-md-11" id="title3">';
							print '<div class="row" id="title9"><h2><div class="col-md-2"></div>&nbsp&nbsp&nbsp<img src="frontEnd//image/calendar.png" alt="calendar" height="25px" style="margin-top: -4px;" />
											&nbspYOUR RESERVATION</h2></div>
										<div class="row" style="margin-top: -20px;">
											<div class="col-md-12">
												<p id="address"></p>
												<h4 class="labels"><span class="title5">RESERVATION NUMBER:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ' . $rows[8] . '</h4>
												<h4 class="labels"><span class="title5">NAME:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp ' . $name . '</h4>
												<h4 class="labels"><span class="title5">STATUS:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp ' . $rows[7] . '</h4>
												<h4 class="labels"><span class="title5">ARRIVAL DATE:</span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$rows[0].'</h4>
												<h4 class="labels"><span class="title5">DEPARTURE DATE:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp'.$rows[2].'</h4>
												<h4 class="labels"><span class="title5">ARRIVAL TIME:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$rows[1].'</h4>
												<h4 class="labels"><span class="title5">DEPARTURE TIME:</span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp '.$rows[3].'</h4>
												<h4 class="labels"><span class="title5">DAYS OF RENT:</span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$rows[5].'</h4>
												<h4 class="labels"><span class="title5">NUMBER OF PERSONS:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$rows[4].'</h4>
												<h4 class="labels"><span class="title5">DOWN PAYMENT:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>₱</strong> '.number_format($rows[10]).'</h4>
												<h4 class="labels"><span class="title5">TOTAL PAYMENT:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp<strong>₱</strong> '.number_format($rows[6]).'</h4>
												<h4 class="labels"><span class="title5">REFERENCE NUMBER:</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' . $reference . $ref . '</h4>
											</div>
										</div>
										</div>
									</div>';
							print '</div>';
							print '</div>';
							print '<br />&nbsp<a id="printBtn" href="print_document.php?customer_id=' . $customer_id . '">PRINT THIS RESERVATION</a>';
							print '</form>';
						} else {
							$query5 = "SELECT customer_id FROM  customer_history_reservation_table WHERE customer_id = '$customer_id'";
							$result5 = mysqli_query($dbc, $query5);
							$row = mysqli_fetch_array($result5, MYSQLI_NUM);
							if ($row[0] != "" ) {
								print '<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-8">
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a class="title6" href="reservation_history.php">VIEW RESERVATION HISTORY</a>
											</div>
									   </div>';
							}
							print '<form action="choose_date.php" method="post" class="reser">
										<div class="col-md-12">
											<div class="row" id="reser_title2">
												<h2 id="reser_title" class="">RESERVATION DETAILS</h2>
												<h3 id="invalid" style="color:#f48a72;">'; if (isset($invalid)) { print $invalid; } print '</h3>
											</div>
										</div>
									<div class="col-md-3"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="forTime">CHOOSE YOUR RESERVATION</label>
												<select name="time" id="time" class="form-control" onblur="validateRent()" onclick="fadeInvalid()">
													<option value="">Select an option</option>
													<option value="day_time">Day time</option>
													<option value="night_time">Night time</option>
													<option value="days_rent">Choose days of rent</option>
												</select>
												&nbsp&nbsp&nbsp&nbsp&nbsp<span class="errors2" id="error5"></span>
											</div>
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="inputArrivalTime">ARRIVAL DATE</label>
												<input type="text" id="adate" name="arrival_date" class="form-control" onchange="dclear()" onblur="validateArrival()"/>
												<span class="errors2" id="error">'; if(isset($error)) print $error; print'</span>
												<span id="valid2" class="errors2"></span>
												<span id="valid3" class="errors2"></span>
												<span id="valid8" class="errors2"></span>
												<input type="hidden" id="sample8" class="form-control" name="sample8" />
												<input type="hidden" id="sample3" class="form-control" name="sample3" />
												<input type="hidden" id="sample2" class="form-control" name="sample2" />
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="inputDepartureTime">DEPARTURE DATE</label>
												<input type="text" id="ddate" name="departure_date" class="form-control" onchange="getTime()" onblur="getDate()"/>
												<span class="errors2" id="error1" name="span"><?php if(isset($error2)) print $error2; ?></span>
												<span class="errors2" id="error">'; if(isset($error4)) print $error4; print '</span>
												<span id="valid" class="errors2"></span>
												<span id="valid4" class="errors2"></span>
												<input type="hidden" id="sample2" class="form-control" name="sample2" />
												<input type="hidden" id="sample5" class="form-control" name="sample5" />
											</div>
											<input type="hidden" id="sample" class="form-control" name="sample" />
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												 <label for="inputArrivalTime" id="atime_label">ARRIVAL TIME</label>
					                             <input type="time" id="atime" onblur="thisTime()" class="form-control" name="arrival_time" value="<?php if(isset($arrival_time)) print $arrival_time; ?>" onblur="validateTime()" />
					                             <span class="errors2" id="error3"></span>
				                         	</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
											 	<label for="inputDepartureTime" id="dtime_label">DEPARTURE TIME</label>
				                              	<input type="time" id="dtime" onblur="thisTime()" class="form-control" name="departure_time" value="<?php if(isset($departure_time)) print $departure_time; ?>" onblur="validateTime2()" />
				                              	<span class="errors2" id="error4"></span>
		                         			</div>	
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="no_of_person" id="person2">NUMBER OF GUESTS</label>
												<input type="text" class="form-control" name="no_of_persons" id="person" value="30" maxlength="3" onblur="getDate()" onchange="validatePerson()"/>
												<span class="errors2" id="error2" name="valid_persons">'; if(isset($error3)) print $error3; print '</span>
			                       				<span class="errors2" id="error13" name="valid_persons2"></span>
			                       				<input type="hidden" id="sample4" class="form-control" name="sample4" />
			                       				<input type="hidden" id="sample13" class="form-control" name="sample13" />
			                       			</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="payment" id="price_label">PRICE:</label>
												<input type="text" class="form-control" id="price" name="price" value="0" readonly/>
			                        		</div>
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-6">
											<div class="form-group">
												<button class="btn btn-block" name="save" onclick="getTime()" id="next1" type="submit">NEXT</button>
											</div>	
										</div>
									</div>
								</form>';
						}
					} else {
						$query5 = "SELECT customer_id FROM  customer_history_reservation_table WHERE customer_id = '$customer_id'";
						$result5 = mysqli_query($dbc, $query5);
						$row = mysqli_fetch_array($result5, MYSQLI_NUM);
							if ($row[0] != "" ) {
								print '<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-8">
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a class="title6" href="reservation_history.php">VIEW RESERVATION HISTORY</a>
											</div>
									   </div>';
							}
						print '<form action="choose_date.php" method="post" class="reser">
										<div class="col-md-12">
											<div class="row" id="reser_title2">
												<h2 id="reser_title" class="">RESERVATION DETAILS</h2>
												<h3 id="invalid" style="color:#f48a72;">'; if (isset($invalid)) { print $invalid; } print '</h3>
											</div>
										</div>
									<div class="col-md-3"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="forTime">CHOOSE YOUR RESERVATION</label>
												<select name="time" id="time" class="form-control" onblur="validateRent()" onclick="fadeInvalid()">
													<option value="">Select an option</option>
													<option value="day_time">Day time</option>
													<option value="night_time">Night time</option>
													<option value="days_rent">Choose days of rent</option>
												</select>
												&nbsp&nbsp&nbsp&nbsp&nbsp<span class="errors2" id="error5"></span>
											</div>
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="inputArrivalTime">ARRIVAL DATE</label>
												<input type="text" id="adate" name="arrival_date" class="form-control" onchange="dclear()" onblur="validateArrival()"/>
												<span class="errors2" id="error">'; if(isset($error)) print $error; print'</span>
												<span id="valid2" class="errors2"></span>
												<span id="valid3" class="errors2"></span>
												<span id="valid8" class="errors2"></span>
												<input type="hidden" id="sample8" class="form-control" name="sample8" />
												<input type="hidden" id="sample3" class="form-control" name="sample3" />
												<input type="hidden" id="sample2" class="form-control" name="sample2" />
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="inputDepartureTime">DEPARTURE DATE</label>
												<input type="text" id="ddate" name="departure_date" class="form-control" onchange="getTime()" onblur="getDate()" onmouseout="thisTime()"/>
												<span class="errors2" id="error1" name="span"><?php if(isset($error2)) print $error2; ?></span>
												<span class="errors2" id="error">'; if(isset($error4)) print $error4; print '</span>
												<span id="valid" class="errors2"></span>
												<span id="valid4" class="errors2"></span>
												<input type="hidden" id="sample2" class="form-control" name="sample2" />
												<input type="hidden" id="sample5" class="form-control" name="sample5" />
											</div>
											<input type="hidden" id="sample" class="form-control" name="sample" />
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												 <label for="inputArrivalTime" id="atime_label">ARRIVAL TIME</label>
					                             <input type="time" id="atime" onblur="thisTime()" class="form-control" name="arrival_time" value="<?php if(isset($arrival_time)) print $arrival_time; ?>" onblur="validateTime()" />
					                             <span class="errors2" id="error3"></span>
				                         	</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
											 	<label for="inputDepartureTime" id="dtime_label">DEPARTURE TIME</label>
				                              	<input type="time" id="dtime" onblur="thisTime()" class="form-control" name="departure_time" value="<?php if(isset($departure_time)) print $departure_time; ?>" onblur="validateTime2()" />
				                              	<span class="errors2" id="error4"></span>
		                         			</div>
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="no_of_person" id="person2">NUMBER OF GUESTS</label>
												<input type="text" class="form-control" name="no_of_persons" id="person" value="30" maxlength="3" onblur="getDate()" onchange="validatePerson()"/>
												<span class="errors2" id="error2" name="valid_persons">'; if(isset($error3)) print $error3; print '</span>
			                       				<span class="errors2" id="error13" name="valid_persons2"></span>
			                       				<input type="hidden" id="sample4" class="form-control" name="sample4" />
			                       				<input type="hidden" id="sample13" class="form-control" name="sample13" />
			                       			</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="payment" id="price_label">PRICE:</label>
												<input type="text" class="form-control" id="price" name="price" value="0" readonly/>
			                        		</div>
										</div>
									</div>
									<div class="col-md-1"></div>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-6">
											<div class="form-group">
												<button class="btn btn-block" name="next" onclick="getTime()" id="next1" type="submit">NEXT</button>
											</div>	
										</div>
									</div>
								</form>';
					}
				?>
				</div>
						<div class="col-md-6" id="rates">
							<div class="row" id="title2"><h2 id="title4"><img src="frontEnd//image/rates.png" alt="calendar" height="25px" style="margin-top: -4px;"/> RATES</h2></div><br />
							<table class="table table-bordered">
								<thead>
									<tr>
										<td></td>
										<td>DAY TIME</td>
										<td>NIGHT TIME</td>
										<td>CUSTOMER CHOICE</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>TIME</td>
										<td>8 AM - 5 PM</td>
										<td>7 PM - 6 AM</td>
										<td style="font-size: 12px;">Minimum OF 24 hours - Maximum OF 3 days</td>
									</tr>
									<tr>
										<td>RATES</td>
										<td>₱ 6,000</td>
										<td>₱ 6,500</td>
										<td>₱ 12,000 per 24 hours</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="col-md-6" id="table">
							<div class="row" id="title2"><h2 id="title4"><img src="frontEnd//image/reserved.png" alt="calendar" height="25px" style="margin-top: -4px;"/> ALREADY RESERVED DATES</h2>
							</div><br />
								<table class="table table-bordered">
									<thead>
										<tr>
											<td>Days of rent</td>
											<td>Arrival Date</td>
											<td>Departure Date</td>
											<td>Arrival Time</td>
											<td>Departure Time</td>
										</tr>
									</thead>
						<?php

							$q = "SELECT 
									DATE_FORMAT(arrival_date,'%b.%e,%Y') AS Arrival_Date, 
									DATE_FORMAT(arrival_time,'%l:%i:%p') AS Arrival_Time,
									DATE_FORMAT(departure_date,'%b.%e,%Y') AS Departure_Date,  
									DATE_FORMAT(departure_time,'%l:%i:%p') AS Departure_Time,
									days_of_rent,customer_id
									FROM customer_reservation_table WHERE status = 'Approved' ORDER BY arrival_date DESC";
							$r = mysqli_query($dbc, $q);
							while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
								$font_color = ($row[5] == $_SESSION['customer_id'] ? '#f78c73' : 'white');
								print '<tbody>
										<tr>
											<td style="color:'.$font_color.'">' . $row[4] .'</td>
											<td style="color:'.$font_color.'">' . $row[0] .'</td>
											<td style="color:'.$font_color.'">' . $row[2] .'</td>
											<td style="color:'.$font_color.'">' . $row[1] .'</td>
											<td style="color:'.$font_color.'">' . $row[3] .'</td>
										</tr>
									</tbody>';
							}


						?>

									
								</table>
						</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="modal fade" id="modal-2">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header" style="background-color: rgb(0,164,156);">
					<button style="color: rgb(0,0,0);" type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title" style="color: rgb(255,255,255); font-weight:bold;">REFERENCE NUMBER</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h4 style="font-weight:bold; color: rgb(182,0,97);"><?php if(isset($error)) print $error;?></h4>
					</div>	
					<form action="choose_date.php" method="post" data-toggle="validator">
						<div class="form-group">	
							<input type="text" id="ref_no" name="reference2" class="form-control" maxlength="11" placeholder="Reference Number here" onblur="refno()" required/>
							<span class="errors2" id="ref_error"></span>
							<input type="hidden" id="ref_hidden" name="ref_hidden">
							<div class="help-block with-errors"></div>
							<?php print $hide;?>
						</div>
						<div class="form-group">
							<input type="submit" id="btnSign" name="generate" value="GENERATE" class="btn btn-block" />
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<br /><br /><br /><br /><br /><br /><br />
<?php
//Include the footer of the webpage..
include('frontEnd/templates/footer.html'); 
?>