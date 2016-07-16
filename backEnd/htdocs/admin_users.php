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
//Set the title of the webpage..
$page_title = "Registered user";
//Include the header of the webpage..
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
	$q = "SELECT COUNT(user_id) FROM user_table";
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
				<option value="All">All</option>
				<option value="First Name">First Name</option>
				<option value="Last Name">Last Name</option>
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

<?php
if($_SERVER['REQUEST_METHOD']=="POST") {
	//Set the boolean to false..
	$problem = FALSE;
	if(!empty($_POST['searchs'])) {
		$search = htmlentities($_POST['searchs']);
	} else {
		$problem = TRUE;
		$query = mysqli_query($dbc,"SELECT * FROM user");
		$num = mysqli_num_rows($query);
		$r = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name,user_type, gender, cellphone_no, address, email_address, username FROM user LIMIT $start, $display");
		$num1 = @mysqli_num_rows($r);
		table($r,$num);
	}
	if(!$problem) {
	switch ($_POST['choice']) {
		case 'All':
		//Retrieve the users information and display it into the form..
		$result2 = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name, user_type, gender, cellphone_no, address, email_address, username FROM user WHERE CONCAT(last_name, ' ', first_name) LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
			break;
		case 'First Name':
		$result2 = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name, user_type, gender, cellphone_no, address, email_address, username FROM user WHERE first_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    		break;
    	case 'Last Name':
    	$result2 = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name, user_type, gender, cellphone_no, address, email_address, username FROM user WHERE last_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    		break;
		default:
		$result2 = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name, user_type, gender, cellphone_no, address, email_address, username FROM user LIMIT $start, $display");
		$num3 = @mysqli_num_rows($result2);
		table($result2,$num3);
		break;
	}
 }
} else {
	$query = mysqli_query($dbc,"SELECT * FROM user");
	$num = mysqli_num_rows($query);
	$r = mysqli_query($dbc,"SELECT user_id, CONCAT(last_name, ' ',first_name,' ',middle_name) AS Name, user_type, gender, cellphone_no, address, email_address, username FROM user LIMIT $start, $display");
	$num1 = @mysqli_num_rows($r);
	table($r,$num);
}					
//Close the database connection..	
mysqli_close($dbc); 

function table($rows,$nums) {
	print '<div class="col-md-12">';
	print '<div table-responsive">
				<h2>Registered Users</h2>';
		if($nums > 1) {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> records registered user..</p>';
		} else {
			print '<p class="para1">There are currently <span class="total">' . $nums . '</span> record registered user..</p>';
		}

		if ($_SESSION['user_type'] == "Administrator") {
				print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
				print		'<thead>';
				print			'<tr class="active" align="center">';
				print				'<td><b>Edit</b></td>';
				print				'<td><b>Delete</b></td>';
				print				'<td><b>Name</b></td>';
				print				'<td><b>User type</b></td>';
				print				'<td><b>Gender</b></td>';
				print				'<td><b>Cellphone Number</b></td>';
				print				'<td><b>Address</b></td>';
				print				'<td><b>Email Address</b></td>';
				print				'<td><b>Username</b></td>';
				print			'</tr>';
				print		'</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
				@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
				@$font = ($font == 'white' ? 'black' : 'white');
				@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
				print 	  '<tbody>';
				print	  	  '<tr bgcolor="' . $bg . '" style="color: white;">';
				print	   	       '<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_user.php?user_id=' . $row[0] .'">Edit</a></td>';
				print	   		   '<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_user.php?user_id=' . $row[0] .'">Delete</a></td>';
				print				'<td width="200">' . $row[1] .'</td>';
				print				'<td width="130">' . $row[2] .'</td>';
				print				'<td width="80">' . $row[3] .'</td>';
				print				'<td width="110">' . $row[4] .'</td>';
				print				'<td width="250">' . $row[5] .'</td>';
				print				'<td width="120">' . $row[6] .'</td>';
				print				'<td width="120">' . $row[7] .'</td>';
				print			'</tr>';
				print  	'</tbody>';
			}
		} else {
				print '<div class="scrollbar">';
				print 	'<table class="table table-bordered" style="font-size: 14px;">';
				print		'<thead>';
				print			'<tr class="active" align="center">';
				print				'<td><b>Name</b></td>';
				print				'<td><b>User type</b></td>';
				print				'<td><b>Gender</b></td>';
				print				'<td><b>Cellphone Number</b></td>';
				print				'<td><b>Address</b></td>';
				print				'<td><b>Email Address</b></td>';
				print				'<td><b>Username</b></td>';
				print			'</tr>';
				print		'</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
				@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
				@$font = ($font == 'white' ? 'black' : 'white');
				@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
				print '<tbody>';
				print	  '<tr bgcolor="' . $bg . '" style="color: white;">';
				print			'<td width="200">' . $row[1] .'</td>';
				print			'<td width="130">' . $row[2] .'</td>';
				print			'<td width="80">' . $row[3] .'</td>';
				print			'<td width="150" align="right">' . $row[4] .'</td>';
				print			'<td width="250">' . $row[5] .'</td>';
				print			'<td width="120">' . $row[6] .'</td>';
				print			'<td width="80">' . $row[7] .'</td>';
				print		'</tr>';
				print  '</tbody>';
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
			print '<li><a href="admin_users.php?s=' . ($start - $display) . '&p=' . $pages . '" ><i class="glyphicon glyphicon-backward"></i></a></li>';
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
			print '<li><a href="admin_users.php?s=' . ($start + $display) . '&p=' . ' '.$pages . '" ><i class="glyphicon glyphicon-forward"></i></a></li>';
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
//Include the footer of the webpage..
include('../templates/footer.html');
?>