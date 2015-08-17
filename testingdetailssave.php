<?php
 	session_start();
?>
<?php include("includes/functions.php"); ?>
<?php

		//check for the product_id on the query string
		if ( isset($_GET['product_id']) && is_numeric($_GET['product_id']) ) {
			
		//set the variable so it's easier to use later in script
		$product_id = $_GET['product_id']; //for troubleshooting
			
			//echo "product_id is $product_id <br>";
		} else {
			$product_id = 0;
			echo "No product id on the url.";
		}
		
		//check for confirmation message in the session, which will be set if products added to cart, add to a variable
		if ( isset($_SESSION['conf_msg']) ) {
		$conf_msg = $_SESSION['conf_msg'];
		$class = $_SESSION['class'];
		
		//echo $conf_msg; //FOR TROUBLESHOOTING
		}
		
		//connect to db
		$conn = dbConnect('query');
		
		//set up the SQL query
		$sql = "SELECT * FROM product, platform, product_platform_lookup
				WHERE product_platform_lookup.product_id = product.product_id
				AND product_platform_lookup.platform_id = platform.platform_id
				AND product_platform_lookup.product_id = $product_id";
		
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
		
/*		
		#################################################
		####Connect for product to product image lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, image, product_image_lookup
				WHERE product_image_lookup.product_id = product.product_id
				AND product_image_lookup.image_id = image.image_id
				AND product_image_lookup.product_id = $product_id";
				
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

*/
		#################################################
		####Connect for product to product genre lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, genre, product_genre_lookup
				WHERE product_genre_lookup.product_id = product.product_id
				AND product_genre_lookup.genre_id = genre.genre_id
				AND product_genre_lookup.product_id = $product_id";
				
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
	

		#################################################
		####Connect for product to product players lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, players, product_players_lookup
				WHERE product_players_lookup.product_id = product.product_id
				AND product_players_lookup.players_id = players.players_id
				AND product_players_lookup.product_id = $product_id";
				
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
		
		
		#################################################
		####Connect for product to product publisher lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, publisher, product_publisher_lookup
				WHERE product_publisher_lookup.product_id = product.product_id
				AND product_publisher_lookup.publisher_id = publisher.publisher_id
				AND product_publisher_lookup.product_id = $product_id";
				
		//submit the query and capture the result
		$result = $conn->query($sql) or die(mysqli_error());
		
		//set up array to store the results of the query
		$publisher = array();
		
		while ($row = $result->fetch_assoc()) {
		//loop through the sql results and store them into players array
			
			$publisher[] = array(
							'product_id' 			=> $row['product_id'],
							'publisher_id'			=> $row['publisher_id'],
							'publisher_name' 		=> $row['publisher_name']
			);	
		}
		//free the result for next query
		$result->free_result();

		
		#################################################
		####Connect for product to product developer lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, developer, product_developer_lookup
				WHERE product_developer_lookup.product_id = product.product_id
				AND product_developer_lookup.developer_id = developer.developer_id
				AND product_developer_lookup.product_id = $product_id";
				
		//submit the query and capture the result
		$result = $conn->query($sql) or die(mysqli_error());
		
		//set up array to store the results of the query
		$developer = array();
		
		while ($row = $result->fetch_assoc()) {
		//loop through the sql results and store them into players array
			
			$developer[] = array(
							'product_id' 			=> $row['product_id'],
							'developer_id'			=> $row['developer_id'],
							'developer_name' 		=> $row['developer_name']
			);	
		}
		//free the result for next query
		$result->free_result();
		
		#################################################
		####Connect for product to product review author lookup
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product, review, author, product_review_author_lookup
				WHERE product_review_author_lookup.product_id = product.product_id
				AND product_review_author_lookup.review_id = review.review_id
				AND product_review_author_lookup.author_id = author.author_id
				AND product_review_author_lookup.product_id = $product_id";
				
		//submit the query and capture the result
		$result = $conn->query($sql) or die(mysqli_error());
		
		//set up array to store the results of the query
		$review = array();
		
		while ($row = $result->fetch_assoc()) {
		//loop through the sql results and store them into players array
			
			$review[] = array(
							'product_id' 			=> $row['product_id'],
							'review_id'				=> $row['review_id'],
							'review_title' 			=> $row['review_title'],
							'review_body'			=> $row['review_body'],
							'author_id'				=> $row['author_id'],
							'author_name'			=> $row['author_name'],
			);	
		}
		//free the result for next query
		$result->free_result();
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Game Hunter -- Details</title>
</head>

