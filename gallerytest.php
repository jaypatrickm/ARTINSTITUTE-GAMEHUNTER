<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/functions.php"); ?>
<?php
	//start of image gallery 
	
	//connect to db
	$conn = dbConnect('query');
	
	//sql code to get the total records of images
	$getTotal = "SELECT COUNT(*) FROM product, image, product_image_lookup 
				 WHERE product_image_lookup.product_id = product.product_id 
				 AND product_image_lookup.image_id = image.image_id
				 AND product_image_lookup.product_id = 1 ";
	
	//submit query and store the result as $totalPix
	$total = $conn->query($getTotal);
	$row = $total->fetch_row();
	$totalPix = $row[0];
	
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
		    AND product_image_lookup.product_id = 1
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

</head>

<body>

<div class="container">
  <div class="content">
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
					echo '<a href="' . $_SERVER['PHP_SELF'] . '?curPage=' . ($curPage-1) . '"> &lt; Previous</a>'; //note use of single quotes
					//to allow for the double quotes we need around the HTML attributes
				} else { //don't create a previous link
					//do nothing
				}
		
		?>
        
        <?php
			//create a forward link if more records exist
			if ($startRow+SHOWMAX < $totalPix) {//build the query strong on the link
				echo '<a href="' . $_SERVER['PHP_SELF'] . '?curPage=' . ($curPage+1) . '"> Next &gt;</a>';
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
        
        		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?image_filename=<?php echo $row['image_filename']; ?>&amp;curPage=<?php echo $curPage; ?>">
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
        
    <!-- end .content --></div>
 
  <!-- end .container --></div>
</body>
</html>
