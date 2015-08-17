<?php
 	//get the file name and set to $currentPage variable
	$currentPage = basename($_SERVER['SCRIPT_NAME']);
	
?>

<ul id="mainNav">
	<li id="allNav"><a href="all.php?start=0" <?php if ($currentPage == 'testing.php') {echo 'id="here"';} ?>>ALL</a></li>
    <li id="xbox360Nav"><a href="javascript: void(0)" <?php if ($currentPage == 'xbox360.php') {echo 'id="here"';} ?>>XBOX 360</a></li>
    <li id="ps3Nav"><a href="javascript: void(0)" <?php if ($currentPage == 'ps3.php') {echo 'id="here"';} ?>>PS3</a></li>
    <li id="wiiNav"><a href="javascript: void(0)" <?php if ($currentPage == 'wii.php') {echo 'id="here"';} ?>>Wii</a></li>
    <li id="dsNav"><a href="javascript: void(0)" <?php if ($currentPage == '3ds.php') {echo 'id="here"';} ?>>3DS</a></li>
    <li id="psvitaNav"><a href="javascript: void(0)" <?php if ($currentPage == 'psvita.php') {echo 'id="here"';} ?>>PS Vita</a></li>
</ul>
<!--
	<li><a href="all.php?start=0" <?php if ($currentPage == 'testing.php') {echo 'id="here"';} ?>><span id="allNav">ALL</span></a></li>
    <li><a href="xbox360.php?start=0" <?php if ($currentPage == 'xbox360.php') {echo 'id="here"';} ?>><span id="xbox360Nav">XBOX 360</span></a></li>
    <li><a href="ps3.php?start=0" <?php if ($currentPage == 'ps3.php') {echo 'id="here"';} ?>><span id="ps3Nav">PS3</span></a></li>
    <li><a href="wii.php?start=0" <?php if ($currentPage == 'wii.php') {echo 'id="here"';} ?>><span id="wiiNav">Wii</span></a></li>
    <li><a href="3ds.php?start=0" <?php if ($currentPage == '3ds.php') {echo 'id="here"';} ?>><span id="dsNav">3DS</span></a></li>
    <li><a href="psvita.php?start=0" <?php if ($currentPage == 'psvita.php') {echo 'id="here"';} ?>><span id="psvitaNav">PS Vita</span></a></li>
-->  
    <div id="searchBar">
            <form id="search">
            <input name="search" type="text" placeholder="Search for your game!" size="30" autofocus="autofocus" />
            <div id="search_btn">
            	<input class="search_btn" name="search" src="sources/btn_search.png" type="image" value="Search" />
            </div>
            </form>
        </div>
<div class="subNav" class="subNavTextXbox">
    <ul class="subNavText">
    		<li><a href="Xbox.php?platform_id=1">All</a></li>
            <li><a href="Xbox.php?platform_id=2">Best Sellers</a></li>
            <li><a href="Xbox.php?platform_id=2">Action</a></li>
            <li><a href="Xbox.php?platform_id=2">Adventure</a></li>
            <li><a href="Xbox.php?platform_id=2">Casual</a></li>
            <li><a href="Xbox.php?platform_id=2">Fighting</a></li>
            <li><a href="Xbox.php?platform_id=2">Music & Party</a></li>
            <li><a href="Xbox.php?platform_id=2">Puzzle</a></li>
            <li><a href="Xbox.php?platform_id=2">Role-Playing</a></li>
            <li><a href="Xbox.php?platform_id=2">Shooter</a></li>
            <li><a href="Xbox.php?platform_id=2">Simulation</a></li>
            <li><a href="Xbox.php?platform_id=2">Sports</a></li>
            <li><a href="Xbox.php?platform_id=2">Strategy</a></li>
    </ul>
</div>

