<?php
session_start();

//////////////////////////
///CHECK WHERE WE CAME FROM : FROM UPDATE BUTTON or FROM CHECKOUT BUTTON?

if (array_key_exists('goToCheckout', $_POST)) {
	//redirect to checkout page
	header("Location: yourinformation.php");
} elseif (array_key_exists('update', $_POST)) {
	
	//NEW FROM WK8
	//update the quantities on the form and reload the form
	//also update the SESSION variables

	///FOR troubleshooting: Reference to see what is on POST vs what is on CART
	echo "UPDATE ARRAY KEY EXISTS <hr>";
	echo "ON THE POST in the page: ";
	print_r($_POST); //for troubleshooting
	echo "<hr>";
	echo "IN THE CART in the page: ";
	print_r($_SESSION['cart']);
	echo "<hr>";
	
//////////////////////////////////////
//LOOP THROUGH CART AND CHECK QUANTITIES
	
	//SET COUNTER
	$length = count($_SESSION['cart']); 
	echo "LENGTH of cart IN UPDATE is: " . $length . "<br/>";//for troubleshooting 
	
	//for troubleshooting
	if ($length == 0) {
		echo "nothing in the cart now!";
	}//end of if
	
	//LOOP THROUGH CART ELEMENTS
	for ($row = 0; $row < $length; $row++) {
			echo "<hr>"; //for troubleshooting
			echo "Looping through the update for loop: " . $row . "</br>";//for troubleshooting
			
			//setting the product id and platform id for use in if conditional
			//Need both product and platform id to get a true match on item = composite primary key
			
			$product_id = $_SESSION['cart'][$row]['product_id'];
			$platform_id = $_SESSION['cart'][$row]['platform_id'];
			$combo_id = $product_id.$platform_id;//NOTE NO SPACE between variables
			echo "Combo id is: " . $combo_id . "<br/>";//for troubleshooting
			
			//set quantity variables for use in if/elseif conditionals
			$origQty = $_SESSION['cart'][$row]['item_qty'];//the original qty in form/session
			$updateQty = $_POST["item_qty"][$row];//the new updated qty that came from POST
			
			/////////////////////////////////////////////////
			//CHECK TO SEE WHAT'S in ITEM QUATNTITY FIELD OR IF DELETE CHECKED
			
			//ISSUE: The "delete" checkbox array is created ONLY IF CHECKED. As a result, if the delete
			//box for the third item (index 2) was checked it would create an array and have index 0, which 
			//DOES NOT WORK the same way we've been able to use indexes to connect our product, platform, and qty
			//if qty is zero or if "delete" box is check, then unset from session
				//The second part of the conditionnal is a nested conditional statement:
					/* !empty($_POST['delete]) --> is checking to see if there is an array on the post 
					named delete - which there will be ONLY IF a delete checkbox was checked 
					AND
					in_array($combo_id, $_POST['delete']) --> look in that array and see if there is
					a value that matches the $combo_id variable which was set above, and matches the value
					that is placed in the HTML form element value for the delete checkbox
					If BOTH of these are true, then it means that the delete box was checked for this
					particular Product/platform item that we are currently looping through
					*/
			////IF ZERO QUANTITY OR DELETE BOX CHECKED
			if ($updateQty == 0 || (!empty($_POST['delete']) && in_array($combo_id, $_POST['delete']))){
				
				echo "<strong>inside if/else for qty: ZERO OR CHECKED</strong> <br />"; //for troubleshooting
				//unset the product from session
				unset($_SESSION['cart'][$row]);
				unset($_SESSION['cart'][$row]['product_id']);
				unset($_SESSION['cart'][$row]['platform_id']);
				unset($_SESSION['cart'][$row]['price']);
				unset($_SESSION['cart'][$row]['item_qty']);
		
				//for troubleshooting
				echo "Orig qty is: " . $origQty . "</br>";
				echo "Update qty is: " . $updateQty . "</br>";
				echo "new session qty after changing the session is: " . $_SESSION['cart'][$row]['item_qty']. "</br>";
				echo "<hr>";
				
			////// IF UPDATE QTY IS NOT SAME AS ORIGINAL QTY BUT NOT ZERO			
			} elseif ($updateQty != $origQty) {
				
				echo "<strong>inside if/else for qty: ELSEIF - orig not equal to update qty!!!</strong> <br/>"; //for troubleshooting
				//update the item to the NEW requested quantity FROM THE POST which is NOT ZERO
				
				//set variables for the new updated information coming from POST
				//we will need these to rebuild form and to do comparisons
				$updateQty = $_POST["item_qty"][$row];
				$updateProd = $_POST["product_id"][$row];
				$updatePlatform = $_POST["platform_id"][$row];
				$updatePrice = $_POST["price"][$row];

				//unset old quantity AND other elements ON SESSION
				unset($_SESSION['cart'][$row]['product_id']);
				unset($_SESSION['cart'][$row]['platform_id']);
				unset($_SESSION['cart'][$row]['price']);
				unset($_SESSION['cart'][$row]['item_qty']);
				
				//REST the elements to the new udpated values
				//NOTE THE PRODUCT ID COMES FIRST.  NEED this order to match the array key order in the
				//Add to cart script!
				$_SESSION['cart'][$row]['product_id'] = $updateProd;
				$_SESSION['cart'][$row]['platform_id'] = $updatePlatform;
				$_SESSION['cart'][$row]['price'] = $updatePrice;
				$_SESSION['cart'][$row]['item_qty'] = $updateQty;
								 
				//for troubleshooting
				echo "Orig qty is: " . $origQty . "</br>";
				echo "Update qty is: " . $updateQty . "</br>";
				echo "Update prod is: " . $updateProd . "</br>";
				//echo "Update id is: " . $updatePlatform . "</br>";
				//echo "Update price is: " . $updatePrice . "</br>";
				echo "New session qty after changing the session is: " . $_SESSION['cart'][$row]['item_qty']. "</br>";
				echo "<hr>";
			} else {
				//the original quantity is the same as what came through on update, so do nothing
				//for troubleshooting
				echo "<strong>inside if/else for qty: ELSE!! -- orig is same as update so no change needed</strong> <br />";
				echo "<hr>";
			}//end of if-elseif-else for updating quantities
	
	}//END FOR LOOP through car items
	
	////////////////////////////////////////////
	//RESORT ARRAY
	//NEW WEEK 8
	//now that we are done UPDATING cart items - resort all the items in the cart.
	//Resort will default to ordering on the first index which is product id, rather than having
	//the array in the order of how they were added. This helps keep order the same as when we 
	//create and add to cart in addtocart.php.
	//ALSO use array_multi-sort() to reindex the session array since some indexes will be gone
	//after the unsets and rests.
	
	array_multisort($_SESSION['cart']); //sorts on first index which in this case is product id
	
	//for troubleshooting
	echo "<hr>";
	print_r($_SESSION['cart']);
	echo "<hr>";
	
}//END of if/elseif for CHECK
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php include("includes/functions.php"); ?>

