<?php
 	session_start();
?>
<?php include("includes/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/skitter.styles.css" media="all" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Game Hunter</title>
<script type="text/javascript" src="js/jquery-1.6.3.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.animate-colors-min.js"></script>
<script type="text/javascript" src="js/jquery.skitter.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.subnav.js"></script>
<script type="text/javascript">

	jQuery.noConflict();

	jQuery(document).ready(function() {
		
		jQuery('.login').hide();
		jQuery('.login_slide').click(function() {
			jQuery('.login').slideDown();
		});
		jQuery('.close_login').click(function() {
			jQuery('.login').slideUp();
		});
	
		//Skitter slideshow
		jQuery(".box_skitter").skitter({
			animation: "directionRight", 
 			dots: true, 
 			controls_position: "leftBottom", 
 			numbers_align: "center", 
 			hideTools: true, 
 			controls: true, 
 			progressbar: true, 
 			controls: true,
			interval: 5000
		});

	});//end ready()
	
	

</script>
</head>

<body>

<div class="login">
	<div class="login_centering">
    	<div class="login_left">
        	<h1>New Customers</h1>
            <p>By creating an account with our store, you will be able to move through the checkout process faster.</p>
            <p class="login_btn_shift"><a href="newaccount.php">Create Account</a></p>
        	<p class="close_login">[x]close window</p>
        </div><!-- end of login_left -->
        
        <div class="login_right">
        	<h1>Registered Customers</h1>
            <p>If you already have an account, please log in.</p>
            
            <form id="login" name="login" method="post" action="">
        		<div>
            		<label for="user_name">Username</label>
                	<input type="text"  name="user_name" id="user_name" autofocus /><br />
            	</div>
            
            	<div>
            		<label for="password">Password</label>
                	<input type="password" name="user_password" id="user_password" />
            	</div>
            
            	<div id="submit">
                	<input type="submit" name="login" id="login" value="login">
            	</div><a href="newpassword.php" class="forgot">Forgot your password?</a>
        
        	</form>
        </div><!-- end of login_right -->
    </div><!-- end of login_centerin -->
</div><!-- end of login -->

<div id="welcome_header">
	<div class="welcome_centering">
		<ul>
			<li>Hello fellow gamer! Please <span class="login_slide">Log in</span> or <span class="login_slide">Sign up</span>!</li>
			<li><img src="sources/cart.png" /><p class="welcome_shift"> 0 items</p></li>
		</ul>
    </div>
</div>


<div id="container">
	<div id="index_top">
        <div id="ghLogo">
            <a href="index.php"><img border="0" src="images/ghlogo.png"  /></a>
        </div>
        <?php include("includes/navbar.php"); ?>
      
	</div><!-- end of index top -->
    

    <div id="slideshow">
    	<div class="box_skitter">
		<ul>
    		<li><img src="sources/slide2.jpg" class="directionRight" /></li>
        	<li><img src="sources/slide3.jpg" class="directionRight" /></li>
        	<li><img src="sources/slide1.jpg" class="directionRight" /></li>
    	</ul>
        </div>
    </div>
      
     
    <p id="bigType">Searching For Games Just Got Easier</p>
    
    <div id="huntingField">
    	<p id="fieldTitle">The Hunting Field</p>
        <p id="fieldSubtitle">Specify all, some, or none, of these options and we'll find the perfect game for you.</p>
        <form id="huntingForm" action="" method="post">
        <ul>
        <li>
        <div id="huntingPlatform">
            <label>Platform</label>
            <select name="Platform" size="1">
                <option value="All">All</option>
                <option value="Xbox360">Xbox 360</option>
                <option value="PS3">PS3</option>
                <option value="Wii">Wii</option>
                <option value="3DS">3DS</option>
                <option value="PSVITA">PS Vita</option>
            </select>
        </div>
        </li>
        <li>
        <div id="huntingGenre">
            <label>Genre</label>
            <select name="Genre" size="1">
                <option value="All">All</option>
                <option value="Action">Action</option>
                <option value="Adventure">Adventure</option>
                <option value="Casual">Casual</option>
                <option value="Fighting">Fighting</option>
                <option value="Music&Party">Music & Party</option>
                <option value="Puzzle">Puzzle</option>
                <option value="Role-Playing">Role-Playing</option>
                <option value="Shooter">Shooter</option>
                <option value="Simulation">Simulation</option>
                <option value="Sports">Sports</option>
                <option value="Strategy">Strategy</option>
            </select>
        </div>
        </li>
        <li>
        <div id="huntingPlayers">
            <label>Players</label>
            <select name="Players" size="1">
                <option value="All">All</option>
                <option value="Single Player">Single Player</option>
                <option value="Two Player">Two Player</option>
                <option value="Multiplayer">Multiplayer</option>
            </select>
        </div>
        </li>
        <li>
        <div id="huntingESRB">
            <label>ESRB Rating</label>
            <select name="ESRB" size="1">
                <option value="All">All</option>
                <option value="Everyone">Everyone</option>
                <option value="Everyone10">Everyone 10+</option>
                <option value="Teen">Teen</option>
                <option value="Mature">Mature 17+</option>
            </select>
        </div>
        </li>
        <li>
        <div id="huntingPrice">
            <label>Price Range</label>
            <select name="Price" size="1">
                <option value="All">All</option>
                <option value="10under">$10 and Under</option>
                <option value="2030">$20 - $30</option>
                <option value="3040">$30 - $40</option>
                <option value="50up">$50 and Up</option>
            </select>
        </div>
        </li>
        <li>
        <div id="huntingSubmit">
            <input name="huntmygame" value="Hunt my game" src="sources/btn_hunt.png" type="image" />
        </div>
        </li>
        </ul>
        </form>
        
    </div>
    
    <div id="countdown">
        <a href="#"><img src="sources/btn_reserve.png" /></a>
    </div>
    
    <div id="bestSellers">
    	<div id="best_container">
        <!-- <p>For:</p>
        <ul id="bestSellNav">
        	<li>All</li>
            <li>XBOX 360</li>
            <li>PS3</li>
            <li>WII</li>
            <li>3DS</li>
            <li>PSP</li>
        </ul>-->
    	<div id="bestGallery">
        	<ul>
        		<li>
        			<div class="best_box">
                    	<a href="images/large/blue.jpg"><img src="images/box/dragon.jpg" alt="Blue"></a>
                    </div>
                    <div class="best_add">
                    	<p class="best_title">title</p>
                        <p class="best_price">price</p>
                        <div class="addtocart">
                        	<p>add to cart</p>
                        </div>
                    </div>
                </li>
        		<li>
        			<div class="best_box">
                    	<a href="images/large/yellow.jpg"><img src="images/box/modern.jpg" alt="Yellow"></a>
                    </div>
                    <div class="best_add">
                    	<p class="best_title">title</p>
                        <p class="best_price">price</p>
                        <div class="addtocart">
                        	<p>add to cart</p>
                        </div>
                    </div>
                </li>
        		<li>
        			<div class="best_box">
                    	<a href="images/large/green.jpg"><img src="images/box/harry.jpg" alt="Green"></a>
                    </div>
                    <div class="best_add">
                    	<p class="best_title">title</p>
                        <p class="best_price">price</p>
                        <div class="addtocart">
                        	<p>add to cart</p>
                        </div>
                    </div>
                </li>
        	    <li>
        			<div class="best_box">
                    	<a href="images/large/orange.jpg"><img src="images/box/mario.jpg" alt="Orange"></a>
                    </div>
                    <div class="best_add">
                    	<p class="best_title">title</p>
                        <p class="best_price">price</p>
                        <div class="addtocart">
                        	<p>add to cart</p>
                        </div>
                    </div>
               </li>
        	</ul>
        </div>    
        
     </div>
    </div>
</div>
	<?php include("includes/footer.php"); ?>

</body>
</html>
