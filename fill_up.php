<?php 
//Start the session..
session_start();
//Set the title of the webpage..
$pagetitle = "Fill up the requirements"; 
//Include the header of the page..
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//
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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['back_id'])) {
		$_SESSION['id_number'] = array();
		unset($_SESSION['total']);
		unset($_SESSION['no_rooms']);
		header('Location: choose_rooms.php');
		exit();
	}
}
//===================================================================================================
if (isset($_POST['fill'])) {
	$problem = FALSE;
	header('Location: payment_procedure.php');
	exit();
} else {
	header('Location: index.php');
	exit();
}
//===================================================================================================
if (isset($_POST['save_changes'])) {
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

	if (empty($_POST['reservation_id'])) {
		$problem = TRUE;
	} else {
		$reservation_id = $_POST['reservation_id'];
	}

	if (empty($_POST['down_payment'])) {
		$problem = TRUE;
	} else {
		$down_payment = $_POST['down_payment'];
	}

	if (empty($_POST['total'])) {
		$problem = TRUE;
	} else {
		$total = $_POST['total'];
	}
	//================================================================================================================	
	if (!$problem) {
	//================================================================================================================
		$lname = $_SESSION['last_name2'];
		$fname = $_SESSION['first_name2'];
		$type  = 'Customer';
		$query8 = "UPDATE customer_reservation_table SET arrival_date = '$arrival_date1', arrival_time = '$at',
				   departure_date = '$departure_date1', departure_time = '$dt', no_of_persons = '$no_of_persons',
				   days_of_rent = '$day', total_payment = '$total', down_payment = '$down_payment' WHERE reservation_id = '$reservation_id'";

		$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
				   VALUES('$audit_id','$lname','$fname','Edit reservation',NOW(),'$type')";

		$result2 = mysqli_query($dbc, $query2);
		$result8 = mysqli_query($dbc, $query8);
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
		$query9 = "UPDATE customer_room_paid_table SET no_of_rooms = '$no_rooms'
		WHERE reservation_id = '$reservation_id' ";
		$result9 = mysqli_query($dbc, $query9);
	}
		//Check if the query is work..
		if($result8 && $result9) {
			unset($_SESSION['arrival_date']);
			unset($_SESSION['departure_date']);
			unset($_SESSION['arrival_time']);
			unset($_SESSION['departure_time']);
			unset($_SESSION['days_of_rent']);
			unset($_SESSION['total']);
			unset($_SESSION['down_payment']);
			unset($_SESSION['no_rooms']);
			unset($_SESSION['reservation_id']);
			unset($_SESSION['days_of_rent']);
			unset($_SESSION['no_of_persons']);
			unset($_SESSION['reservation_price']);
			unset($_SESSION['id_number']);
			unset($_SESSION['last_name2']);
			unset($_SESSION['first_name2']);
			header('Location: choose_date.php');
			exit();
		} else {
			print '<h3><div class="col-md-2"></div>System error you could not be registered 
					at this time due to a system error. <br />
					We apologize for any inconvenience </h3>';
			print '<p><div class="col-md-2"></div>The error has been occured '. mysqli_error($dbc).'...</p>';
		}

	}
}
?>	
<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header9.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd/image/one.png" alt="img_one" height="70" class="number"/>
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
						<img src="frontEnd/image/three_active.png" alt="img_three" height="70" class="number"/>
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
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="container">
					<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" data-toggle="validator">
					<div class="col-md-5" id="details2">
					<div class="row">
						<div class="col-md-12" id="r_title2">
							<h3 id="header3">ROOM INFORMATION</h3>
						</div>

					</div>	
					<?php 
							//print $_SESSION['sese'];
							if (isset($_SESSION['id_number'])) {
								$room_id = $_SESSION['id_number'];
								$query = "SELECT room_id, room_name, price, room_type, image FROM paid_room_table WHERE room_id IN ($room_id)";                
								$result = mysqli_query($dbc, $query);
								$total_price = "";
								$roomid = "";
								$number_of_rooms = @mysqli_num_rows($result);
								
								print '<h4>';
								print		'<span class="labels">NUMBER OF ROOMS: </span>';
								print		''.$number_of_rooms .'';
								print '</h4>';
								
								$_SESSION['no_rooms'] = $number_of_rooms;

								while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {

									$_SESSION['room_id'] = $row[0];
								    $_SESSION['room_name'] = $row[1];
								    $_SESSION['price'] = $row[2];
								    $_SESSION['room_type'] = $row[3];
								    $_SESSION['room_type'] = $row[3];
								    $_SESSION['image'] = $row[4];

								    print '<div class="row">';
										print '<div class="col-md-6">';
										    print '<h4>';
										    	print	'<span class="labels">ROOM NAME: </span>' . $_SESSION['room_name'] .'';
										    print '</h4>';
										print '</div>';
								    print '<input type="hidden" name="name[]" value="'. $_SESSION['room_name'] .'">';
								  		print '<div class="col-md-6">';
										    print '<h4>';
										    	print 	'<span class="labels">ROOM TYPE: </span>' . $_SESSION['room_type'] . '';
										    print '</h4>';
									    print '</div>';
								    print '</div>';

								    print '<h4>';
								    print	'<span class="labels">RATES: </span>₱ ' . number_format($_SESSION['price']). '';
								    print '</h4>';

								    print '<h4>';
								    print	'<div class="col-md-12"><img src="frontEnd/uploads_rooms/' . $_SESSION['image'] . '" class="img-responsive" alt="image" ></div>';
								    print '</h4>';
								        $total_price = $row[2] + $total_price;
								    }
								    print '<div class="row">';
								    print '<div class="col-md-6">';
								    print '<h4>';
								    print 	'<span class="labels">TOTAL ROOM PRICE: </span>₱ ' . number_format($total_price) . '';
								    print '</h4>';
								    print '</div>';
								    print '</div>';
								 }
								 if (isset($total_price)) {
								    	$total_payment = $total_price + $_SESSION['reservation_price'];
									    $total = $total_payment;
									    $_SESSION['total'] = $total;
									    print '<input type="hidden" name="total" value="'.$total_payment.'">';
								 } else {
								    	$total_payment = $_SESSION['reservation_price'];
									    $total = $total_payment;
									    $_SESSION['total'] = $total;
									    print '<input type="hidden" name="total" value="' . $total_payment . '">';
									   
								  }
								?>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-6" id="details">
					<div class="row">
						<div class="col-md-12" id="title10">
							<h3 id="header3">RESERVATION DETAILS</h3>
						</div>
					</div>
						<div class="row">
							<div class="col-md-6">
								<h4><span class="labels">ARRIVAL DATE:&nbsp&nbsp</span>
								<?php 
									date_default_timezone_set('America/New_york'); 
									print $_SESSION['arrival_date'];
								?>
								</h4>
							</div>
							<div class="col-md-6">
								<h4><span class="labels">ARRIVAL TIME:&nbsp&nbsp</span>
								<?php 
									print $_SESSION['arrival_time'];
								?>
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h4><span class="labels">DEPARTURE DATE:&nbsp&nbsp</span>
								<?php
									print $_SESSION['departure_date'];
								?>
								</h4>
							</div>
							<div class="col-md-6">
								<h4><span class="labels">DEPARTURE TIME:&nbsp&nbsp</span>
								<?php
									print $_SESSION['departure_time'];
								?>
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h4><span class="labels">DAYS OF RENT:&nbsp&nbsp</span>
								<?php 
									switch ($_SESSION['days_of_rent']) {
										case 'day_time':
											$days =  'Day time';
											$_SESSION['days_of_rent'] = $days;
											print $_SESSION['days_of_rent'];
											break;
										case 'night_time':
											$days = 'Night time';
											$_SESSION['days_of_rent'] = $days;
											print $_SESSION['days_of_rent'];
											break;
										case 'days_rent':
											$days = 'Customer choice';
											$_SESSION['days_of_rent'] = $days;
											print $_SESSION['days_of_rent'];
											break;
										default:
											print $_SESSION['days_of_rent'];
											break;
									}
								?>
								</h4>
							</div>
							<div class="col-md-6">
								<h4><span class="labels">NUMBER OF GUESTS:&nbsp&nbsp</span>
								<?php
									print $_SESSION['no_of_persons'];
								?>  persons
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h4><span class="labels">RESERVATION PRICE:&nbsp&nbsp</span> ₱
								<?php
									print number_format($_SESSION['reservation_price']); 
								?>.00
								</h4>
							</div>
							<div class="col-md-6">
								<h4><span class="labels">TOTAL PAYMENT RESERVATION:&nbsp&nbsp&nbsp&nbsp
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span> ₱
								<?php
									if (isset($_SESSION['total'])) {
										print number_format($_SESSION['total']);
									}; 
								?>.00
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9">
								<h4><span class="labels">DOWN PAYMENT RESERVATION:&nbsp
									</span> ₱
								<?php
									if (isset($_SESSION['total'])) {
										$_SESSION['down_payment'] = $_SESSION['total'] * 0.30;
										print number_format($_SESSION['down_payment']);

									}; 
								?>.00
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 bg-danger" id="r_title3">
								<h3 id="header3">PERSONAL INFORMATION</h3>
							</div>
						</div>
						<div class="row">
								<?php
									if (isset($_SESSION['account_id'])) {
										$account_id = $_SESSION['account_id'];
											 
										$query2 =	"SELECT a.account_id, b.last_name, b.first_name, b.middle_name,
													b.cellphone_no,b.address
													FROM customer_account_table AS a INNER JOIN customer_info_table AS b 
													ON a.customer_id = b.customer_id WHERE a.account_id = '$account_id'";
										
										$result2 = mysqli_query($dbc, $query2);

										if (mysqli_num_rows($result2) == 1) {
											$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
											$name = $row2[1] . " " . $row2[2] . " " . $row2[3];
											print '<div class="col-md-6">';
											print '<h4><span class="labels">NAME: &nbsp</span> 
													';
											print $name;
											$_SESSION['lname'] = $row2[1];
											$_SESSION['fname'] = $row2[2];
											$_SESSION['mname'] = $row2[3];
											print '</h4>
												</div>';
											print '<div class="col-md-6">';
											print '<h4><span class="labels">CELLPHONE NUMBER: &nbsp</span> 
													';
											print 0 . $row2[4];
											$_SESSION['cellphone_number'] = $row2[4];
											print '</h4>
												</div>';
											
											print '</div>';	

											print '<div class="row">';
											print '<div class="col-md-6">';
											print '<h4><span class="labels">ADDRESS: &nbsp</span> 
													';
											print $row2[5];
											$_SESSION['address'] = $row2[5];
											print '</h4>
												</div>';
										}
									}
								?>
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" name="terms" data-error="You must agree in the rules and regulations" 
										value="<?php if (isset($_POST['terms'])) { print $_POST['terms']; }?>" required>&nbsp<span id="terms" style="color: #f78c73;">I agree in the rules and regulation of this resort.</span>	
										<a href="#" id="terms" data-toggle="modal" data-target="#modal-1">Preview</a>
										<div class="help-block with-errors" id="errors2"></div>
									</div>
								</div>	
						</div>
					</div>
					<div class="row" id="btns">
						<div class="col-md-2">
							<a class="btn btn-block" name="unset" href="fill_up.php?back_id=1" id="next1">BACK</a>
						</div>
						<div class="col-md-2">
							<?php 
							if (isset($_SESSION['reservation_id'])) {
								print '<form action="fill_up.php" method="post">';
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
										print '<input type="hidden" name="at" value="' . $at. '">';
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
										$_SESSION['down_payment'] = $total * 0.30;
										$down_payment = mysqli_real_escape_string($dbc, trim($_SESSION['down_payment']));
										print '<input type="hidden" name="down_payment" value="' . $down_payment . '">';
										print '<input type="hidden" name="total" value="' . $total . '">';
									}	
								//================================================================================================================
									if (isset($_SESSION['no_rooms'])) {
										$no_rooms = mysqli_real_escape_string($dbc, trim($_SESSION['no_rooms']));
										print '<input type="hidden" name="no_rooms" value="' . $no_rooms . '">';
									}
								//================================================================================================================
									if (isset($_SESSION['customer_id'])) {
										$customer_id = mysqli_real_escape_string($dbc, trim($_SESSION['customer_id']));
										print '<input type="hidden" name="customer_id" value="' . $customer_id . '">';
									}
								//================================================================================================================	
									if (isset($_SESSION['no_of_persons'])) {
										$no_of_persons = mysqli_real_escape_string($dbc, trim($_SESSION['no_of_persons']));
										print '<input type="hidden" name="no_of_persons" value="' . $no_of_persons . '">';
									} 
								//=================================================================================================================
									if (isset($_SESSION['total'])) {
										$total = mysqli_real_escape_string($dbc, trim($_SESSION['total']));
										print '<input type="hidden" name="total" value="' . $total . '">';
									}
								//=================================================================================================================
									if (isset($_SESSION['down_payment'])) {
										$down_payment = mysqli_real_escape_string($dbc, trim($_SESSION['down_payment']));
										print '<input type="hidden" name="down_payment" value="' . $down_payment . '">';
									}
								//=================================================================================================================	
									print '<input type="hidden" name="reservation_id" value="'. $_SESSION['reservation_id'] .'">';
									print '<button type="submit" name="save_changes" class="btn btn-block" id="next1">SAVE CHANGES</button><br />';
									print '</form>';
							} else {		
								print '<button type="submit" name="fill" class="btn btn-block" id="next1">NEXT</button><br />';
							}
							?>
						</div>
					</div>
			
		</div>
	</div>
</div>
<div class="container" id="load">
	<div class="modal fade" id="modal-1">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header" style="background-color: rgb(0,164,156);">
					<button style="color: rgb(0,0,0);" type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title" style="color: rgb(255,255,255); font-weight:bold;">Rules and regulations</h2>
				</div>
				<div class="modal-body">
					<h2 style="text-align:center;" id="warning">WARNING</h2>
					<p class="rules"><strong>1.</strong> No life guard on duty. All persons using pool do so at their own risk.</p>
					<p class="rules"><strong>2.</strong> Please shower before entering pool.</p>
					<p class="rules"><strong>3.</strong> No glass or alcoholic beverages in pool area.</p>
					<p class="rules"><strong>4.</strong> No pets allowed in pool area</p>
					<p class="rules"><strong>5.</strong> Proper swim attire required.</p>
					<p class="rules"><strong>6.</strong> No running or horseplay on pool deck.</p>
					<p class="rules"><strong>7.</strong> Children under 18 must be supervised by an adult.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
mysqli_close($dbc);// Close the database connection..
//Include the footer of the page..
include('frontEnd/templates/footer.html');
?>