<body>
<?php include("includes/testingnavbar.php"); ?>
<?php
		#################################################
		####Left Join for table information
		#################################################	

		//set up SQL query
		$sql = "SELECT * FROM product
				LEFT JOIN esrb_rating 
				ON product.ESRB_id = esrb_rating.ESRB_rating_id
				LEFT JOIN image
				ON product.main_image_id = image.image_id
				WHERE product.product_id = $product_id";
				
		//submit the query and capture the result
		$result = $conn->query($sql) or die(mysqli_error());

		while ($row = $result->fetch_assoc()) {
		
			echo '<h2><a href="testingdetails.php?product_id=' . $row['product_id']. '">' . $row['title'] . '</a></h2>';
			echo '<img src="images/' . $row['image_filename'] . '" />';
		
/*
			//new count for images array
			$length = count($images);			
			 //insert images array data
				for ($row1 = 0; $row1 < $length; $row1++) {
				   //use current product id to find the right image for each product
					if ($product_id == $images[$row1]['product_id']) {
						//echo '<h3>' . $product[$row]['title'] . '</h3>';
						if ( $images[$row1]['image_id'] != $row['main_image_id'] ) {
							echo '<img src="images/' . $images[$row1]['image_filename'] . '" height= "200" width="250" />';	
						}
						
					}	
				}
			//empty length array
			$length = array();
*/
			echo '<br />'; 	  
			//create an if statement to display release date only when not false
				if ($row['release_date'] != 0) {
				echo '<strong>Release Date:</strong>' . ' ' . $row['release_date'];
				}
		
			//count product array length
			$length = count($product);
			//display platform
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $product[$row1]['product_id']) {
					echo '<strong>Platform:</strong>' . ' ' . $product[$row1]['platform_name'] ;
					}
				}
			//empty length array		
			$length = array();
				
				
				
			//count genre array length
			$length = count($genre);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $genre[$row1]['product_id']) {
					echo '<strong>Category:</strong>' . ' ' . $genre[$row1]['genre_name'] ;
					}
				}
			//empty length array	
			$length = array();
			
			
			echo '<strong>ESRB Rating:</strong>' . ' ' . $row['ESRB_rating_name'] ;
			
			//count players array length
			$length = count($players);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $players[$row1]['product_id']) {
					echo '<strong>Number of players:</strong>' . ' ' . $players[$row1]['players_specified'] ;
					}
				}
			//empty length array	
			$length = array();
			
			
			//count publisher array length
			$length = count($publisher);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $publisher[$row1]['product_id']) {
					echo '<strong>Publisher:</strong>' . ' ' . $publisher[$row1]['publisher_name'] ;
					}
				}
			//empty length array	
			$length = array();
			
			
			//count developer array length
			$length = count($developer);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $developer[$row1]['product_id']) {
					echo '<strong>Developer:</strong>' . ' ' . $developer[$row1]['developer_name'] ;
					}
				}
			//empty length array	
			$length = array();
			
			
			//count product array length
			$length = count($product);
			//display price and inventory
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($product_id == $product[$row1]['product_id']) {
					echo '<strong>Price:</strong>' . ' ' . $product[$row1]['price'] ;
					echo '<strong>Inventory:</strong>' . ' ' . $product[$row1]['inventory'] ;
					}
				}
			//empty length array		
			$length = array();
			echo '</ br></ br>';
			
			//NEW Week 7
						//check if conf set, and printout if so, if not, do nothing - this prevents an "undeclared variable" error
						//confirmation message code unset after used so not displayed on other pages
						if (isset($conf_msg)) {
							echo '<p class="'. $class. '">'. $conf_msg . '</p>';
							unset($_SESSION['conf_msg']); //unsetting the session variable
							unset($conf_msg); //unsetting the page's variable
						}
