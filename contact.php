<?php
//Set the title of the webpage
$pagetitle = "Contact"; 
//Start the session..
session_start();
//Include the header of the page
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
//===============================================================================
//===============================================================================
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
    return file_get_contents($url, false, $context);}
//===============================================================================
//===============================================================================
if($_SERVER['REQUEST_METHOD'] == "POST") {
   // send sms=
    $problem = FALSE;
    if (!empty($_POST['name'])) {
    	$name = trim(ucfirst($_POST['name']));
    } else {
    	$problem = TRUE;
    }
    //===========================================================================
    if (!empty($_POST['sample2'])) {
    	$problem = TRUE;
    } else {
    	$cellphone = trim($_POST['cellphone']);
    }
    //===========================================================================
    if (!empty($_POST['comment'])) {
    	$comment = $_POST['comment'];
    } else {
    	$problem = TRUE;
    }
    //===========================================================================
    //===========================================================================
    if (!$problem) {
    	$myNum   = '09105792980';
    	$number  = $myNum;
	    $message = $comment . " send by " . $name . " ". $cellphone;
	    $apicode = "091057929804B4H8GHL";
	    $result = itexmo($number,$message,$apicode);
	    header('Location: index.php');
	    exit();
    }
}
//===============================================================================
//===============================================================================
?>
<div class="container">
	<div class="row">
		<div class="col-md-12" >
			<h1 class="contact">Contact us</h1>
			<!--<iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d14983.280126706664!2d120.97500554005224!3d14.904693291048803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e0!4m3!3m2!1d14.900973899999999!2d120.9748149!4m3!3m2!1d14.9011605!2d120.97496509999999!5e0!3m2!1sen!2sph!4v1440831359801" width="1140" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
			-->
			<div class="col-md-12" id="map" style="height: 200px;">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h1 class="contact">Contact info</h1>
			<h3 style="font-family: Proxima Nova; font-weight: 500;">
				Ohana's Private Resort
				319 Sitio Bitukang Manok Cacarong Matanda, 
				Pandi Bulacan <span style="color: #ed797e;">Booking Manager Mr. Edgardo Enriquez</span>
				<i class="fa fa-phone fa-2x" id="phone">&nbsp&nbsp&nbsp&nbsp<span style="font-family: Proxima Nova;">09294335205</span></i>
			</h3>

			<h3><img src="frontEnd/image/facebook.png" alt="img-facebook"  height="80" /><strong>Edgardo@yahoo.com</strong></h3>
			<h3><img src="frontEnd/image/googleplus.png" alt="img-facebook"  height="80" /><strong>Enriquez@gmail.com</strong></h3>
			<h3><img src="frontEnd/image/twitter.png" alt="img-facebook"  height="80" /><strong>@Edgardo_enriquez.com</strong></h3>
		</div>
		<div class="col-md-8">
			<h1 class="contact">Contact form</h1>
			<form action="contact.php" method="post" data-toggle="validator">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" id="name" name="name" class="form-control" placeholder="Name: " data-error="Your name is empty" maxlength="30" required/>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" id="cp" name="cellphone" onblur="regCp()" class="form-control" placeholder="Cellphone no: " data-error="Your cellphone number is empty" maxlength="11" required/>
						<div class="help-block with-errors"></div>
						<input type="hidden" id="sample2" name="sample2"/>
						<span id="invalidCp" style="color: DarkRed;" name="invalidCp"></span>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<textarea  id="mesg"  name="comment"cols="30" rows="10" class="form-control" data-error="Your comment is empty" placeholder="Mesasge:" maxlength="100" required></textarea>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<button type="submit"  name="send" class="btn" id="send">Send message</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function regCp() {
		var regCp = /^09/;
		var thisCellphone = document.getElementById('cp');
		if (isNaN(thisCellphone.value) || thisCellphone.length == 11) {
			document.getElementById('invalidCp').innerHTML = "Invalid cellphone number";
			document.getElementById('sample2').value = "Invalid cellphone number";
		} else if (thisCellphone.value == "") {
			document.getElementById('invalidCp').innerHTML = "";
			document.getElementById('sample2').value = "";
		} else {
			if (!regCp.test(thisCellphone.value)) {
				document.getElementById('regCp').style.color = "#ffa8a8";
				document.getElementById('sample2').value = "Cellphone number must start in 09.";
			} else {
				document.getElementById('regCp').style.color = "#FFF";
				document.getElementById('sample2').value = "";
			}
		}
	}
</script>
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>