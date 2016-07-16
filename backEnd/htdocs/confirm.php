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

$page_title = "Confirm reservation";
// Set the page title and include the HTML header..
include ('../templates/header.html');
//Include the SQL connection..
include('../connection/mysqli_connection.php');
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
//Set the admin id to Auto Increment..
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
//
if (isset($_GET['reservation_id']) && is_numeric($_GET['reservation_id'])) {
	$reservation_id = $_GET['reservation_id'];
} elseif (isset($_POST['reservation_id']) && is_numeric($_POST['reservation_id'])) {
	$reservation_id = $_POST['reservation_id'];
}
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$problem = FALSE;
	if (!empty($_POST['reservation_id']) && is_numeric($_POST['reservation_id'])) {
		$reservation_id = mysqli_real_escape_string($dbc, trim($_POST['reservation_id']));
		if($_POST['choice'] == 'Yes') {
			$lname = $_SESSION['last_name'];
			$fname = $_SESSION['first_name'];
			$type  = $_SESSION['user_type'];
			$query = "UPDATE reservation SET status = 'Approved' WHERE reservation_id = $reservation_id LIMIT 1";
			$result = mysqli_query($dbc, $query);
			$query2 = "INSERT INTO audit_trail(audit_id,last_name,first_name,action,action_date,type)
					   VALUES('$audit_id','$lname','$fname','confirm reservation',NOW(),'$type')";
			$result2 = mysqli_query($dbc, $query2);	
			if(mysqli_affected_rows($dbc) == 1) {
				$query = "SELECT customer_id FROM reservation WHERE reservation_id = '$reservation_id' LIMIT 1";
				$result = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				$customer_id = $row[0];
				$query2 = "SELECT cellphone_no FROM customer_info_table WHERE customer_id = '$customer_id' LIMIT 1";
				$result2 = mysqli_query($dbc, $query2);
				$row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
				$number = 0 . $row2[0];
				$message = "Your reservation has been approved Thank you for choosing Ohana Private Resort !";
		    	$apicode = "091057929804B4H8GHL"; // To get api code go to http://www.itexmo.com/developers_api_php.php. You will see how to get api code. Just read it.
		    	$result = itexmo($number, $message, $apicode);
				header('Location: reservation.php');
				exit();
			} else {
				header('Location: reservation.php');
				exit();
			}
		} else {
			header('Location: reservation.php');
			exit();
		}
	}
} else {
	$query2 = "SELECT last_name, first_name, middle_name FROM reservation WHERE reservation_id = '$reservation_id'";
	$result2 = mysqli_query($dbc, $query2);
	$num2 = @mysqli_num_rows($result2); 
	if ($num2 == 1) {
		$row = mysqli_fetch_array($result2, MYSQLI_NUM);
		$name = $row[0] . ", " . $row[1] . " " . $row[2];
?>
<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading" style="background-color: rgb(0,164,156);"><h3 style="color: rgb(255,255,255); font-weight:bold;">Confirm Reservation</h3></div>
				<div class="panel-body">
					<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<h3 style="font-weight:bold; color:rgb(182,0,97); font-size: 20px;">&nbsp&nbsp
							Are you sure that you want to confirm this reservation<span style="font-family:arial;">?</span></h3>
							<div class="col-md-3"></div><h4>Name:&nbsp<?php print $name; ?></h4>
							<div class="col-md-5"></div><input type="radio" name="choice" id="inputYes" value="Yes" /><span class="choice">Yes</span>
							<input type="radio" name="choice" id="inputNo" value="No" checked="checked"/><span class="choice">No</span>
							<button type="submit" class="btn btn-block" id="delete">Confirm reservation</button>
							<input type="hidden" name="reservation_id" class="form-control" value="<?php print $reservation_id; ?>"/>
					</form>
				</div>
		</div>
	</div>
<?php 
	}
}
//Include the footer of the webpage
include('../templates/footer.html');
?>