<?php
 	session_start();
?>
<?php include("includes/functions.php"); 
				
selfURL();

//check for the product_id on the query string
		if ( isset($_GET['product_id']) && is_numeric($_GET['product_id']) ) {
			
		//set the variable so it's easier to use later in script
		$product_id = $_GET['product_id']; //for troubleshooting
			
			//echo "product_id is $product_id <br>";
		} else {
			$product_id = 0;
			//echo "No product id on the url.";
		}
		
		//check for confirmation message in the session, which will be set if products added to cart, add to a variable
		if ( isset($_SESSION['conf_msg']) ) {
		$conf_msg = $_SESSION['conf_msg'];
		$class = $_SESSION['class'];
		
		//echo $conf_msg; //FOR TROUBLESHOOTING
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Game Hunter -- XBOX 360 Games</title>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#xbox360Nav').show( function(){
		$('#subNav').css('background-color', '#699635'),
		$('#huntingFieldLeft').css('background-color', '#699635'),
		$('.thickHR').css('color','#699635'),
		$('.thickHR').css('background-color', '#699635'),
		$('.productTitle').css('border-bottom-color','#699635')});
	
	
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
        	<p class="40px">0 items</p>
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
   
    <div id="huntingFieldLeft">
    	<p id="huntingFieldLeftTitle">The Hunting Field</p>
        <p id="emptyFieldText">Narrow down your results below!</p>
        <ul id="huntingLeftPlatform">
        	<li class="leftHeadline">Platform</li>
        	<li>Xbox 360</li>
            <li>Playstation 3</li>
            <li>Nintendo Wii</li>
            <li>Nintendo 3DS</li>
            <li>Playstation Portable</li>
        </ul>
        <ul id="huntingLeftGenre">
        	<li class="leftHeadline">Genre</li>
        	<li>Action</li>
            <li>Adventure</li>
            <li>Casual</li>
            <li>Fighting</li>
            <li>Music & Party</li>
            <li>Puzzle</li>
            <li>Role-Playing</li>
            <li>Shooter</li>
            <li>Simulator</li>
            <li>Sports</li>
            <li>Strategy</li>
        </ul>
        <ul id="huntingLeftESRB">
        	<li class="leftHeadline">ESRB Rating</li>
        	<li>Everyone 10+</li>
            <li>Everyone</li>
            <li>Teen</li>
            <li>Mature 17+</li>
        </ul>
        <ul id="huntingLeftGenre">
        	<li class="leftHeadline">Price Range</li>
        	<li>$10 and Under</li>
            <li>$10 - $20</li>
            <li>$20 - $30</li>
            <li>$30 - $40</li>
            <li>$50 and Up</li>
        </ul>
    </div>
    
    <div id="pageTitle">
    	<p id="pageTitleText">XBOX 360</p>
        <ul id="pageBreadcrumbXbox360">
        <li>Games</li>
        </ul>
        <ul id="pageSorterText">
        <li>Sort By</li>
        <li>Best Selling</li>
        <li>Lowest Price</li>
        </ul>
    </div>
    
    <hr id="pageRule" class="thickHR" />
    
    <div id="content">

    
<br />
 <?php
 	//Create main display all page
 	
	//connect to db
	$conn = dbConnect('query');
	
#################################################
####Connect for product to product platform lookup
#################################################	

	//set up the SQL query
	$sql = "SELECT * FROM product, platform, product_platform_lookup
			WHERE product_platform_lookup.product_id = product.product_id
			AND product_platform_lookup.platform_id = platform.platform_id
			AND product_platform_lookup.platform_id = 1";
	
	//submit the SQL query to the db and get the result
	$result = $conn->query($sql) or die(mysqli_error($conn));
	
	//set up array to store the results of the lookup table query
	$product = array();
	
	while($row = $result->fetch_assoc()) {
	//loop through the results of the query and store them into product array
				
		$product[] = array(
						'product_id' 			=> $row['product_id'],
						'platform_id'			=> $row['platform_id'],
						'platform_name'			=> $row['platform_name'],
						'price'					=> $row['price'],
						'inventory'				=> $row['inventory']
		);	
	}
	//free the result for next query
	$result->free_result();
	
 
#################################################
####Connect for product to product image lookup
#################################################	

	//set up SQL query
	$sql = "SELECT * FROM product, image, product_image_lookup
			WHERE product_image_lookup.product_id = product.product_id
			AND product_image_lookup.image_id = image.image_id";
			
	//submit the query and capture the result
	$result = $conn->query($sql) or die(mysqli_error());
	
	//set up array to store the results of the query
	$images = array();
	
	while ($row = $result->fetch_assoc()) {
	//loop through the sql results and store them into images array
		
		$images[] = array(
						'product_id' 			=> $row['product_id'],
						'image_id'				=> $row['image_id'],
						'image_filename' 		=> $row['image_filename'],
						'image_title' 			=> $row['image_title'],
						'image_description'		=> $row['image_description']
		);	
	}
	//free the result for next query
	$result->free_result();


