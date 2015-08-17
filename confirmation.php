<?php
session_start(); 

if (array_key_exists('deliveryDetails', $_POST)) {
//list expected fields
$expected = array('deliveryDetails');
//set required fields
$required = array('deliveryDetails' );
//set default values for variables that might not exist
require('./includes/processmail.inc.php');

$_SESSION['shipping'] = $_POST['shipping'];
header("Location: paymentdetails.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formstyle.css" rel="stylesheet" type="text/css" />
<title>Confirmation Order</title>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	/*$("#photos").cycle();*/
	$('#slideshow').show();
    $('#slideshow').cycle({
        fx: 'scrollLeft',
        timeout: 5000,
        after: function() {
            // $("dd").fadeOut("slow");
            $(this).children("dd").fadeIn("slow");
        },
        before: function () {
            $(this).children("dd").hide();
        }
    });
	
	
	$('#allNav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#2b2a2a')});
	$('#xbox360Nav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#699635')});
	$('#ps3Nav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#354e96')});
	$('#wiiNav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#359096')});
	$('#dsNav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#4c3596')});
	$('#pspNav').hover( function(){	
		$('#subNav').slideDown();
		$('#subNav').css('background-color', '#963535')});
	
});//end ready()
</script>
</head>

<body id="xbox360Index">
	<div id="infoBox">
    	<div id="greeting">
        	<p>Hello fellow gamer! Please <span class="greetLink">Log in</span> or <span class="greetLink">Sign Up!</span></p>
        </div>
        <div id="cartBox">
        	<p class="40px"><?php if (!isset($_SESSION['cart'])) { echo "0";} else { echo $_SESSION['items']; }?> items</p>
        	<a href="testingviewcart.php"><img border="0" class="40px" src="images/cart.png" /></a>
        </div>
      
        <div id="logIn">
        	<p>Insert Form Here!</p>
        </div>
        <br class="clearfix">
    </div>
	
    <div id="ghLogo">
    	<a href="index.php"><img border="0" src="images/ghlogo.png"  /></a>
    </div>
    
   
   	<?php include("includes/navbar.php"); ?>
    <div id="searchBar">
    	<input name="search" type="text" value="Search for your game!" size="30" /><input name="search" type="button" value="Search" />
    </div>
    
    <div id="subNav">
    	<ul id="subNavText">
            <li>Action</li>
            <li>Adventure</li>
            <li>Casual</li>
            <li>Fighting</li>
            <li>Music & Party</li>
            <li>Puzzle</li>
            <li>Role-Playing</li>
            <li>Shooter</li>
            <li>Simulation</li>
            <li>Sports</li>
            <li>Strategy</li>
        </ul>
    </div>
    
<div id="outerWrapper">

    <p class="headline">Confirmation Order</p>
    <hr />
    <p class="subline">Your order has been processed</p>
    <hr />
    <p class="title">This is your confirmation number : #798B712EE687</p>
	
    </div>
    
    

    <p id="disclaimer"> WARNING! THIS IS NOT A REAL SITE! </p>
    <p id="disclaimer2"> NOTHING WILL BE SENT TO YOU! </p>

</div>--><!-- end of outerWrapper -->
</body>
</html>
