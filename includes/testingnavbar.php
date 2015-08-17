<?php
 	//get the file name and set to $currentPage variable
	$currentPage = basename($_SERVER['SCRIPT_NAME']);
	
?>

<ul id="mainNav">
	<li><a href="testing.php" <?php if ($currentPage == 'testing.php') {echo 'id="here"';} ?>>Home</a></li>
    <li><a href="xbox360.php" <?php if ($currentPage == 'xbox360.php') {echo 'id="here"';} ?>>XBox360</a></li>
    <li><a href="ps3.php" <?php if ($currentPage == 'ps3.php') {echo 'id="here"';} ?>>PS3</a></li>
    <li><a href="wii.php" <?php if ($currentPage == 'wii.php') {echo 'id="here"';} ?>>WII</a></li>
    <li><a href="3ds.php" <?php if ($currentPage == '3ds.php') {echo 'id="here"';} ?>>3DS</a></li>
    <li><a href="psp.php" <?php if ($currentPage == 'psp.php') {echo 'id="here"';} ?>>PSP</a></li>
    <li><a href="testingviewcart.php" <?php if ($currentPage == 'testingviewcart.php') {echo 'id="here"';} ?>>View Cart</a></li>
    <li><a href="includes/testingunsetcart.php" <?php if ($currentPage == 'testingunsetcart.php') {echo 'id="here"';} ?>>Unset Cart</a></li>
</ul>