#################################################
####Connect for product to product genre lookup
#################################################	

	//set up SQL query
	$sql = "SELECT * FROM product, genre, product_genre_lookup
			WHERE product_genre_lookup.product_id = product.product_id
			AND product_genre_lookup.genre_id = genre.genre_id";
			
	//submit the query and capture the result
	$result = $conn->query($sql) or die(mysqli_error());
	
	//set up array to store the results of the query
	$genre = array();
	
	while ($row = $result->fetch_assoc()) {
	//loop through the sql results and store them into genre array
		
		$genre[] = array(
						'product_id' 			=> $row['product_id'],
						'genre_id'				=> $row['genre_id'],
						'genre_name' 			=> $row['genre_name']
		);	
	}
	//free the result for next query
	$result->free_result();
	
/* RELOCATE TO DETAILS PAGE
#################################################
####Connect for product to product players lookup
#################################################	

	//set up SQL query
	$sql = "SELECT * FROM product, players, product_players_lookup
			WHERE product_players_lookup.product_id = product.product_id
			AND product_players_lookup.players_id = players.players_id";
			
	//submit the query and capture the result
	$result = $conn->query($sql) or die(mysqli_error());
	
	//set up array to store the results of the query
	$players = array();
	
	while ($row = $result->fetch_assoc()) {
	//loop through the sql results and store them into players array
		
		$players[] = array(
						'product_id' 			=> $row['product_id'],
						'players_id'			=> $row['players_id'],
						'players_specified' 	=> $row['players_specified']
		);	
	}
	//free the result for next query
	$result->free_result();

*/

#################################################
####Pagination
#################################################
	$start_number = intval($_GET["start"]);
	$items_per_page = 3;
	$category_sales = null;
	
