<?php
#May 29, 2015..
#Connection of the database..
#Script 1.0..
#Vncnt Lldrs..

//Create constant variable..
define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','llauderesv321');
define('DB_NAME','ohana');

//Execute a statement to connect to database..
$dbc = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

//Check if database is successfully connect
if(!$dbc){
	print "You have an error occured " . mysqli_error($dbc);
} //End of if statement..

?>