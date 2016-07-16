<?php
//Set the title of the webpage
$pagetitle = "About us"; 
//Start the session..
session_start();
//Include the header of the page
include('frontEnd/templates/header.html'); 
//Let me learn from my mistakes!
ini_set('display_errors',1);
//Show all possible problems!
error_reporting(E_ALL | E_STRICT);
?>

<div class="container" style="background-image: url('frontEnd/image/ocean.jpg'); background-size: 100% 100%; color: #FFF;">
	<div class="row">
		<div class="col-md-12">
			<h1 style="color: lightGreen; font-family:Proxima Nova;">About the resort</h1>
			<div class="col-md-12">
					<strong>Ohana Private Resort</strong>, a 2000 sq m -property started February 24, 2014 Owned by <strong>Enriquez Family</strong>, the place is strategically located at <strong>#319 Sitio Bitukang Manok  Cacarong Matanda, Pandi Bulacan</strong> which is accessible for residences in Luzon are. The resort has two (2) <strong>swimming pool</strong> (1 kiddie pool and 1 adult pool) which suits guests of different ages. It also offers a variety of amenities such as cottages, rooms and venue. It has two (2) <strong>nippa huts</strong>, one (1) <strong>videoke room</strong>, two <strong>air-conditioned room</strong> good for twelve (12) person per room, and one (1) <strong>condo type room</strong> good for six (6) person per room whice provide a great relaxation for friends and families.
					The resort also provide one (1) <strong>large venues ideal for team buildings</strong>, <strong>company meetings, seminars, and various occasions such as birthdays, wedding, baptismal</strong> etc.
					According to <strong>Mr. Edgardo Enriquez</strong>, the booking manager, and with whom the developers conducted the interview with, the resort currently uses manual-based system in doing reservations. All reservation information is manually written in the record book.
					Customers who want to make reservations must go to the actual location or have a conversation thru phone with the book manager.They need to get a reservation 1 month before the desired day. If the customer already book his/her reservation, they’re allowed to pay 30% down payment for the slot of their reservation. The customer have 2 options in terms of payment, it’s either they go the resort or pay thru bank(the book manager will give them the bank account number and the bank that they need to pay).If they want to cancel their reservation, they should inform the booking manager 1 week before the desired day so that the customer can get a refund otherwise, they will not get any refund anymore.
					The book manager stated that the resort has no means of promoting their service to potential customers. One aspect that might benefit from an interactive system is to have a website for public exposure. It can be used to entice people to visit and find out about the company and potentially open doors of opportunity for increased profit.
			</div>
		</div>
	</div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div><br /><br /><br /><br /><br />
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>