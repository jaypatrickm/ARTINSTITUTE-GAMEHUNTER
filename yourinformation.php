<?php
session_start(); 
include("includes/functions.php");
nukeMagicQuotes();
/*
Description: Script to build a summary of items in shopping cart, build order form, capture information and add to database when customer checks out.

TO DO - 
	  -- Add shipping address to form, and code the check if the same then ignore, otherwise use that shipping address for orders table
	  --Validation on form
	  --if customer already in table, then don't insert, just get their customer # and use that
	  -- Update inventory number by decrementing from number of items bought.
	  -- Comment out all troubleshooting code

 PLAN OF ATTACK:
	insert customer stuff into customer table
	then get the customer id for customer just inserted
	then use that customer id to insert the order into the orders table
	then get that order id just inserted
	then finally use that order id to enter products into order_items table by
		looping through the SESSION cart variables
*/

//Being PHP validation
$errors = array();
$missing = array();
//if (isset($_POST['yourinformation'])) {
if (array_key_exists('yourinformation', $_POST)) {
nukeMagicQuotes();
// email processing script
$to = 'jmanalansan@gmail.com'; //use your own email address
$subject = 'Form Validation';
//list expected fields
$expected = array('emailAccount', 'confirmEmailAccount', 'password', 'confirmPassword', 'billingFirst', 'billingLast', 'billingEmail', 'billingStreet', 'billingCity', 'billingState', 'billingZip', 'billingCountry', 'deliveryFirst', 'deliveryLast', 'deliveryEmail', 'deliveryStreet', 'deliveryCity', 'deliveryState', 'deliveryZip', 'deliveryCountry');
//set required fields
$required = array('emailAccount', 'confirmEmailAccount', 'password', 'confirmPassword', 'billingFirst', 'billingLast', 'billingEmail', 'billingStreet', 'billingCity', 'billingState', 'billingZip', 'billingCountry', );
require('./includes/processmail.inc.php');
$_SESSION['emailAccount'] = $_POST['emailAccount'];
$_SESSION['confirmEmailAccount']  = $_POST['confirmEmailAccount'];
$_SESSION['password']  = $_POST['password'];
$_SESSION['confirmPassword']  = $_POST['confirmPassword'];
$_SESSION['billingFirst'] = $_POST['billingFirst'];
$_SESSION['billingLast']  = $_POST['billingLast'];
$_SESSION['billingEmail']  = $_POST['billingEmail'];
$_SESSION['billingStreet']  = $_POST['billingStreet'];
$_SESSION['billingCity']  = $_POST['billingCity'];
$_SESSION['billingState']  = $_POST['billingState'];
$_SESSION['billingZip']  = $_POST['billingZip'];
$_SESSION['billingCountry']  = $_POST['billingCountry'];
$_SESSION['deliveryFirst'] = $_POST['deliveryFirst'];
$_SESSION['deliveryLast']  = $_POST['deliveryLast'];
$_SESSION['deliveryEmail']  = $_POST['deliveryEmail'];
$_SESSION['deliveryStreet']  = $_POST['deliveryStreet'];
$_SESSION['deliveryCity']  = $_POST['deliveryCity'];
$_SESSION['deliveryState']  = $_POST['deliveryState'];
$_SESSION['deliveryZip']  = $_POST['deliveryZip'];
$_SESSION['deliveryCountry']  = $_POST['deliveryCountry'];

header("Location: deliverydetails.php");	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formstyle.css" rel="stylesheet" type="text/css" />
<title>Your Information</title>
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
    
	<div id="yourInformationBody">
    <p class="headline">Your Information</p>
    <hr />
    <p class="subline">Create Your Account</p>
    <hr />
    <p class="title">Security Information</p>
	<hr class="thicker" />
	<?php if ($missing || $errors) { ?>
		<p class="warning">Please fix the item(s) indicated.</p>
	<?php } ?>
	<form action" " method="post" name="yourinformation" id="yourinformation">
     
     <div>
      <label for="emailAccount" class="label">Email Address*
		<?php if ($missing && in_array('emailAccount', $missing)) { ?>
          <span class="warning">Please enter your email address.</span>
        <?php } ?>
      </label>
      <input name="emailAccount" type="text" id="emailAccount" size="36" class="required" 
      	<?php if (($missing && (isset($emailAccount)))|| ($errors && (isset($emailAccount)))) {
			echo 'value="' . htmlentities($emailAccount, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
	 </div>
     
     <div>
      <label for="confirmEmailAccount" class="label">Confirm Email Address*
      	<?php if ($missing && in_array('confirmEmailAccount', $missing)) { ?>
          <span class="warning">Please confirm your email address.</span>
        <?php } ?>
      </label>
      <input name="confirmEmailAccount" type="text" id="confirmEmailAccount" size="36" class="required" 
		<?php if (($missing && (isset($confirmEmailAccount)))|| ($errors && (isset($confirmEmailAccount)))) {
			echo 'value="' . htmlentities($confirmEmailAccount, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
	 </div>
     <div>
      <label for="password" class="label">Enter Your Password*
      	<?php if ($missing && in_array('password', $missing)) { ?>
          <span class="warning">Please enter a new password.</span>
        <?php } ?>
      </label>
      <input name="password" type="password" id="password" size="36" class="required" 
      <?php if (($missing && (isset($password)))|| ($errors && (isset($password)))) {
			echo 'value="' . htmlentities($password, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
	 </div>
     <div>
      <label for="confirmPassword" class="label">Confirm Password*
      	<?php if ($missing && in_array('confirmPassword', $missing)) { ?>
          <span class="warning">Please confirm your new password.</span>
        <?php } ?>
      </label>
      <input name="confirmPassword" type="password" id="confirmPassword" size="36" class="required" 
      <?php if (($missing && (isset($confirmPassword)))|| ($errors && (isset($confirmPassword)))) {
			echo 'value="' . htmlentities($confirmPassword, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
	 </div>
     
     <br />
     <p class="title">Billing Address</p>
     <p class="title" id="delivery">Delivery Address</p>
     <!--<p class="title" id="delivery">Enter Separate Delivery Address</p>-->
     <input type="checkbox" name="deliveryA" id="deliveryA" value="deliveryA">
	 <label class="title" id="deliveryText" for="deliveryA">Enter Separate Delivery Address</label>
	 <hr class="thicker" />
     
     <div>
      <label for="billingFirst" class="label">First Name*
      	<?php if ($missing && in_array('billingFirst', $missing)) { ?>
          <span class="warning">Please enter your first name.</span>
        <?php } ?>
      </label>
      <input name="billingFirst" type="text" id="billingFirst" size="36" class="required" 
      <?php if (($missing && (isset($billingFirst)))|| ($errors && (isset($billingFirst)))) {
			echo 'value="' . htmlentities($billingFirst, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
	 </div>
     <div>
      <label for="billingLast" class="label">Last Name*
      	<?php if ($missing && in_array('billingLast', $missing)) { ?>
          <span class="warning">Please enter your last name.</span>
        <?php } ?>
      </label>
      <input name="billingLast" type="text" id="billingLast" size="36"class="required" 
      <?php if (($missing && (isset($billingLast)))|| ($errors && (isset($billingLast)))) {
			echo 'value="' . htmlentities($billingLast, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
     </div>
     <div>
      <label for="billingEmail" class="label">Email*
      	<?php if ($missing && in_array('billingEmail', $missing)) { ?>
          <span class="warning">Please enter your email address.</span>
        <?php } ?>
      </label>
      <input name="billingEmail" type="text" id="billingEmail" size="36" class="required" 
      <?php if (($missing && (isset($billingEmail)))|| ($errors && (isset($billingEmail)))) {
			echo 'value="' . htmlentities($billingEmail, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
     </div>
     <div>
      <label for="billingStreet" class="label">Street Address*
      	<?php if ($missing && in_array('billingStreet', $missing)) { ?>
          <span class="warning">Please enter your address.</span>
        <?php } ?>
      </label>
      <input name="billingStreet" type="text" id="billingStreet" size="36" class="required" 
      <?php if (($missing && (isset($billingStreet)))|| ($errors && (isset($billingStreet)))) {
			echo 'value="' . htmlentities($billingStreet, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
     </div>
     <div>
      <label for="billingCity" class="label">City*
      	<?php if ($missing && in_array('billingCity', $missing)) { ?>
          <span class="warning">Please enter your city.</span>
        <?php } ?>
      </label>
      <input name="billingCity" type="text" id="billingCity" size="36" class="required" 
      <?php if (($missing && (isset($billingCity)))|| ($errors && (isset($billingCity)))) {
			echo 'value="' . htmlentities($billingCity, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
     </div>
     <div>
     <label for="billingState" class="label">State*
     	<?php if ($missing && in_array('billingState', $missing)) { ?>
          <span class="warning">Please select your state.</span>
        <?php } ?>
     </label>
     <select name="billingState" id="billingState" size="1" class="required" >
     	
       <option value="No reply"
	   	<?php if (!$_POST || $_POST['billingState'] == 'No reply') {
			echo 'selected';
		} ?>>State...</option>
       <option value="Alabama"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Alabama') {
	   		echo 'selected';
	   	}?>>Alabama</option>
       <option value="Alaska"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Alaska') {
	   		echo 'selected';
	   	}?>>Alaska</option>
       <option value="Arizona"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Arizona') {
	   		echo 'selected';
	   	}?>>Arizona</option>
       <option value="Arkansas"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Arkansas') {
	   		echo 'selected';
	   	}?>>Arkansas</option>
       <option value="California"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'California') {
	   		echo 'selected';
	   	}?>>California</option>
       <option value="Colorado"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Colorado') {
	   		echo 'selected';
	   	}?>>Colorado</option>
       <option value="Connecticut"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Connecticut') {
	   		echo 'selected';
	   	}?>>Connecticut</option>
       <option value="Delaware"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Delaware') {
	   		echo 'selected';
	   	}?>>Delaware</option>
       <option value="Florida"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Florida') {
	   		echo 'selected';
	   	}?>>Florida</option>
       <option value="Goergia"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Georgia') {
	   		echo 'selected';
	   	}?>>Georgia</option>
       <option value="Hawaii"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Hawaii') {
	   		echo 'selected';
	   	}?>>Hawaii</option>
       <option value="Idaho"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Idaho') {
	   		echo 'selected';
	   	}?>>Idaho</option>
       <option value="Illinois"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Illinois') {
	   		echo 'selected';
	   	}?>>Illinois</option>
       <option value="Indiana"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Indiana') {
	   		echo 'selected';
	   	}?>>Indiana</option>
       <option value="Iowa"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Iowa') {
	   		echo 'selected';
	   	}?>>Iowa</option>
       <option value="Kansas"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Kansas') {
	   		echo 'selected';
	   	}?>>Kansas</option>
       <option value="Kentucky"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Kentucky') {
	   		echo 'selected';
	   	}?>>Kentucky</option>
       <option value="Lousiana"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Louisiana') {
	   		echo 'selected';
	   	}?>>Louisiana</option>
       <option value="Maine"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Maine') {
	   		echo 'selected';
	   	}?>>Maine</option>
       <option value="Maryland"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Maryland') {
	   		echo 'selected';
	   	}?>>Maryland</option>
       <option value="Massachusetts"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Massachusetts') {
	   		echo 'selected';
	   	}?>>Massachusetts</option>
       <option value="Michigan"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Michigan') {
	   		echo 'selected';
	   	}?>>Michigan</option>
       <option value="Minnesota"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Minnesota') {
	   		echo 'selected';
	   	}?>>Minnesota</option>
       <option value="Mississippi"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Mississippi') {
	   		echo 'selected';
	   	}?>>Mississippi</option>
       <option value="Missouri"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Missouri') {
	   		echo 'selected';
	   	}?>>Missouri</option>
       <option value="Montana"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Montana') {
	   		echo 'selected';
	   	}?>>Montana</option>
       <option value="Nebraska"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Nebraska') {
	   		echo 'selected';
	   	}?>>Nebraska</option>
       <option value="Nevada"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Nevada') {
	   		echo 'selected';
	   	}?>>Nevada</option>
       <option value="New Hampshire"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'New Hampshire') {
	   		echo 'selected';
	   	}?>>New Hampshire</option>
       <option value="New Jersey"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'New Jersey') {
	   		echo 'selected';
	   	}?>>New Jersey</option>
       <option value="New Mexico"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'New Mexico') {
	   		echo 'selected';
	   	}?>>New Mexico</option>
       <option value="New York"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'New York') {
	   		echo 'selected';
	   	}?>>New York</option>
       <option value="North Carolina"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'North Carolina') {
	   		echo 'selected';
	   	}?>>North Carolina</option>
       <option value="North Dakota"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'North Dakota') {
	   		echo 'selected';
	   	}?>>North Dakota</option>
       <option value="Ohio"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Ohio') {
	   		echo 'selected';
	   	}?>>Ohio</option>
       <option value="Oklahoma"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Oklahoma') {
	   		echo 'selected';
	   	}?>>Oklahoma</option>
       <option value="Oregon"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Oregon') {
	   		echo 'selected';
	   	}?>>Oregon</option>
       <option value="Pennsylvania"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Pennsylvania') {
	   		echo 'selected';
	   	}?>>Pennsylvania</option>
       <option value="Rhode Island"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Rhode Island') {
	   		echo 'selected';
	   	}?>>Rhode Island</option>
       <option value="South Carolina"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'South Carolina') {
	   		echo 'selected';
	   	}?>>South Carolina</option>
       <option value="South Dakota"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'South Dakota') {
	   		echo 'selected';
	   	}?>>South Dakota</option>
       <option value="Tennessee"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Tennessee') {
	   		echo 'selected';
	   	}?>>Tennessee</option>
       <option value="Texas"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Texas') {
	   		echo 'selected';
	   	}?>>Texas</option>
       <option value="Utah"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Utah') {
	   		echo 'selected';
	   	}?>>Utah</option>
       <option value="Vermont"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Vermont') {
	   		echo 'selected';
	   	}?>>Vermont</option>
       <option value="Virginia"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Virginia') {
	   		echo 'selected';
	   	}?>>Virginia</option>
       <option value="Washington"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Washington') {
	   		echo 'selected';
	   	}?>>Washington</option>
       <option value="West Virginia"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'West Virginia') {
	   		echo 'selected';
	   	}?>>West Virginia</option>
       <option value="Wisconsin"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Wisconsin') {
	   		echo 'selected';
	   	}?>>Wisconsin</option>
       <option value="Wyoming"
       	<?php if (isset($_POST) && isset($_POST['billingState']) == 'Wyoming') {
	   		echo 'selected';
	   	}?>>Wyoming</option>
     </select>
     </div>
     <div>
      <label for="billingZip" class="label">Zip*
      	<?php if ($missing && in_array('billingZip', $missing)) { ?>
          <span class="warning">Please enter your zip.</span>
        <?php } ?>
      </label>
      <input name="billingZip" type="text" id="billingZip" size="36" maxlength="5" class="required" 
      <?php if (($missing && (isset($billingZip)))|| ($errors && (isset($billingZip)))) {
			echo 'value="' . htmlentities($billingZip, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
     </div>
     
     <div>
      <label for="billingCountry" class="label">Country*
      	<?php if ($missing && in_array('billingCountry', $missing)) { ?>
          <span class="warning">Please select your country.</span>
        <?php } ?>
      </label>
      <select name="billingCountry" id="billingCountry" size="1" class="required">
		<option value="No reply"
        <?php if (!$_POST || $_POST['billingCountry'] == 'No reply') {
			echo 'selected';
		} ?>>Country...</option>
      	<option value="United States of America"
        <?php if (isset($_POST) && isset($_POST['billingCountry']) == 'United States of America') {
	   		echo 'selected';
	   	}?>>United States of America</option>
      </select>
     </div>
     <div id="deliveryForm">
       <div>
        <label for="deliveryFirst" class="label">First Name*
        	<?php if ($missing && in_array('deliveryFirst', $missing)) { ?>
         	 <span class="warning">Please enter delivery first name.</span>
        	<?php } ?>
        </label>
        <input name="deliveryFirst" type="text" id="deliveryFirst" size="36" class="required" 
        	<?php if (($missing && (isset($deliveryFirst)))|| ($errors && (isset($deliveryFirst)))) {
			echo 'value="' . htmlentities($deliveryFirst, ENT_COMPAT, 'UTF-8') . '"';
			} ?>> 
       </div>
       <div>
        <label for="deliveryLast" class="label">Last Name*
        	<?php if ($missing && in_array('deliveryLast', $missing)) { ?>
         	 <span class="warning">Please enter delivery last name.</span>
        	<?php } ?>
        </label>
        <input name="deliveryLast" type="text" id="deliveryLast" size="36" class="required" 
        	<?php if (($missing && (isset($deliveryLast)))|| ($errors && (isset($deliveryLast)))) {
			echo 'value="' . htmlentities($deliveryLast, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
       </div>
       <div>
        <label for="deliveryEmail" class="label">Email*
        	<?php if ($missing && in_array('deliveryEmail', $missing)) { ?>
         	 <span class="warning">Please enter delivery email.</span>
        	<?php } ?>
        </label>
        <input name="deliveryEmail" type="text" id="deliveryEmail" size="36" class="required" 
        	<?php if (($missing && (isset($deliveryEmail)))|| ($errors && (isset($deliveryEmail)))) {
			echo 'value="' . htmlentities($deliveryEmail, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
       </div>
       <div>
        <label for="deliveryStreet" class="label">Street Address*
        	<?php if ($missing && in_array('deliveryStreet', $missing)) { ?>
         	 <span class="warning">Please enter delivery street address.</span>
        	<?php } ?>
        </label>
        <input name="deliveryStreet" type="text" id="deliveryStreet" size="36" class="required" 
        	<?php if (($missing && (isset($deliveryStreet)))|| ($errors && (isset($deliveryStreet)))) {
			echo 'value="' . htmlentities($deliveryStreet, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
       </div>
       <div>
        <label for="deliveryCity" class="label">City*
        	<?php if ($missing && in_array('deliveryCity', $missing)) { ?>
         	 <span class="warning">Please enter the delivery city.</span>
        	<?php } ?>
        </label>
        <input name="deliveryCity" type="text" id="deliveryCity" size="36" class="required" 
        	<?php if (($missing && (isset($deliveryCity)))|| ($errors && (isset($deliveryCity)))) {
			echo 'value="' . htmlentities($deliveryCity, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
       </div>
       <div>
       <label for="deliveryState" class="label">State*
       		<?php if ($missing && in_array('deliveryState', $missing)) { ?>
         	 <span class="warning">Please select the delivery state.</span>
        	<?php } ?>
       </label>
       <select name="deliveryState" id="deliveryState" size="1" class="required" >
       	 <?php if (($missing && (isset($deliveryCity)))|| ($errors && (isset($deliveryCity)))) {
			echo '<option selected value="' . htmlentities($deliveryCity, ENT_COMPAT, 'UTF-8') . '">$deliveryCity</option>';
			} ?>
         <option value="No reply"
	   	<?php if (!$_POST || $_POST['deliveryState'] == 'No reply') {
			echo 'selected';
		} ?>>State...</option>
       <option value="Alabama"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Alabama') {
	   		echo 'selected';
	   	}?>>Alabama</option>
       <option value="Alaska"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Alaska') {
	   		echo 'selected';
	   	}?>>Alaska</option>
       <option value="Arizona"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Arizona') {
	   		echo 'selected';
	   	}?>>Arizona</option>
       <option value="Arkansas"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Arkansas') {
	   		echo 'selected';
	   	}?>>Arkansas</option>
       <option value="California"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'California') {
	   		echo 'selected';
	   	}?>>California</option>
       <option value="Colorado"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Colorado') {
	   		echo 'selected';
	   	}?>>Colorado</option>
       <option value="Connecticut"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Connecticut') {
	   		echo 'selected';
	   	}?>>Connecticut</option>
       <option value="Delaware"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Delaware') {
	   		echo 'selected';
	   	}?>>Delaware</option>
       <option value="Florida"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Florida') {
	   		echo 'selected';
	   	}?>>Florida</option>
       <option value="Goergia"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Georgia') {
	   		echo 'selected';
	   	}?>>Georgia</option>
       <option value="Hawaii"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Hawaii') {
	   		echo 'selected';
	   	}?>>Hawaii</option>
       <option value="Idaho"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Idaho') {
	   		echo 'selected';
	   	}?>>Idaho</option>
       <option value="Illinois"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Illinois') {
	   		echo 'selected';
	   	}?>>Illinois</option>
       <option value="Indiana"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Indiana') {
	   		echo 'selected';
	   	}?>>Indiana</option>
       <option value="Iowa"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Iowa') {
	   		echo 'selected';
	   	}?>>Iowa</option>
       <option value="Kansas"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Kansas') {
	   		echo 'selected';
	   	}?>>Kansas</option>
       <option value="Kentucky"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Kentucky') {
	   		echo 'selected';
	   	}?>>Kentucky</option>
       <option value="Lousiana"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Louisiana') {
	   		echo 'selected';
	   	}?>>Louisiana</option>
       <option value="Maine"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Maine') {
	   		echo 'selected';
	   	}?>>Maine</option>
       <option value="Maryland"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Maryland') {
	   		echo 'selected';
	   	}?>>Maryland</option>
       <option value="Massachusetts"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Massachusetts') {
	   		echo 'selected';
	   	}?>>Massachusetts</option>
       <option value="Michigan"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Michigan') {
	   		echo 'selected';
	   	}?>>Michigan</option>
       <option value="Minnesota"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Minnesota') {
	   		echo 'selected';
	   	}?>>Minnesota</option>
       <option value="Mississippi"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Mississippi') {
	   		echo 'selected';
	   	}?>>Mississippi</option>
       <option value="Missouri"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Missouri') {
	   		echo 'selected';
	   	}?>>Missouri</option>
       <option value="Montana"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Montana') {
	   		echo 'selected';
	   	}?>>Montana</option>
       <option value="Nebraska"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Nebraska') {
	   		echo 'selected';
	   	}?>>Nebraska</option>
       <option value="Nevada"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Nevada') {
	   		echo 'selected';
	   	}?>>Nevada</option>
       <option value="New Hampshire"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'New Hampshire') {
	   		echo 'selected';
	   	}?>>New Hampshire</option>
       <option value="New Jersey"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'New Jersey') {
	   		echo 'selected';
	   	}?>>New Jersey</option>
       <option value="New Mexico"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'New Mexico') {
	   		echo 'selected';
	   	}?>>New Mexico</option>
       <option value="New York"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'New York') {
	   		echo 'selected';
	   	}?>>New York</option>
       <option value="North Carolina"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'North Carolina') {
	   		echo 'selected';
	   	}?>>North Carolina</option>
       <option value="North Dakota"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'North Dakota') {
	   		echo 'selected';
	   	}?>>North Dakota</option>
       <option value="Ohio"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Ohio') {
	   		echo 'selected';
	   	}?>>Ohio</option>
       <option value="Oklahoma"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Oklahoma') {
	   		echo 'selected';
	   	}?>>Oklahoma</option>
       <option value="Oregon"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Oregon') {
	   		echo 'selected';
	   	}?>>Oregon</option>
       <option value="Pennsylvania"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Pennsylvania') {
	   		echo 'selected';
	   	}?>>Pennsylvania</option>
       <option value="Rhode Island"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Rhode Island') {
	   		echo 'selected';
	   	}?>>Rhode Island</option>
       <option value="South Carolina"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'South Carolina') {
	   		echo 'selected';
	   	}?>>South Carolina</option>
       <option value="South Dakota"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'South Dakota') {
	   		echo 'selected';
	   	}?>>South Dakota</option>
       <option value="Tennessee"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Tennessee') {
	   		echo 'selected';
	   	}?>>Tennessee</option>
       <option value="Texas"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Texas') {
	   		echo 'selected';
	   	}?>>Texas</option>
       <option value="Utah"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Utah') {
	   		echo 'selected';
	   	}?>>Utah</option>
       <option value="Vermont"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Vermont') {
	   		echo 'selected';
	   	}?>>Vermont</option>
       <option value="Virginia"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Virginia') {
	   		echo 'selected';
	   	}?>>Virginia</option>
       <option value="Washington"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Washington') {
	   		echo 'selected';
	   	}?>>Washington</option>
       <option value="West Virginia"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'West Virginia') {
	   		echo 'selected';
	   	}?>>West Virginia</option>
       <option value="Wisconsin"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Wisconsin') {
	   		echo 'selected';
	   	}?>>Wisconsin</option>
       <option value="Wyoming"
       	<?php if (isset($_POST) && isset($_POST['deliveryState']) == 'Wyoming') {
	   		echo 'selected';
	   	}?>>Wyoming</option>
       </select>
       </div>
       <div>
        <label for="deliveryZip" class="label">Postal Code*
        	<?php if ($missing && in_array('deliveryZip', $missing)) { ?>
         	 <span class="warning">Please enter the delivery zip.</span>
        	<?php } ?>
        </label>
        <input name="deliveryZip" type="text" id="deliveryZip" size="36" maxlength="5" class="required" 
        	<?php if (($missing && (isset($deliveryZip)))|| ($errors && (isset($deliveryZip)))) {
			echo 'value="' . htmlentities($deliveryZip, ENT_COMPAT, 'UTF-8') . '"';
			} ?>>
       </div>
       <div>
        <label for="deliveryCountry" class="label">Country*
        	<?php if ($missing && in_array('deliveryCountry', $missing)) { ?>
         	 <span class="warning">Please select the delivery country.</span>
        	<?php } ?>
        </label>
        <select name="deliveryCountry" id="deliveryCountry" size="1" class="required" >
          <option value="No reply"
          <?php if (!$_POST || $_POST['deliveryCountry'] == 'No reply') {
			echo 'selected';
		} ?>>Country...</option>
          <option value="United States of America"
          <?php if (isset($_POST) && isset($_POST['deliveryCountry']) == 'United States of America') {
	   		echo 'selected';
	   	}?>>United States of America</option>
        </select>
       </div>
      </div>
      
      <div>
      	<input type="submit" name="yourinformation" id="submit" value="Continue" />
      </div>
   
    </form>
</div>
</div><!-- end of outerWrapper -->
</body>
</html>
