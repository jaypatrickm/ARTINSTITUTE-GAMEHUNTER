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
<title>Delivery Details</title>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
    
    $('#delivery').hide();
	$('#deliveryForm').hide();
	$('#deliveryForm').attr('disabled', true);
	$('#deliveryA').click(function() {
		if($(this).attr('checked')) {
			$('#delivery').show();
			$('#deliveryForm').slideDown();	
			$('#deliveryText').hide();
			$('#deliveryA').css('margin-bottom', '-16px');
			$('#deliveryA').css('top', '-23px');
			$('#deliveryForm').attr('disabled', false);

		} else {
			$('#delivery').hide();
			$('#deliveryForm').slideUp();	
			$('#deliveryText').show();
			$('#deliveryA').css('margin-bottom', '0px');
			$('#deliveryA').css('top', '-20px');
			$('#deliveryForm').attr('disabled', true);
		}
	});
	
	$('#yourinformation').validate();
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

    <p class="headline">Delivery Details</p>
    <hr />
    <p class="subline">How would you like this shipped?</p>
    <hr />
    <p class="title">The current items are shipping to this address.</p>
	<hr class="thicker" />
    
    <p>Deliver to:</p>
    <p class="deliveryShow">Jay Manalansan</p>
	<p class="deliveryShow">1201 Magnolia Ave.</p>
    <p class="deliveryShow">Gardena, CA 90247</p>
    <p class="deliveryShow">United States of America</p>
    <p class="deliveryShow">(310)308-1074</p>
    
	<form action"#" method="post" name="deliveryDetails" id="deliveryDetails">
     <div id="handlingWrapper">
       <p>Please select a handling method:</p>
       <div>
          <input type="radio" name="shipping" id="value" value="value" class="required" title="Please select an option" checked>
          <label class="handling" for="value">USA Value - $0.00 - Allow 5-10 business days for shipping & handling </label>
       </div>
       <div>
          <input type="radio" name="shipping" id="ground" value="ground">
          <label class="handling" for="ground">USA Ground - $5.99 - Allow 3 business days for shipping & handling </label>
       </div>
       <div>
          <input type="radio" name="shipping" id="2day" value="2day">
          <label class="handling" for="2day">USA 2-Day - $6.99 - Allow 2 business days for shipping & handling </label>
       </div>
       <div>
          <input type="radio" name="shipping" id="overnight" value="overnight">
          <label class="handling" for="overnight">USA Overnight - $9.99 - Allow 1 business day for shipping & handling </label>
       </div>
     </div>

     <br />
     <hr class="thicker" />
     <p class="sub_total">Sub-Total: <p id="sub_total_price">$99.98</p></p>
     <hr class="smallRT" />
     <p class="shipping_choice">Shipping Choice: <p id="plus">+</p> <p id="handlingPrice">$00.00</p></p>
     <hr class="smallRT2" />
     <p class="grand_total">Grand Total: <p id="grand_total_price">$99.98</p></p>
     
     <div>
          <input type="submit" name="deliveryDetails" id="deliveryDetails" value="Continue" />
     </div>
    </form>

</div><!-- end of outerWrapper -->
</body>
</html>
