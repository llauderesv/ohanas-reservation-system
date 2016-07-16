<?php
// Start the session
session_start();
// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {
	// Need the functions:
	require ('../templates/login_functions.inc.php');
	redirect_user();	
} else { // Cancel the session:
	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.
}
// Set the page title and include the HTML header:
include ('../templates/header.html');
// Redirect the user to the login page..
header('Location: login.php');
//Include the footer of the webpage..
include ('../templates/footer.html');
?>