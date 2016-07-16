<?php 
//Set the title of the webpage..
$pagetitle = "Welcome to Ohana's Private Resort"; 
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
//If server request method..
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$problem = FALSE;

	if (!empty($_POST['username'])) {
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	} else {
		$problem = TRUE;
	}

	if (!empty($_POST['pass'])) {
		$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	} else {
		$problem = TRUE;
	}

	if (!$problem) {
		$key = 'EYBISIDIEEFJFIHAHASDKAJSHDKUIY';
		$query = "SELECT account_id, customer_id FROM customer_account_table 
				  WHERE username = '$username' AND pass = AES_ENCRYPT('$pass','$key')";

		$result = mysqli_query($dbc, $query);

		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$_SESSION['account_id'] = $row[0];
			$_SESSION['customer_id'] = $row[1];
			header('Location: choose_date.php');
			exit();
		} else {
			$invalid =  "Your username or password is incorrect !";
		}
		
	} 
}
?>
<!--Create a image slider in the page-->
<div id="myCarousel" class="carousel  slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<img src="frontEnd/image/slides_1 copy.jpg" alt="image1" class="img-responsive">
		</div>
		<div class="item">
			<img src="frontEnd/image/slides_2 copy.jpg" alt="banner1" class="img-responsive">
		</div>
		<div class="item">
			<img src="frontEnd/image/slides_3 copy.jpg" alt="banner2" class="img-responsive">
		</div>
	</div>
	<a href="#myCarousel" class="carousel-control left" data-slide="prev" id="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>
	<a href="#myCarousel" class="carousel-control right" data-slide="next" id="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	</a>
	<?php 
	if (!isset($_SESSION['customer_id'])) {
		?>
		<div class="container" id="login-form">
				<div class="row" id="login-form2">
					<div class="col-md-12">
						<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" data-toggle="validator">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<div class="row" id="login_2">
									<div class="col-md-4"></div>
									<div class="row">
										<div class="col-md-12">
											<h4 id="login_name">CUSTOMER LOGIN</h4>
										</div>
									</div>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-10">
											<span id="invalid"><?php if (isset($invalid)) { print $invalid; }?></span>	
											<div class="form-group">
													<input type="text" name="username" class="form-control" maxlength="40" id="inputUser" placeholder="Username" data-error="Your username is empty" required />
												<div class="help-block with-errors"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-10">
											<div class="form-group">
												<input type="password" name="pass" class="form-control" maxlength="35" id="inputPass" placeholder="Password" data-error="Your password is empty" required /></p>
												<div class="help-block with-errors"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-10">
											<div class="form-group">
												<input type="submit" id="login_btn" name="submit" value="LOG IN" class="btn btn-block" />
											</div>
										</div>
									</div>	
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
	
<?php 
	}	
?>
</div><br />
<!--Display the important impormation in the resort in to the webpage-->
<div class="col-md-4">
	<h3 class="overview">RESORT OVERVIEW</h3>
		<ul id="info">
			<li>2 Air conditioned luxury rooms</li>
			<li>1 Condo type luxury room</li>
			<li>1 kiddie pool and 1 adult pool</li>
			<li>Interactive videoke room</li>
			<li>Glamorous party room</li>
			<a href="gallery.php" class="btn" id="readmore">Read more</a>
		</ul>
</div>
<div class="col-md-4">
	<h3 class="overview">OHANA RESORT</h3>
		<p id="info2">
			Ohana Private Resort, a 2000 square meter-property started February 24, 2014
			owned by Enriquez Family, the place is strategically located at
			<span style="font-weight: bold;">
				319 Sitio Bitukang Manok Cacarong Matanda, 
				Pandi Bulacan
			</span>......
		</p>
		<a href="about.php" class="btn" id="readmore2">Read more</a>			
</div>
<div class="col-md-4">
	<h3 class="overview">LOCATION</h3>
	<!--<iframe src="https://www.google.com/maps/embed?pb=!1m20!1m8!1m3!1d15422.323746033791!2d120.9750055!3d14.9046933!3m2!1i1024!2i768!4f13.1!4m9!3e0!4m3!3m2!1d14.900973899999999!2d120.9748149!4m3!3m2!1d14.9011605!2d120.97496509999999!5e0!3m2!1sen!2sph!4v1440833576993" width="355" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
-->
<div class="col-md-12" id="map" style="height: 200px;">
	
</div>

</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />	
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>