### start if $start_number
	if ($start_number >= 0) {
		
		//Count the items in the category.
		$sql = "SELECT count(*) 
				AS count FROM product_platform_lookup 
				WHERE product_platform_lookup.platform_id = 1";
				
		$result = $conn->query($sql) or die(mysqli_error());
		while($row = $result->fetch_assoc()) {
			$count = $row['count'];	
		}

#################################################
####Left Join for table information
#################################################	

	//set up SQL query
	$sql = "SELECT * FROM product
			LEFT JOIN esrb_rating 
			ON product.ESRB_id = esrb_rating.ESRB_rating_id
			LEFT JOIN image
			ON product.main_image_id = image.image_id
			LEFT JOIN product_platform_lookup
			ON product_platform_lookup.product_id = product.product_id
			WHERE product_platform_lookup.platform_id = 1
			LIMIT $start_number, $items_per_page";
			
	//submit the query and capture the result
	$result = $conn->query($sql) or die(mysqli_error());

###start if $result
?>
<div id="pagination">
<?php
	  if ($result->num_rows > 0) {
  
		  $navbar = create_navbar($start_number, $items_per_page, $count);
		  $category_sales .= "Data from SQL query";
		  if (is_null($category_sales)) {
		  echo "Invalid input.";	
	  } else {
		  echo "$navbar<br />";	
	  }
?>
</div>
<div id="infoConfirm">
<?php

//check if conf set, and printout if so, if not, do nothing - this prevents an "undeclared variable" error
						//confirmation message code unset after used so not displayed on other pages
						if (isset($conf_msg)) {
							echo '<p class="'. $class. '">'. $conf_msg . '</p>';
							unset($_SESSION['conf_msg']); //unsetting the session variable
							unset($conf_msg); //unsetting the page's variable
						}
?>
</div>
<div id="products">
<?php

			
#################################################
####Main Display All code
#################################################

		while ($row = $result->fetch_assoc()) {
		

		//Loop through and add your HTML display info
		//into $category_sales.
		
		//store current product ID for later use
		$product_id = $row['product_id'];
		//echo $currentProd_id;
		
		
			echo '<h2><a href="testingdetails.php?product_id=' . $row['product_id']. '"><span class="productTitleColor" id="productTitle">' . $row['title'] . '</span></a></h2>';
			echo '<img id="infoImage" src="images/' . $row['image_filename'] . '" />';
		
			/*
			//new count for images array
			$length = count($images);			
			 //insert images array data
				for ($row1 = 0; $row1 < $length; $row1++) {
				   //use current product id to find the right image for each product
					if ($currentProd_id == $images[$row1]['product_id']) {
						//echo '<h3>' . $product[$row]['title'] . '</h3>';
						if ( $images[$row1]['image_id'] != $row['main_image_id'] ) {
							echo '<img src="images/' . $images[$row1]['image_filename'] . '" height= "200" width="250" />';	
						}
						
					}	
				}*/
			//empty length array
			$length = array();
			echo '<br />'; 	 
			?>
            <div id="productInfo">
            	<ul id="productInfoList">
            <?php 
			//create an if statement to display release date only when not false
				if ($row['release_date'] != 0) {
				echo '<li><span class="infoBold">Release Date:</span>' . ' ' . $row['release_date'] . '</li>' ;
				}
		/*
			//count product array length
			$length = count($product);
			//display platform
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($currentProd_id == $product[$row1]['product_id']) {
					echo '<li><span class="infoBold">Platform:</span>' . ' ' . $product[$row1]['platform_name'] . '</li>' ;
					}
				}
			//empty length array		
			$length = array();
		*/
				
				
			//count genre array length
			$length = count($genre);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $genre[$row1]['product_id']) {
					echo '<li><span class="infoBold">Category:</span>' . ' ' . $genre[$row1]['genre_name'] . '</li>' ;
					}
				}
			//empty length array	
			$length = array();
			
			
			echo '<li><span class="infoBold">ESRB Rating:</span>' . ' ' . $row['ESRB_rating_name'] . '</li>' ;
			
		/*	
			//count product array length
			$length = count($product);
			//display price and inventory
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($currentProd_id == $product[$row1]['product_id']) {
					echo '<li><span class="infoBold">Price:</span>' . ' ' . $product[$row1]['price']  . '</li>';
					//echo '<strong>Inventory:</strong>' . ' ' . $product[$row1]['inventory'] ;
					}
				}
		*/
#####################################################
############Input Form
#####################################################
			
			if ($row) {
				
			echo '<form action="includes/addtocarttesting.php" method="post" name="addToCart">';
						
						$length_product = count($product);
						
							//loop through the results of the product
							echo '<ul id="infoSpecial">';
							for ($row2 = 0; $row2 < $length_product; $row2++) {
								if ($product_id == $product[$row2]['product_id']) {
  

									//here we check inventory levels
									if ($product[$row2]['inventory'] > 0) {
									  echo '<li><span class="infoBold">Platform:</span>' .  $product[$row2]['platform_name'] . '</li>';
									  
									  //needed to create this variable for inclusion in input HTML below.
									  $platform_id = $product[$row2]['platform_id'];
									  $price = $product[$row2]['price'];
									  
									  //building the form elements.  Create arrays for the product_id, platform_id, and quantity.
									  //regardless of how many products get shown on the page, the array index for each product/type/quantity will match.
									  //add hidden field with product id
									  echo "<input type=\"hidden\" name=\"product_id[$row2]\" value=\"$product_id \">";
									  
									  //add hidden field with type id
									  echo "<input type=\"hidden\" name=\"platform_id[$row2]\" value=\"$platform_id\">";
									  
									  //add hidden field with price
									  echo "<input type=\"hidden\" name=\"price[$row2]\" value=\"$price\">";
									  
									  //then add text field for the quantity
									  echo "<li><label><span class='infoBold'>Qty:</span></label><input type=\"text\" name=\"qty[$row2]\" size=\"3\" maxlength=\"3\" /></li>";
										
									  //display price
									  //use number_format to get proper formatting, and just add dollar sign in text string
									  //arguments are number to format, number of decimal points, separator for decimal point which in this 
									  //case is a period, and the separate for the thousands which in this case is a comma
									  echo "<li><label><span class='infoBold'>Price:</span> $" . number_format($price, 2, '.', ',') . "</label></li>";
									  	
									} else { //TO DO:  Thanks Megan:  if all the items are out of stock, then disable the Add to Cart button!
										echo "<li>". ucwords($product[$row2]['platform_name']). ": <em>We're currently out of stock of " . ucwords($product[$row2]['platform_name']) . "s.  Check back soon, we receive new stock every day!</em></li>";
										echo "<label>Qty:</label><input class=\"disabled\" name=\"outofstock\" type=\"text\" size=\"3\" maxlength=\"3\" value=\"N\A\" disabled/>";
									}
  
								}
							}
							echo '</ul>';
						echo '<input name="addToCart" type="submit" value="Add to Cart" />';
						echo '</form>';
						
						
	
						
					} else {
						
						echo "No such record found.";
						//TO DO - add code that randomly selects a product "We didn't find
						//the product you were looking for, but check this one out..."
					}
				
			
			
			//echo '<a href="#">Add To Cart</a>'; 
				
		
			//empty length array		
			$length = array();
				
			?>
            </ul>
            </div>
            <?php	
		}### end while loop
		
		//free the result for next query
		$result->free_result();
			
	}#### end of if $result
	 else {
			$category_sales = "There were no items in this category.";	
	}
	}### end of if $start_number	

	dbClose($conn);
?>
</div>

</div>
</body>
</html>
