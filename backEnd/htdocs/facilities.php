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

$page_title = "Package Facilities";
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
//
if(isset($GET['p']) && is_numeric($_GET['p'])){	
	$pages = $_GET['p'];
} else {
	$q = "SELECT COUNT(facilities_id) FROM facilities_package_table";
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
				<option value="Facilities id">Facilities id</option>
				<option value="Facilities Name">Facilities Name</option>
		 	</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="searchs" id="search" placeholder="Search for facilities" />
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
		$query = mysqli_query($dbc,"SELECT * FROM facilities_package_table");
		$num = mysqli_num_rows($query);
		$r = mysqli_query($dbc,"SELECT facilities_id, facilities_name, description, capacity, image FROM facilities_package_table LIMIT $start, $display");
		$num1 = @mysqli_num_rows($r);
		table($r,$num);
	}
	if(!$problem) {
	switch ($_POST['choice']) {
		case 'Facilities id':
		//Retrieve the users information and display it into the form..
		$result2 = mysqli_query($dbc,"SELECT facilities_id, facilities_name, description, capacity, image FROM facilities_package_table WHERE facilities_id LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
		break;
		case 'Facilities Name':
		$result2 = mysqli_query($dbc,"SELECT facilities_id, facilities_name, description, capacity, image FROM facilities_package_table WHERE facilities_name LIKE '%$search%'");
		$num3 = @mysqli_num_rows($result2);
		if($num3 >= 1) {
		table($result2,$num3);
    	}
    	break;
		default:
		$result2 = mysqli_query($dbc,"SELECT facilities_id, facilities_name, description, capacity, image FROM facilities_package_table LIMIT $start, $display");
		$num3 = @mysqli_num_rows($result2);
		table($result2,$num3);
		break;
	}
 }
} else {
	$query = mysqli_query($dbc,"SELECT * FROM facilities_package_table");
	$num = mysqli_num_rows($query);
	$r = mysqli_query($dbc,"SELECT facilities_id, facilities_name, description, capacity, image FROM facilities_package_table LIMIT $start, $display");
	$num1 = @mysqli_num_rows($r);
	table($r,$num);
}					
//Close the database connection..	
mysqli_close($dbc); 

function table($rows,$nums) {
	print '<div class="col-md-12">';
	print '<div table-responsive">
				<h2>Package Facilities</h2>';
				if($nums > 1) {
					print '<p class="para1">There are currently <span class="total">' . $nums . '</span> package facilities..</p>';
				} else {
					print '<p class="para1">There are currently <span class="total">' . $nums . '</span> package facilities..</p>';
				}
		if ($_SESSION['user_type'] == "Administrator") {		
			print '<div class="scrollbar">';
			print'<table class="table table-bordered" style="font-size: 14px;">
						<thead>
							<tr class="active" align="center">
								<td><b>Edit</b></td>
								<td><b>Delete</b></td>
								<td><b>Facilities id</b></td>
								<td><b>Facilities Name</b></td>
								<td><b>Description</b></td>
								<td><b>Capacity</b></td>
								<td><b>Image</b></td>
							</tr>
						</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
				@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
				@$font = ($font == 'white' ? 'black' : 'white');
				@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
					print '<tbody >
								<tr bgcolor="' . $bg . '" style="color: white;">
									<td width="50"><a style="color: '. $ancolor .';" class="action" href="edit_facilities.php?facilities_id=' . $row[0] .'">Edit</a></td>
									<td width="50"><a style="color: '. $ancolor .';" class="action" href="delete_facilities.php?facilities_id=' . $row[0] .'">Delete</a></td>
									<td width="10" align="right">' . $row[0] .'</td>
									<td width="130">' . $row[1] .'</td>
									<td width="250">' . $row[2] .'</td>
									<td width="10" align="right">' . $row[3] .'</td>
									<td width="10"align="center" > <img src="../../frontEnd/uploads_facilities/' . $row[4] .'" height ="50" width="80" class="img-rounded" /></td>
								</tr>
							</tbody>';
				}
		} else {
			print '<div class="scrollbar">';
			print'<table class="table table-bordered" style="font-size: 14px;">
						<thead>
							<tr class="active" align="center">
								<td><b>Facilities id</b></td>
								<td><b>Facilities Name</b></td>
								<td><b>Description</b></td>
								<td><b>Capacity</b></td>
								<td><b>Image</b></td>
							</tr>
						</thead>';
			while($row = @mysqli_fetch_array($rows, MYSQLI_NUM)){
				@$bg = ($bg =='#00a99d' ? '#008783' : '#00a99d');
				@$font = ($font == 'white' ? 'black' : 'white');
				@$ancolor = ($ancolor == 'LightBlue' ? 'LightBlue' : 'LightBlue');
					print '<tbody >
								<tr bgcolor="' . $bg . '" style="color: white;">
									<td width="10" align="right">' . $row[0] .'</td>
									<td width="130">' . $row[1] .'</td>
									<td width="250">' . $row[2] .'</td>
									<td width="10" align="right">' . $row[3] .'</td>
									<td width="10"align="center" > <img src="../../frontEnd/uploads_facilities/' . $row[4] .'" height ="50" width="80" class="img-rounded" /></td>
								</tr>
							</tbody>';
			}
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
			print '<li><a href="facilities.php?s=' . ($start - $display) . '&p=' . $pages . '" ><i class="glyphicon glyphicon-backward"></i></a></li>';
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
			print '<li><a href="facilities.php?s=' . ($start + $display) . '&p=' . ' '.$pages . '" ><i class="glyphicon glyphicon-forward"></i></a></li>';
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
//Inlude the footer of the webpage..
include('../templates/footer.html');
?>