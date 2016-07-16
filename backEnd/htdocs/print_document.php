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
if (isset($_GET['print'])) {
	unset($_SESSION['january']);
	unset($_SESSION['febraury']);
	unset($_SESSION['march']);
	unset($_SESSION['april']);
	unset($_SESSION['may']);
	unset($_SESSION['june']);
	unset($_SESSION['july']);
	unset($_SESSION['august']);
	unset($_SESSION['september']);
	unset($_SESSION['october']);
	unset($_SESSION['november']);
	unset($_SESSION['december']);
	unset($_SESSION['net1']);
	unset($_SESSION['net2']);
	unset($_SESSION['net4']);
	unset($_SESSION['net5']);
	unset($_SESSION['net6']);
	unset($_SESSION['net7']);
	unset($_SESSION['net8']);
	unset($_SESSION['net9']);
	unset($_SESSION['net10']);
	unset($_SESSION['net11']);
	unset($_SESSION['net12']);
	header('Location: reports.php');
	exit();
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="col-md-2"></div>
				<div class="col-md-8" id="document">
					<h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOhana Private Resort
					</h4>
					<h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						&nbsp&nbsp&nbsp&nbsp&nbspMonthly Report For The Year 2015
					</h4>
					<table class="table">
						<thead>
							<tr>
								<td align="center">Month</td>
								<td align="center">Net Income</td>
								<td align="center">Number of Reservation</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>January</td>
								<td align="center"><?php print $_SESSION['net1'];?></td>
								<td align="center"><?php print $_SESSION['january'];?></td>
							</tr>	
							<tr>
								<td>Febraury</td>
								<td align="center"><?php print $_SESSION['net2'];?></td>
								<td align="center"><?php print $_SESSION['febraury'];?></td>
							</tr>
							<tr>
								<td>March</td>
								<td align="center"><?php print $_SESSION['net3'];?></td>
								<td align="center"><?php print $_SESSION['march'];?></td>
							</tr>
							<tr>
								<td>April</td>
								<td align="center"><?php print $_SESSION['net4'];?></td>
								<td align="center"><?php print $_SESSION['april'];?></td>
							</tr>
							<tr>
								<td>May</td>
								<td align="center"><?php print $_SESSION['net5'];?></td>
								<td align="center"><?php print $_SESSION['may'];?></td>
							</tr>
							<tr>
								<td>June</td>
								<td align="center"><?php print $_SESSION['net6'];?></td>
								<td  align="center"><?php print $_SESSION['june'];?></td>
							</tr>
							<tr>
								<td>July</td>
								<td align="center"><?php print $_SESSION['net7'];?></td>
								<td align="center"><?php print $_SESSION['july'];?></td>
							</tr>
							<tr>
								<td>August</td>
								<td align="center"><?php print $_SESSION['net8'];?></td>
								<td align="center"><?php print $_SESSION['august'];?></td>
							</tr>
							<tr>
								<td>September</td>
								<td align="center"><?php print $_SESSION['net9'];?></td>
								<td align="center"><?php print $_SESSION['september'];?></td>
							</tr>
							<tr>
								<td>October</td>
								<td align="center"><?php print $_SESSION['net10'];?></td>
								<td align="center"><?php print $_SESSION['october'];?></td>
							</tr>

							<tr>
								<td>November</td>
								<td align="center"><?php print $_SESSION['net11'];?></td>
								<td align="center"><?php print $_SESSION['november'];?></td>
							</tr>
							<tr>
								<td>December</td>
								<td align="center"><?php print $_SESSION['net12'];?></td>
								<td align="center"><?php print $_SESSION['december'];?></td>
							</tr>
						</tbody>
					</table>
					<h4><img src="../icon/print.png" alt="print" style="height:50px;" onclick="printContent('document')"/></h4>
					<h4><a href="print_document.php?print=1">Back</a></h4>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  function printContent(el) {
  	var restorePage = document.body.innerHTML;
  	var thisPrintContent = document.getElementById(el).innerHTML;
  	document.body.innerHTML = thisPrintContent;
  	window.print();
  	document.body.innerHTML = restorePage;
  }
</script>
<?php 
//Include the footer of the webpage..
include('../templates/footer.html');
?>