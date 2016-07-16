<?php 
//Start the session..
session_start();
//Set the title of the webpage..
$pagetitle = "Choose your additional rooms"; 
//Include the header of the page..
include('frontEnd/templates/header.html'); 
//Include the SQL connection..
include('frontEnd/connection/mysqli_connection.php');
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
if (isset($_POST['rent'])) {
	if (isset($_POST['room_id'])) {
		$_SESSION['id'] = $_POST['room_id'];
		$room_id = implode(",", $_SESSION['id']);
		$_SESSION['id_number'] =  $room_id;
		header('Location: fill_up.php');
		exit();
	}
}
if (isset($_POST['skip'])) {
	unset($_SESSION['id_number']);
	header('Location: fill_up.php');
	exit();
}
?>

<div class="row">
	<div class="col-md-12">
		<img src="frontEnd/image/page-header2.jpg" alt="picture" class="img-responsive" id="steps" />
	</div>
</div><br />
<div class="container">
	<div class="row">
		<div class="col-md-12">
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd/image/one.png" alt="img_one" height="70" class="number"/>
					</div>
				</div> 
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Choose your date</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd/image/two_active.png" alt="img_two" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Choose your additional room</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd/image/three.png" alt="img_three" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">reservation details</h3>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<img src="frontEnd/image/four.png" alt="imga_four" height="70" class="number"/>
					</div>
				</div>
				<div class="col-md-2" id="step-1">
					<div class="form-group">
						<h3 class="text">Payment procedure</h3>
					</div>
				</div>
			</div>
	</div>
</div>
<div class="container">
	<div class="row" id="rooms">
		<div class="col-md-12">
		<?php 
		#=====================================================================================================
		//Section 1
		#=====================================================================================================
		$result = mysqli_query($dbc, "SELECT room_name, description, capacity, price, room_type, image, room_id FROM paid_room_table");
		while($row = @mysqli_fetch_array($result, MYSQLI_NUM)) {
			print '<div class="col-md-6">';
			print '		<table class="table">';
			print '		<thead>';
			print '			<tr>';
			print '				<td><img src="frontEnd/uploads_rooms/' . $row[5] . '" height ="250" width="450" class="img-responsive" alt="image" ></td>';
			print '			</tr>';
			print '		</thead>';
			print '		<tbody>';
			print '			<tr>';
			print '				<td><b>Room name:</b> ' . $row[0] . ' </td>';
			print '			</tr>';
			print '			<tr>';
			print '				<td><b>Capacity:</b> ' . $row[2] . '</td>';
			print '			</tr>';
			print '			<tr>';
			print '				<td><b>Price:</b>₱ ' . number_format($row[3]) . '</td>';
			print '			</tr>';
			print '			<tr>';
			print '				<td><b>Room type:</b> ' . $row[4] . '</td>';
			print '			</tr>';
			print '			<tr>';
			print '				<td><b>Description:</b> ' . $row[1] . '</td>';
			print '			</tr>';
			print '			<form action="choose_rooms.php" method="post">';
			print '			<tr>';
			print '				<td><input type="checkbox" name="room_id[]" value="' . $row[6] . '"> Rent this room</td>';
			print '			</tr>';
			print '		</tbody>';
			print '	</table>';
			print '	</div>';
		}
	?>
		</div>
	</div>
	<br />
		
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-2">
				<a class="btn btn-block" href="choose_date.php" id="next1" type="submit">BACK</a>
			</div>
			<div class="col-md-2">
				<input type="submit" class="btn" id="next1" value="Rent this room" name="rent">
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-block" id="next1" name="skip">SKIP</button>
			</div>
         </form>
		</div>
	
</div>
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>


