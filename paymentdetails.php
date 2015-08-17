<?php
session_start(); 

include("includes/functions.php");

/*
Description:  Script to build a summary of items in shopping cart, build order form, capture information from form and add to database when customer checks out.
*/

/* TO DO - 
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

$emailAccount = $_SESSION['emailAccount'];
$confirmEmailAccount = $_SESSION['confirmEmailAccount'];
$password = $_SESSION['password'];
$confirmPassword = $_SESSION['confirmPassword'];
$customer_fname = $_SESSION['billingFirst'];
$customer_lname = $_SESSION['billingLast'];
$customer_email = $_SESSION['billingEmail'];
$street = $_SESSION['billingStreet'];
$city = $_SESSION['billingCity'];
$state = $_SESSION['billingState'];
$zip = $_SESSION['billingZip'];
$amount = $_SESSION['total_price'];
$billingCountry = $_SESSION['billingCountry'];
$deliveryFirst = $_SESSION['deliveryFirst'];
$deliveryLast = $_SESSION['deliveryLast'];
$deliveryEmail = $_SESSION['deliveryEmail'];
$deliveryStreet = $_SESSION['deliveryStreet'];
$deliveryCity = $_SESSION['deliveryCity'];
$deliveryState = $_SESSION['deliveryState'];
$deliveryZip = $_SESSION['deliveryZip'];
$deliveryCountry = $_SESSION['deliveryCountry'];
$shipping = $_SESSION['shipping'];

//for troubleshooting
//check to see if items from previous post carry over. 
/*
echo $customer_fname . "<br />";
echo $customer_lname . "<br />";
echo $street . "<br />";
echo $city . "<br />";
echo $state . "<br />";
echo $zip . "<br />";
echo $amount . "<br />";
*/
if (array_key_exists('checkout', $_POST)) {//if checkout button pressed
	//assign _POST variables to variables for easier use
	$emailAccount = $_SESSION['emailAccount'];
	$confirmEmailAccount = $_SESSION['confirmEmailAccount'];
	$password = $_SESSION['password'];
	$confirmPassword = $_SESSION['confirmPassword'];
	$customer_fname = $_SESSION['billingFirst'];
	$customer_lname = $_SESSION['billingLast'];
	$customer_email = $_SESSION['billingEmail'];
	$street = $_SESSION['billingStreet'];
	$city = $_SESSION['billingCity'];
	$state = $_SESSION['billingState'];
	$zip = $_SESSION['billingZip'];
	$amount = $_SESSION['total_price'];//get this from session, set in view_cart.php
	$billingCountry = $_SESSION['billingCountry'];
	$deliveryFirst = $_SESSION['deliveryFirst'];
	$deliveryLast = $_SESSION['deliveryLast'];
	$deliveryEmail = $_SESSION['deliveryEmail'];
	$deliveryStreet = $_SESSION['deliveryStreet'];
	$deliveryCity = $_SESSION['deliveryCity'];
	$deliveryState = $_SESSION['deliveryState'];
	$deliveryZip = $_SESSION['deliveryZip'];
	$deliveryCountry = $_SESSION['deliveryCountry'];
	$shipping = $_SESSION['shipping'];
	
		
	
	//set variable for the order status
	$order_status = 'N'; //N for new order
	
	
	echo "<p>Name is: " . $customer_fname . $customer_lname . "</p>"; //for troubleshooting
	
	//initialize flags  - one for each insert 
	//we will use these to check that everything worked BEFORE we commit the transaction
		$OK = false; //flag for customer insert
		$OK2 = false; //flag to get customerID 
		$OK3 = false; //flag for for orders insert
		$OK4 = false; //flag to get orderID
		$OK5 = false; //flag for order_items insert
		
		
		//create database connection - note this connection is made with the admin account, that has permissions to update,insert, and delete records
		$conn = dbConnect('admin');
		
		// we want to insert the order as a transaction
  		// start one by turning off autocommit
 		$conn->autocommit(FALSE);
  
  		//TO DO:  IF WE HAD A SECURE SERVER AND/OR AN CREDIT CARD AUTHENTICATION PROVIDER, WE WOULD SEND CREDIT CARD INFO
		//OFF HERE, WAIT FOR INFO BACK, IF THEY HAVE $$ PROCESS ORDER, ELSE TELL THEM TO TRY AGAIN.
		
  		//TO DO:  test to see if this customer already exists, if so, don't add them, just get
		//	their customer id
		
		//////////////////////////////////////////////////////////////////
		//create SQL to insert customer information  -we are setting up a prepared statement
		$sql = 'INSERT INTO customer (customer_fname, customer_lname, street, city, state, zip)
				VALUES (?, ?, ?, ?, ?, ?)';
				
		//initialize prepared statement
		$stmt = $conn->stmt_init();
		if ($stmt->prepare($sql)) {
			//bind parameters and execute statement
			//NOTE!  The first parameter here indicates the data type of each of the variables passed, this order must match the order in the $sql statement above
			$stmt->bind_param('ssssss', $customer_fname, $customer_lname, $street, $city, $state, $zip);
			$OK = $stmt->execute(); //if statement executes, will set this flag to true
			// free the statement for the next query
	  		$stmt->free_result();
		}
		
		//////////////////////////////////////////////////////		
		//move on to inserting the order information into orders table, then the products into order_items table
	
			//get the customer id of the customer just inserted
			//remember, name and street etc info comes from _POST array from checkout form
			//using all the customer info to make a match just to be certain
			$getCustomerId = 'SELECT customer_id FROM customer
						  WHERE customer_fname = ? 
						  AND customer_lname = ? 
						  AND street = ?
						  AND city = ?
						  AND state = ?
						  AND zip = ?';
			// statement object already exists, so you just need to prepare it with the new SQL
			if ($stmt->prepare($getCustomerId)) {
			  // bind parameters and execute statment
			  $stmt->bind_param('ssssss', $customer_fname, $customer_lname, $street, $city, $state, $zip); 
			  // bind the result to $customer_id
			  $stmt->bind_result($customer_id);
			  // execute the statement and get the result
			  $OK2 = $stmt->execute();
			  $stmt->fetch();
			  // free the statment for the next query
			  $stmt->free_result();
			  echo "Customer id is: " . $customer_id; //for troubleshooting
			}
		//////////////////////////////////////////////////////////////////	
		//now use the customer_id to insert into order table...
			//create SQL -we are setting up a prepared statement
			//TO DO:  this shipping address needs to be added to form, and checked to see if the same as address
				//for now, just using same address they entered before for both customer address AND shipping address
			$sql = 'INSERT INTO orders (customer_id, amount, order_status, ship_customer_fname, ship_customer_lname, ship_street, ship_city, ship_state, ship_zip, date)
				VALUES (?,?,?,?,?,?,?,?,?,NOW())';
			
			//initialize prepared statement
			$stmt = $conn->stmt_init();
			if ($stmt->prepare($sql)) {
			//bind parameters and execute statement
			//NOTE!  The first parameter here indicates the data type of each of the variables passed, this order must match the order in the $sql statement above
			//NOTE:  the amount is a data type of a double, so use 'd' for 'double' in the second parameter below
			//can use the same variables as the other query
			$stmt->bind_param('idsssssss', $customer_id, $amount, $order_status, $customer_fname, $customer_lname, $street, $city, $state, $zip);
			$OK3 = $stmt->execute();
			// free the statement for the next query
	  		$stmt->free_result();
			}
		//////////////////////////////////////////////////////////////////	
		//then find out the order_id of the order we just inserted...
			//get the order id
			//remember, name and street etc info comes from _POST array from checkout form
			//using all the same customer info to make a match just to be certain
			$getOrderId = 'SELECT order_id FROM orders
						  WHERE customer_id = ?
						  AND amount = ?
						  AND order_status = ?
						  AND ship_customer_fname = ? 
						  AND ship_customer_lname = ? 
						  AND ship_street = ?
						  AND ship_city = ?
						  AND ship_state = ?
						  AND ship_zip = ?';
			// statement object already exists, so you just need to prepare it with the new SQL
			if ($stmt->prepare($getOrderId)) {
			  // bind parameters and execute statment
			  //NOTE:  the amount is a data type of a float, so use 'd' for 'double' in the second parameter below
			  $stmt->bind_param('idsssssss', $customer_id, $amount, $order_status, $customer_fname, $customer_lname, $street, $city, $state, $zip); 
			  // bind the result to $order_id
			  $stmt->bind_result($order_id);
			  // execute the statement and get the result
			  $OK4 = $stmt->execute();
			  $stmt->fetch();
			  // free the statment for the next query
			  $stmt->free_result();
			  echo "<p>Order id is: " . $order_id . "</p>"; //for troubleshooting
			}
		
		 ////////////////////////////////////////////////////////////////////////
		//then use the order id from order table AND products in cart array to insert into order_items

			//Do an insert for each loop through the cart variables below, and be sure to add other info as needed
			//		like the order id and price etc.  Set a variable for each $_session item below and then put that
			//		variable into the SQL statement
			// must add price to other pages and to session!
			
			$length = count($_SESSION['cart']);
			
			for ($row = 0; $row < $length; $row++) { //loop through all the cart elements 
						
						//assign each SESSION item to variables for SQL
						$product_id = $_SESSION['cart'][$row]['product_id'];
						$platform_id = $_SESSION['cart'][$row]['platform_id'];
						$item_price = $_SESSION['cart'][$row]['price'];
						$quantity = $_SESSION['cart'][$row]['item_qty'];
						
						echo "<p>Product is $product_id, Platform is $platform_id, Item Price is $item_price, and Quantity is $quantity.</p>";
						//create SQL -we are setting up a prepared statement
						$sql = 'INSERT INTO order_items (order_id, product_id, type_id, item_price, quantity)
							VALUES (?,?,?,?,?)';
						
						//echo "SQL is: " . $sql . "</br>";//for troubleshooting
						
						//initialize prepared statement
						$stmt = $conn->stmt_init();
						if ($stmt->prepare($sql)) {
							//bind parameters and execute statement
							//NOTE!  The first parameter here indicates the data type of each of the variables passed, 
							//this order must match the order in the $sql statement above
							$stmt->bind_param('iiidi', $order_id, $product_id, $platform_id, $item_price, $quantity);
							$OK5 = $stmt->execute();
							// free the statement for the next query
							$stmt->free_result();
						}//end if
			}//end for loop
		
		//TRANSACTIONS AND ROLLBACK
		//FOR TROUBLESHOOTING ONLY & DEMONSTRATION PURPOSES ONLY
		//changing status of $OK5 to false so we can see if rollback is working.
		//When $OK5 is set to false, none of the previous database inserts will be committed.
		//You can take a look at the page in a browser, and you'll see the customer ID and order ID there.  Make a note of them.
		//Next, go to the database - you'll see that neither of those items is in the database.
		//They weren't committed, and the status of the database was rolled back.  Data integrity
		//is maintained!
		//$OK5 = false; //for troubleshooting only
		
		//THE FOLLOWING echo statements are for troubleshooting and demo purposes only.
		if ($OK == true) {
			echo "<p>OK true.</p>";
		}
		
		if ($OK2 == true) {
			echo "<p>OK2 true.</p>";
		}
		
		if ($OK3 == true) {
			echo "<p>OK3 true.</p>";
		}
		
		if ($OK4 == true) {
			echo "<p>OK4 true.</p>";
		}
		
		if ($OK5 == true) {
			echo "<p>OK5 true.</p>";
		}
		//CHECK THOSE OK FLAGS!  Make sure all are set to true BEFORE committing the transaction!!!!!!!!
		if($OK == true && $OK2 == true && $OK3 == true && $OK4 == true && $OK5 == true) {
			//all of the inserts and queries worked, so we can commit this transaction
			echo "<h3>All of the inserts were fine, we are committing!</h3>";
			// end transaction, turn autocommit back on
  			$conn->commit();
  			$conn->autocommit(TRUE);
		} else {
			//To see this 'else' in action, uncomment the $OK5 = false line of code back in.
			//That line of code is directly above the echo statements for all the OKs.
			
			//there was an error, redirect to error page	
			echo "<h3>OOPS!  There was an error processing your order.</h3>";
			//rollback those inserts, and get the database back to where it was before we started.
			$conn->rollback();
			//turn autocommit back on
			$conn->autocommit(TRUE);
			//header("Location: error.php"); //THIS IS commented out so you can see the echo statements for troubleshooting 
		}
		
		//need to destroy the session, so the cart gets emptied and destroyed
		session_destroy();
		header("Location: confirmation.php");
		//close the database connection
		dbClose($conn);
  
		//return us to confirmation page
		//header("Location: confirmation.php");  //THIS IS commented out so you can see the echo statements for troubleshooting - uncomment when you've finished troubleshooting.
		  
} else {
	$message = "<p class=\"alert\">You do want these awesome games don't you?  Then please fill out the form in order to checkout.</p>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formstyle.css" rel="stylesheet" type="text/css" />
<title>Payment Details</title>
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

    <p class="headline">Payment Details</p>
    <hr />
    <p class="subline">Are you ready to pay?</p>
    <hr />
    <p class="title">This your payment summary.</p>
	<hr class="thicker" />
    <div id="paymentLeft">
      <p id="paymentSummary">Payment Summary</p>
      <p class="paymentShow">Sub-Total:</p>
      <p class="paymentShow">Estimated Tax: </p>
      <p class="paymentShow">Handling:</p>
    </div>
    <hr class="smallLT" />
    <div id="paymentRight">
      <p class="paymentSummaryPrice">$99.98</p>
      <p class="paymentSummaryPrice">$04.11</p>
      <p class="paymentSummaryPrice">$00.00</p>
    </div>
    <p id="total">Total: </p>
    <p id="totalPrice">$104.09</p>
    
    <div id="rightItemSummary">
    <p id="awesomeItems">Your Awesome Items!<p>
	<!--TO DO: Insert Photo and Price of the items purchased -->
    </div>
    <br />
    <hr class="thicker" />
    
    <p id="creditCardInformation">Credit Card Information</p>
    <div id="creditFormWrapLeft">
        <p id="billingAddress">Billing Address:</p>
        <p class="deliveryShow">Jay Manalansan</p>
        <p class="deliveryShow">1201 Magnolia Ave.</p>
        <p class="deliveryShow">Gardena, CA 90247</p>
        <p class="deliveryShow">United States of America</p>
        <p class="deliveryShow">(310)308-1074</p>
        <a id="newBilling" href="#">Enter New Billing Address</a>
    </div>
    <div id="creditFormWrap">
      <form action" " method="post" name="checkout" id="signup">
       
       <div>
        <label for="cardType" class="label">Credit Card Type*</label>
        <select name="cardType" id="cardType" size="1" disabled="disabled">
         <option value="">Card Type...</option>
         <option selected value="Visa">Visa</option>
         <option value="Mastercard">Mastercard</option>
         <option value="American Express">American Express</option>
         <option value="Discover">Discover</option>
        </select>
       </div>
       <div>	
        <label for="cardNumber" class="label">Credit Card Number*</label>
        <input name="cardNumber" type="text" id="cardNumber" size="16" maxlength="16" disabled="disabled" value="1234123412341234">
       </div>
       <div>	
        <label for="securityCode" class="label">Security Code*</label>
        <input name="securityCode" type="text" id="securityCode" size="5" maxlength="3" disabled="disabled" value="316">
       </div>
       <div>
        <label for="cardExpiration" class="label">Card Expiration Date*</label>
        <select name="cardExpiration" id="cardExpiration" size="1" disabled="disabled">
         <option value="">Month</option>
         <option selected value="01">01</option>
         <option value="02">02</option>
         <option value="03">03</option>
         <option value="04">04</option>
         <option value="05">05</option>
         <option value="06">06</option>
         <option value="07">07</option>
         <option value="08">08</option>
         <option value="09">09</option>
         <option value="10">10</option>
         <option value="11">11</option>
         <option value="12">12</option>
        </select>
        <select name="cardExpiration" id="cardExpiration" size="1" disabled="disabled">
         <option value="">Year</option>
         <option selected value="2011">2011</option>
         <option value="2012">2012</option>
         <option value="2013">2013</option>
         <option value="2014">2014</option>
         <option value="2015">2015</option>
         <option value="2016">2016</option>
         <option value="2017">2017</option>
         <option value="2018">2018</option>
         <option value="2019">2019</option>
         <option value="2020">2020</option>
         <option value="2021">2021</option>
         <option value="2022">2022</option>
        </select>
       </div>
       
        
          <input type="submit" name="checkout" id="submit" value="Finish Checkout!" />
        
      </form>
    </div>
    
    

    <p id="disclaimer"> WARNING! THIS IS NOT A REAL SITE! </p>
    <p id="disclaimer2"> NOTHING WILL BE SENT TO YOU! </p>

</div>--><!-- end of outerWrapper -->
</body>
</html>
