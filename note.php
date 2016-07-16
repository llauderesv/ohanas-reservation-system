<?php 
//Set the title of the webpage..
$pagetitle = "Welcome to Ohana's Resort"; 
//Start the session..
session_start();
//Include the header of the page..
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
if (isset($_SESSION['account_id'])) {
	header('Location: choose_date.php');
	exit();
} else {
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<h1 id="pageer"><img src="frontEnd/image/error.png" alt="error" height="200">
				We are sorry, You must log in your account first</h1>
				<a href="index.php" id="go">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspGo back to home page</a>
			</div>
		</div>
	</div>
</div>
<?php 
}
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>

