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

$page_title = "Audit trail";
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
//Set the time of the system
date_default_timezone_set('America/New_York');	   
$display = 10;

if(isset($GET['p']) && is_numeric($_GET['p'])){	
	$pages = $_GET['p'];
} else {
	$q = "SELECT COUNT(audit_id) FROM audit_trail";
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
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
	$query = "TRUNCATE audit_trail";
	$result = mysqli_query($dbc, $query);
}
?>
<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<div class="col-md-7">
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<select name="choice" id="choice" class="form-control">
				<option value="">Select Category</option>
				<option value="Last Name">Last Name</option>
				<option value="First Name">First Name</option>
		 	</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="searchs" id="search" placeholder="Search for people" />
				<span class="input-group-addon" id="span"><button class="btn" id="btnSearch" name="search" type="submit"><i class="fa fa-search"></i></button></span>
			</div>	
		</div>
	</div>
</form>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-9"></div>
		<div class="col-md-3">
			<a href="audit_trail.php?delete=1001" id="btnSign" class="btn btn-block" name="delete_record">DELETE ALL RECORD</a>
		</div>
	</div>
</div>
<?php
if($_SERVER['REQUEST_METHOD']=="POST") {
	//Set the boolean to false..
	$problem = FALSE;
	if(!empty($_POST['searchs'])) {
		$search = htmlentities($_POST['searchs']);
	} else {
		$problem = TRUE;
		$query = mysqli_query($dbc,"SELECT * FROM audit_trail");
		$num = mysqli_num_rows($query);
		$r = mysqli_query($dbc,"SELECT type, CONCAT(last_name, ' ',first_name) AS Name, action, DATE_FORMAT(action_date,'%M %e,%Y ' ' %h:%i %p') FROM audit_trail LIMIT $start, $display");
		$num1 = @mysqli_num_rows($r);
		table($r,$num);
	}
	if(!$problem) {
	switch ($_POST['choice']) {
		case 'Last Name':
		//Retrieve the users information and display it into the form..
		$result2 = mysqli_query($dbc,"SELECT type, CONCAT(last_name, ' ',first_name) AS Name, action, DATE_FORMAT(action_date,'%M %e,%Y ' ' %h:%i %p') FROM audit_trail WHERE last_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
		break;
		case 'First Name':
		$result2 = mysqli_query($dbc,"SELECT type, CONCAT(last_name, ' ',first_name) AS Name, action, DATE_FORMAT(action_date,'%M %e,%Y ' ' %h:%i %p') FROM audit_trail WHERE first_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;
		default:
		$result2 = mysqli_query($dbc,"SELECT type, CONCAT(last_name, ' ',first_name) AS Name, action, DATE_FORMAT(action_date,'%M %e,%Y ' ' %h:%i %p') FROM audit_trail LIMIT $start, $display");
		$num3 = @mysqli_num_rows($result2);
		table($result2,$num3);
		break;
	}
 }
} else {
	$query = mysqli_query($dbc,"SELECT * FROM audit_trail");
	$num = mysqli_num_rows($query);
	$r = mysqli_query($dbc,"SELECT type, CONCAT(last_name, ' ',first_name) AS Name, action, DATE_FORMAT(action_date,'%M %e,%Y ' ' %h:%i %p') FROM audit_trail LIMIT $start, $display");
	$num1 = @mysqli_num_rows($r);
	table($r,$num);
}
function table($rows,$nums) {
	print '<div class="col-md-12">';
	print '<div table-responsive">
				<h2>Audit Trail</h2>';
				if($nums > 1) {
					print '<p class="para1">There are currently <span class="total">' . $nums . '</span> actions..</p>';
				} else {
					print '<p class="para1">There are currently <span class="total">' . $nums . '</span> actions..</p>';
				}
		print '<div class="scrollbar">';
		print'<table class="table table-bordered" style="font-size: 14px;">
					<thead>
						<tr class="active" align="center">
							<td><b>Type</b></td>
							<td><b>Name</b></td>
							<td><b>Action</b></td>
							<td><b>Action date</b></td>
						</tr>
					</thead>';
	while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
		@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
		@$font = ($font == 'white' ? 'black' : 'white');
		@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
			print '<tbody >
						<tr bgcolor="' . $bg . '" style="color: white;">
							<td width="100" align="center"><strong>' . $row[0] . '</strong></td>
							<td width="10" align="center"><strong>'  . $row[1] .'</strong></td>
							<td width="130" align="center"><strong>' . strtoupper($row[2]) .'</strong></td>
							<td width="250" align="center"><strong>' . $row[3] .'</strong></td>
						</tr>
					</tbody>';
	}
	print '</table>
		   </div>';
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
			print '<li><a href="audit_trail.php?s=' . ($start - $display) . '&p=' . $pages . '" ><i class="glyphicon glyphicon-backward"></i></a></li>';
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
			print '<li><a href="audit_trail.php?s=' . ($start + $display) . '&p=' . ' '.$pages . '" ><i class="glyphicon glyphicon-forward"></i></a></li>';
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
//Close the database connection..	
mysqli_close($dbc); 
//Include the footer of the webpage..
include('../templates/footer.html');
?>