#####################################################
############Input Form
#####################################################
			
			if ($row) {
				
			echo '<form action="includes/addtocarttesting.php" method="post" name="addToCart">';
						
						$length_product = count($product);
						
							//loop through the results of the product
							echo '<ul>';
							for ($row2 = 0; $row2 < $length_product; $row2++) {
								if ($product_id == $product[$row2]['product_id']) {
  

									//here we check inventory levels
									if ($product[$row2]['inventory'] > 0) {
									  echo '<li>' .  $product[$row2]['platform_name'] . '</li>';
									  
									  //needed to create this variable for inclusion in input HTML below.
									  $platform_id = $product[$row2]['platform_id'];
									  $price = $product[$row2]['price'];
									  
									  //building the form elements.  Create arrays for the product_id, platform_id, and quantity.
									  //regardless of how many products get shown on the page, the array index for each product/type/quantity will match.
									  //add hidden field with product id
									  echo "<input type=\"hidden\" name=\"product_id[$row2]\" value=\"$product_id\">";
									  
									  //add hidden field with type id
									  echo "<input type=\"hidden\" name=\"platform_id[$row2]\" value=\"$platform_id\">";
									  
									  //add hidden field with price
									  echo "<input type=\"hidden\" name=\"price[$row2]\" value=\"$price\">";
									  
									  //then add text field for the quantity
									  echo "<label>Qty:</label><input type=\"text\" name=\"qty[$row2]\" size=\"3\" maxlength=\"3\" />";
										
									  //display price
									  //use number_format to get proper formatting, and just add dollar sign in text string
									  //arguments are number to format, number of decimal points, separator for decimal point which in this 
									  //case is a period, and the separate for the thousands which in this case is a comma
									  echo "<label>Price: $" . number_format($price, 2, '.', ',') . "</label>";
									  	
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
				
		}
		
#####################################
#######Image Gallery
####################################
		//sql code to get the total records of images
		$getTotal = "SELECT COUNT(*) FROM product, image, product_image_lookup 
					 WHERE product_image_lookup.product_id = product.product_id 
					 AND product_image_lookup.image_id = image.image_id
					 AND product_image_lookup.product_id = $product_id ";
		
		//submit query and store the result as $totalPix
		$total = $conn->query($getTotal);
		$row = $total->fetch_row();
		$totalPix = $row[0];
		//free the result for next query
		//$result->free_result();
		//set the current page
		if (isset($_GET['curPage'])) {
			$curPage = $_GET['curPage'];	
		} else {
			$curPage = 0;
		}	
	
		//calculate the start row of the subset
		$startRow = $curPage * SHOWMAX;
		
		
		//create SQL - retrieve a subset of image details
		
		$sql = "SELECT *
				FROM product, image, product_image_lookup 
				WHERE product_image_lookup.product_id = product.product_id 
				AND product_image_lookup.image_id = image.image_id
				AND product_image_lookup.product_id = $product_id
				LIMIT $startRow,".SHOWMAX; //constants are not processed inside strings, so it is concatenated outside of the quotes
				
		//submit the SQL query to the database and get the result
		$result = $conn->query($sql) or die(mysqli_error());
		
		//get records as an array
		$row = $result->fetch_assoc();
		
		//get name and caption for main image
		if (isset($_GET['image_filename'])) {
			$mainImage = $_GET['image_filename'];	
		} else {
			$mainImage = $row['image_filename'];	
		}
		
		//get dimension of image
		$imageSize = getimagesize('images/' . $mainImage);
		?>
		<p>Displaying
   		<?php
        	echo $startRow + 1;
			if ($startRow + 1 < $totalPix) {
				echo ' to ';
					if ($startRow+SHOWMAX < $totalPix) {
						echo $startRow+SHOWMAX;	
					} else {
						echo $totalPix;	
					}
			}
			echo " of $totalPix.";
		
		?></p>
        
        <p> <!-- navigation through pages of gallery here as needed-->
        
        <?php

			//create a back link of the current page is greater than 0
				if ($curPage > 0) {//build the query string on the link 
					echo '<a href="' . $_SERVER['PHP_SELF'] . '?product_id=' . $product_id . '&amp;curPage=' . ($curPage-1) . '"> &lt; Previous</a>'; //note use of single quotes
					//to allow for the double quotes we need around the HTML attributes
				} else { //don't create a previous link
					//do nothing
				}
		
		?>
        
        <?php
			//create a forward link if more records exist
			if ($startRow+SHOWMAX < $totalPix) {//build the query strong on the link
				echo '<a href="' . $_SERVER['PHP_SELF'] . '?product_id=' . $product_id . '&amp;curPage=' . ($curPage+1) . '"> Next &gt;</a>';
			} else { //don't create a next link
				//do nothing
			}

		?>
        
     
        </p>
        
        <div id="gal_thumbs">
        <?php 
			//begin the loop that display the thumbnails
				do{
					if ($row['image_filename'] == $mainImage) {
						$caption = $row['image_description'];	
					}
				
				
		?>
        
        		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?image_filename=<?php echo $row['image_filename']; ?>&amp;curPage=<?php echo $curPage; ?>&amp;product_id=<?php echo $product_id; ?>#gal_image">
                <img src="images/thumbs/<?php echo 'thumb_' . $row['image_filename']; ?>" alt="<?php echo $row['image_description']; ?>" width="100" height="100"/> </a>
                <?php
					$row = $result->fetch_assoc();
					} while ($row);
					
			//end of the loop that displays the thumbnails
				?>
        
        </div><!-- end of gal_thumbs -->
        
        <div id="gal_image">
        	<img src="images/<?php echo $mainImage; ?>" alt="<?php echo $caption; ?>" class="gal_img" <?php echo $imageSize[3]; ?>/>
            <p><?php if ($caption != "NULL") { echo $caption; }?></p>
        </div><!-- end of gal_image"-->
 <?php       
		//free the result for next query
		$result->free_result();
		
		echo '<br />';
		//TO-DO ADD more games to categories THEN fix Related Games to order by categories rather than random?>
       <h2> Related Games </h2>
	<?php featuredGames(3); ?>
</body>
</html>

<?php
	dbClose($conn);
?>