<?php
	//call the setSectionName function and assign it to $sectionName for use throughout the page
	$sectionName = setSectionName();
?>
	
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Game Hunter: <?php  echo $sectionName; ?></title>
</head>
<body>
<div id="outerWrapper">

    <div id="header">
        Game Hunter: <span class="sectionName"><?php  echo $sectionName; ?></span>
        <?php include("includes/testingnavbar.php"); ?>
    </div>
        
    <div id="contentWrapper">
            
        <div id="content">
            <h2><?php // echo $sectionName . ": ". $title; ?></h2>
            
            <form name="view_cart" id="view_cart" method="post" action="">
              <table id="view_cart">
              <tr>
                  <td><strong>Product</strong></td>
                  <td><strong>Platform</strong></td>
                  <td><strong>Price Each</strong></td>
                  <td><strong>Quantity</strong></td>
                  <td><strong>Subtotal</strong></td>
                  <td><strong>Delete?</strong></td>
              </tr>
            
              <?php 
			  //////////BUILD CART SUMMARY AND FORM ELEMENTS
			  $length = count($_SESSION['cart']); //since using a for loop, need to set a counter.
			  //echo "LENGTH of cart is: " . $length . "<br />"; //for troublshooting
			  
			  if (isset($_SESSION['cart']) && $length > 0 ) {
			  	//echo "<p>Yes a cart has been set! And length is longer than 0!</p>"; //for troublshooting
				
				//PLAN O'ACTION:
				//for each item in cart, take the product id, do query for that info from product table
				//for each item in cart, take platform id and do query for that info from platform table
				//display results
				
				//display what's in the session
				
				//Loop through the cart and display items
				$length = count($_SESSION['cart']);//since using a for loop, need to set a counter.
				//echo "LENGTH of cart is: " . $length . "<br />";
				
				//print_r($_SESSION['cart']); //for troubleshooting
				
				//connect to database
				$conn = dbConnect('query');
				
				//loop through all the cart elements and display 
				for ($row = 0; $row < $length; $row++) {
					
						//create variables for the product id and platform id which we will need for queries
						$product_id = $_SESSION['cart'][$row]['product_id'];
						$platform_id = $_SESSION['cart'][$row]['platform_id'];
						
						//echo "Product id is: " . $product_id . "<br />"; //for troubleshooting
						//echo "Platform id is: " . $platform_id . "<br />"; //for troubleshooting
						
						//GET NAME OF PRODUCT
						//create SQL query to get the product name that matches the product id
						$sqlProd = "SELECT title
						FROM product
						WHERE product_id = $product_id";
						
						//submit the SQL query to the database and get the result for product name
						$resultProd = $conn->query($sqlProd) or die(mysqli_error());
                        $rowProd = $resultProd->fetch_assoc();
						
						//assign product name to variable that we can use to display
                        $productName = $rowProd['title'];
                          
                        //free result of product name query
                        $resultProd->free_result();
						
						//GET PLATFORM OF PRODUCT
						//create SQL query to get the platform name that matches the platform id
						$sqlPlatform = "SELECT platform_name 
						FROM platform 
						WHERE platform_id = $platform_id";
						
						//submit the SQL query to the database and get the result for platform name
						$resultPlatform = $conn->query($sqlPlatform) or die(mysqli_error());
						$rowPlatform = $resultPlatform->fetch_assoc();
						
						//assign platform name to variable that we can to display
						$platformName = $rowPlatform['platform_name'];
						
						//free result of platform name query
						$resultPlatform->free_result();
						
						
						//GET PRICE INFORMATION
						//variables for price info on the $_SESSION
						$price = $_SESSION['cart'][$row]['price'];
							  //TO DO - this should be reselected from the DB, rather than taken from the session.  Price on _POST could be hacked, and reset by user.  Security issue.
						$totalPriceEach = ($_SESSION['cart'][$row]['item_qty'] * $price);
						
						
						
						//DISPLAY PRODUCT INFORMATION IN OUR CART DISPLAY
						//write out the information for this product/platform in our table
						echo "<tr>";
						echo "<td>" . ucwords($productName) . "</td>";//product
						echo "<input type=\"hidden\" name=\"product_id[]\" value=\"$product_id\">";
						echo "<td>" . ucwords($platformName) . "</td>";//platform
						echo "<input type=\"hidden\" name=\"platform_id[]\" value=\"$platform_id\">";
						echo "<td>" . number_format($price, 2, '.', ',') . "</td>"; //price each
						echo "<input type=\"hidden\" name=\"price[]\" value=\"$price\">";
						
						//NEW WEEK 8: change the quantity form information - need an array on the field name instead of the quantity in the session, so we can rebuild this array in the form after it's updated
						  //echo "<td><input type=\"text\" name=\"" . $_SESSION['cart'][$row]['item_qty'] . "\" size=\"3\" maxlength=\"3\" value=\"". $_SESSION['cart'][$row]['item_qty'] . "\"/></td>"; //quantity in editable form field
						echo "<td><input type=\"text\" name=\"item_qty[]\" size=\"3\" maxlength=\"3\" value=\"". $_SESSION['cart'][$row]['item_qty'] . "\"/></td>"; //quantity in editable form field

						echo "<td>" . number_format($totalPriceEach, 2, '.', ',') . "</td>"; //total for that product
						
						//NEW WEEK 8
						//add the [] to the delete name, so we make this into an array ONLY WHEN IT'S CHECKED
						echo "<td> <input type=\"checkbox\" name=\"delete[]\"  value=\"$product_id$platform_id\" /></td>"; //check if want to delete product
						//NOTE:  the value of the delete box is the combined product id and platform id - NO SPACE between them
						echo "</tr>";
						
//Getting Error Message, $grandTotal is undefined, putting if statement to work around
/*						if (isset($grandTotal)) {
							$grandTotal = $grandTotal + $totalPriceEach;	
							echo $grandTotal;
							echo "test1";
						} else {
							$grandTotal = $totalPriceEach;
							echo "test";
						}
						
						if (isset($grandTotalItems)) {
							$grandTotalItems = $grandTotalItems + $_SESSION['cart'][$row]['item_qty'];
							$_SESSION['items'] = $grandTotalItems;	
						} else {
							$grandTotalItems = $_SESSION['cart'][$row]['item_qty'];
							$_SESSION['items'] = $grandTotalItems;
						}
*/
		
						//Now add to the grand total each time through the loop
						$grandTotal = $grandTotal + $totalPriceEach;
						$_SESSION['total_price'] = $grandTotal; //add to the session
						
						//NEW WEEK 8
						// update the total number of items
						$grandTotalItems = $grandTotalItems + $_SESSION['cart'][$row]['item_qty'];
						$_SESSION['items'] = $grandTotalItems; //add to session

				}//end of loop through cart
					
			 } elseif (isset($_SESSION['cart']) && $length == 0) {
				//NEW WEEK 8
				//there is STILL a cart, but everything has been dumped from it via updating on the form
				//set the total items and grand total price to zero
				$_SESSION['total_price'] = 0;
				$_SESSION['items'] = 0;
				
				echo "<tr>";
				echo "<td colspan=\"6\">You have removed everything from your cart.</td>";
				echo "</tr>";
			
			 } else { //there is no cart 
				echo "<tr>";
				echo "<td colspan=\"6\">You have nothing in your cart yet.  Add something!</td>";
				echo "</tr>";
			 }//end if else
				 
		     //Build summary section of cart display
			 echo "<tr>";
			 echo "<td colspan=\"6\">Number of Items: " . $_SESSION['items'];
			 echo "</tr>";
			 echo "<tr>";
			 echo "<td colspan=\"6\">Grand total: " . number_format($_SESSION['total_price'], 2, '.', ',') . "</td>";
			 echo "</tr>";
			
			?>
			 }
             </table>
		   <input name="update" id="update" type="submit" value="Update Quantity" />
           <input name="goToCheckout" id="goToCheckout" type="submit" value="Checkout!" />
           </form>	
        </div>
        
    </div>
    
    
  
</div>

</body>
</html>