<?php
/*
Author: D. Jean Hester
Date:  February 22, 2010
Course:  Ecommerce Site Design
Version: 1.0 
Description:  Script to process order form from product pages.
*/

//get the information from the POST array
$product_id = $_POST["product_id"];
$platform_id = $_POST["platform_id"];
$qty = $_POST["qty"];


//here we're using the index from the quantity array as the key to the other two arrays 
//for product and type.  Loop through each row in array and access the info.
if (is_array($qty)) {
	
	foreach($qty as $key => $item_qty) {
		
		//for security, force the inputs from the form into an integer type using intval()
		$item_qty = intval($item_qty);
		if ($item_qty > 0) {
				$id = intval($product_id[$key]);
				$platform = intval($platform_id[$key]);
				//here for troubleshooting:
				echo "You added $item_qty of Product Item $id of platform $platform. <br>";
				/*TO DO - 
				1. need to add this information to the orders database!  
				2. Then update inventory number.
				3. Redirect to cart summary page OR to products page...
				
				*/
		}
	}
} 


//echo '<a href="../index.php">Back Home</a>';
echo '<br/><a href="../products.php">Back to Products</a>';
//header('Location: ../index.php');


?>