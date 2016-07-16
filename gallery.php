<?php
//Set the title of the webpage
$pagetitle = "Gallery"; 
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
?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h1 id="title12">
             PACKAGE FACILITIES AND PAID ROOMS</h1>
		</div>
	<div class="col-md-12" id="gallery">
	<div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
	<?php 
	$result = mysqli_query($dbc, "SELECT facilities_name, description, capacity, image FROM facilities_package_table");
	while($row = @mysqli_fetch_array($result, MYSQLI_NUM)) {
		print '
	  		
		    	<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
			      	<a href="frontEnd/uploads_facilities/' . $row[3] . '" itemprop="contentUrl" data-size="1024x1024">
			        	<img src="frontEnd/uploads_facilities/' . $row[3] . '" itemprop="thumbnail" alt="Image description" />
			     	</a>

		       		<figcaption itemprop="caption description">' . $row[1] . '</figcaption>
		       		<center><h4 class="cursor">' . $row[0] . '</h4></center>
		       </figure>
	 		';
	}
	$result2 = mysqli_query($dbc, "SELECT room_name, description, capacity, price, room_type, image FROM paid_room_table");
	while($row2 = @mysqli_fetch_array($result2, MYSQLI_NUM)) {
		print '
	  		
		    	<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
			      	<a href="frontEnd/uploads_facilities/' . $row2[5] . '" itemprop="contentUrl" data-size="1024x1024">
			        	<img src="frontEnd/uploads_facilities/' . $row2[5] . '" itemprop="thumbnail" alt="Image description" />
			     	</a>
		       		<figcaption itemprop="caption description">' . $row2[1] . '</figcaption>
		       		<center><h4 class="cursor">' . $row2[0] . '</h4></center>
		       </figure>
	 		';
	}
	?>
</div>
	
	<!-- Root element of PhotoSwipe. Must have class pswp. -->
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

	    <!-- Background of PhotoSwipe. 
	         It's a separate element as animating opacity is faster than rgba(). -->
	    <div class="pswp__bg"></div>

	    <!-- Slides wrapper with overflow:hidden. -->
	    <div class="pswp__scroll-wrap">
	        <!-- Container that holds slides. 
	            PhotoSwipe keeps only 3 of them in the DOM to save memory.
	            Don't modify these 3 pswp__item elements, data is added later on. -->
	        <div class="pswp__container">
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	        </div>

	        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
	        <div class="pswp__ui pswp__ui--hidden">

	            <div class="pswp__top-bar">

	                <!--  Controls are self-explanatory. Order can be changed. -->

	                <div class="pswp__counter"></div>

	                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

	                <button class="pswp__button pswp__button--share" title="Share"></button>

	                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

	                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

	                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
	                <!-- element will get class pswp__preloader--active when preloader is running -->
	                <div class="pswp__preloader">
	                    <div class="pswp__preloader__icn">
	                      <div class="pswp__preloader__cut">
	                        <div class="pswp__preloader__donut"></div>
	                      </div>
	                    </div>
	                </div>
	            </div>

	            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
	                <div class="pswp__share-tooltip"></div> 
	            </div>

	            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
	            </button>

	            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
	            </button>

	            <div class="pswp__caption">
	                <div class="pswp__caption__center"></div>
	            </div>

	        </div>

	    </div>

	</div>

	</div>
</div>
</div>
<br /><br /><br /><br />
<?php 
//Include the footer of the page..
include('frontEnd/templates/footer.html'); 
?>