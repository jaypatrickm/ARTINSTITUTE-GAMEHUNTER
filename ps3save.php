<?php include("includes/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	//call the setSectionName function and assign it to $sectionName for use throughout the page
	$sectionName = setSectionName();
?>
<style type="text/css">
<!-- 
#navBar a {
background:#FFF;
}
#here {
background:#9FF;
}
-->
</style>

<title>Game Hunter -- <?php echo $sectionName;?></title>
</head>

<body>
<div id="content">

   
      <?php include("includes/testingnavbar.php"); ?>
  
        <h1> <?php echo $sectionName;?></h1>
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
			AND product_platform_lookup.platform_id = 2";
	
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
				WHERE product_platform_lookup.platform_id = 2";
				
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
			WHERE product_platform_lookup.platform_id = 2
			LIMIT $start_number, $items_per_page";
			
	//submit the query and capture the result
	$result = $conn->query($sql) or die(mysqli_error());

###start if $result
	  if ($result->num_rows > 0) {
  
		  $navbar = create_navbar($start_number, $items_per_page, $count);
		  $category_sales .= "Data from SQL query";
		  if (is_null($category_sales)) {
		  echo "Invalid input.";	
	  } else {
		  echo "$navbar<br />";	
	  }
	  
#################################################
####Main Display All code
#################################################

		while ($row = $result->fetch_assoc()) {
		

		//Loop through and add your HTML display info
		//into $category_sales.
		
		//store current product ID for later use
		$currentProd_id = $row['product_id'];
		//echo $currentProd_id;
		
		
			echo '<h2><a href="testingdetails.php?product_id=' . $row['product_id']. '">' . $row['title'] . '</a></h2>';
			echo '<img src="images/' . $row['image_filename'] . '" />';
		
			
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
				}
			//empty length array
			$length = array();
			echo '<br />'; 	  
			//create an if statement to display release date only when not false
				if ($row['release_date'] != 0) {
				echo '<strong>Release Date:</strong>' . ' ' . $row['release_date'];
				}
		
			//count product array length
			$length = count($product);
			//display platform
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($currentProd_id == $product[$row1]['product_id']) {
					echo '<strong>Platform:</strong>' . ' ' . $product[$row1]['platform_name'] ;
					}
				}
			//empty length array		
			$length = array();
				
				
				
			//count genre array length
			$length = count($genre);
			//display category
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($currentProd_id == $genre[$row1]['product_id']) {
					echo '<strong>Category:</strong>' . ' ' . $genre[$row1]['genre_name'] ;
					}
				}
			//empty length array	
			$length = array();
			
			
			echo '<strong>ESRB Rating:</strong>' . ' ' . $row['ESRB_rating_name'] ;
			
			
			//count product array length
			$length = count($product);
			//display price and inventory
				for ($row1 = 0; $row1 < $length; $row1++) {
					if ($currentProd_id == $product[$row1]['product_id']) {
					echo '<strong>Price:</strong>' . ' ' . $product[$row1]['price'] ;
					//echo '<strong>Inventory:</strong>' . ' ' . $product[$row1]['inventory'] ;
					}
				}
			
			echo '<a href="#">Add To Cart</a>'; 
			//empty length array		
			$length = array();
				
				
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
</body>
</html>