<div class="subNav2" class="subNavTextPs3" >
    <ul class="subNavText">
    		<li><a href="PS3.php?genre_id=1">All</a></li>
            <li><a href="PS3.php?genre_id=1">Best Sellers</a></li>
            <li><a href="PS3.php?genre_id=1">Action</a></li>
            <li><a href="PS3.php?genre_id=1">Adventure</a></li>
            <li><a href="PS3.php?genre_id=1">Casual</a></li>
            <li><a href="PS3.php?genre_id=1">Fighting</a></li>
            <li><a href="PS3.php?genre_id=1">Music & Party</a></li>
            <li><a href="PS3.php?genre_id=1">Puzzle</a></li>
            <li><a href="PS3.php?genre_id=1">Role-Playing</a></li>
            <li><a href="PS3.php?genre_id=1">Shooter</a></li>
            <li><a href="PS3.php?genre_id=1">Simulation</a></li>
            <li><a href="PS3.php?genre_id=1">Sports</a></li>
            <li><a href="PS3.php?genre_id=1">Strategy</a></li>
    </ul>
</div>  

<div class="subNav3" class="subNavTextWii" >
    <ul class="subNavText">
    		<li><a href="Wii.php?genre_id=1">All</a></li>
            <li><a href="Wii.php?genre_id=1">Best Sellers</a></li>
            <li><a href="Wii.php?genre_id=1">Action</a></li>
            <li><a href="Wii.php?genre_id=1">Adventure</a></li>
            <li><a href="Wii.php?genre_id=1">Casual</a></li>
            <li><a href="Wii.php?genre_id=1">Fighting</a></li>
            <li><a href="Wii.php?genre_id=1">Music & Party</a></li>
            <li><a href="Wii.php?genre_id=1">Puzzle</a></li>
            <li><a href="Wii.php?genre_id=1">Role-Playing</a></li>
            <li><a href="Wii.php?genre_id=1">Shooter</a></li>
            <li><a href="Wii.php?genre_id=1">Simulation</a></li>
            <li><a href="Wii.php?genre_id=1">Sports</a></li>
            <li><a href="Wii.php?genre_id=1">Strategy</a></li>
    </ul>
</div>  

<div class="subNav4" class="subNavText3DS" >
    <ul class="subNavText">
    		<li><a href="3DS.php?genre_id=1">All</a></li>
            <li><a href="3DS.php?genre_id=1">Best Sellers</a></li>
            <li><a href="3DS.php?genre_id=1">Action</a></li>
            <li><a href="3DS.php?genre_id=1">Adventure</a></li>
            <li><a href="3DS.php?genre_id=1">Casual</a></li>
            <li><a href="3DS.php?genre_id=1">Fighting</a></li>
            <li><a href="3DS.php?genre_id=1">Music & Party</a></li>
            <li><a href="3DS.php?genre_id=1">Puzzle</a></li>
            <li><a href="3DS.php?genre_id=1">Role-Playing</a></li>
            <li><a href="3DS.php?genre_id=1">Shooter</a></li>
            <li><a href="3DS.php?genre_id=1">Simulation</a></li>
            <li><a href="3DS.php?genre_id=1">Sports</a></li>
            <li><a href="3DS.php?genre_id=1">Strategy</a></li>
    </ul>
</div>  

<div class="subNav5" class="subNavTextPSVita" >
    <ul class="subNavText">
    		<li><a href="PSVita.php?genre_id=1">All</a></li>
            <li><a href="PSVita.php?genre_id=1">Best Sellers</a></li>
            <li><a href="PSVita.php?genre_id=1">Action</a></li>
            <li><a href="PSVita.php?genre_id=1">Adventure</a></li>
            <li><a href="PSVita.php?genre_id=1">Casual</a></li>
            <li><a href="PSVita.php?genre_id=1">Fighting</a></li>
            <li><a href="PSVita.php?genre_id=1">Music & Party</a></li>
            <li><a href="PSVita.php?genre_id=1">Puzzle</a></li>
            <li><a href="PSVita.php?genre_id=1">Role-Playing</a></li>
            <li><a href="PSVita.php?genre_id=1">Shooter</a></li>
            <li><a href="PSVita.php?genre_id=1">Simulation</a></li>
            <li><a href="PSVita.php?genre_id=1">Sports</a></li>
            <li><a href="PSVita.php?genre_id=1">Strategy</a></li>
    </ul>
</div>  