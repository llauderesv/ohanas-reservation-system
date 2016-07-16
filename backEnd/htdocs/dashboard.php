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

$page_title = "Dashboard";
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
?>
<br /><br /><br /><br /><br /><br /><br /><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3"  id="panel">
					<h3 class="title5"><img src="../icon/rocket.png" alt="rocket_icon" class="img">
					<?php 
						$query = "SELECT * FROM reservation WHERE status = 'Approved' ";
						$result = mysqli_query($dbc, $query);
						$num = @mysqli_num_rows($result);
						if ($num > 0 ) {
							print $num;
						} else {
							print '0';
						}
					?>
					<h3>
					<h4 class="title4">RESERVED CUSTOMERS</h4>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-3" id="panel">
					<h3 class="title5"><img src="../icon/customers1.png" alt="customers_icon" class="img">&nbsp&nbsp&nbsp
					<?php 
						$query = "SELECT * FROM user";
						$result = mysqli_query($dbc, $query);
						$num = @mysqli_num_rows($result);
						if ($num > 0 ) {
							print $num;
						} else {
							print '0';
						}
					?></h3>
					<h4 class="title4">REGISTERED USERS</h4>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-3" id="panel">
					<h3 class="title5"><img src="../icon/message.png" alt="message_icon" class="img">&nbsp&nbsp&nbsp
					<?php 
						$query = "SELECT * FROM reservation WHERE status = 'Pending'";
						$result = mysqli_query($dbc, $query);
						$num = @mysqli_num_rows($result);
						if ($num > 0 ) {
							print $num;
						} else {
							print '0';
						}
					?></h3>
					<h4 class="title4">PENDING RESERVED</h4>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
//Include the footer of the webpage..
include('../templates/footer.html');
?>