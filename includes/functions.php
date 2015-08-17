<?php

### Jay Manalansan
### Game Hunter Functions
###

##################################################################
### Connector Function
##################################################################

function dbConnect($type) {
  if ($type  == 'query') {
	$user = 'ghquery';
	$pwd = 'g4m35';
  } elseif ($type == 'admin') {
	$user = 'ghadmin';
	$pwd = 'g4m35';
  } else {
	exit('Unrecognized connection type');
  }
  $conn = new mysqli('localhost', $user, $pwd, 'game_hunter') or die ('Cannot open databse');
  return $conn;
}

##################################################################
### Pagination Function
##################################################################

function create_navbar($start_number = 0, $items_per_page = 50, $count) {
		// Creates a navigation bar
		$current_page = $_SERVER["PHP_SELF"];
		
		if (($start_number < 0 ) || (! is_numeric($start_number))) {
			$start_number = 0;	
		}
		
		$navbar = "";
		$prev_navbar = "";
		$next_navbar = "";
		
		if ($count > $items_per_page) {
			$nav_count = 0;
			$page_count = 1;
			$nav_passed = false;
			
			while ($nav_count < $count) {
				//Are we at the current page position?
				if (($start_number <= $nav_count) && ($nav_passed != true)) {
					$navbar .= "<b><a href=\"$current_page?start=$nav_count\">[$page_count] </a></b>";
					$nav_passed = true;
					//Do we need a "prev" button?
					if ($start_number != 0) {
						$prevnumber = $nav_count - $items_per_page;
						if ($prevnumber < 1) {
							$prevnumber = 0;	
						}
						$prev_navbar = "<a href=\"$current_page?start=$prevnumber\">&lt;&lt;Prev - </a>";
					}
					
					$nextnumber = $items_per_page + $nav_count;
					
					//Do we need a "next" button?
					if ($nextnumber < $count) {
						$next_navbar = "<a href=\"$current_page?start=$nextnumber\"> - Next&gt;&gt; </a><br>";
					}
				} else {
					//Print Normally.
					$navbar .= "<a href=\"$current_page?start=$nav_count\">[$page_count]</a>";	
				}
				
				$nav_count += $items_per_page;
				$page_count++;
			}
			
			$navbar = $prev_navbar . $navbar . $next_navbar;
			return $navbar;
		}
		
	}

##################################################################
#Function to set the section name for use in page title, header, and elsewhere in page.
#Date:  4-26-09
#Version: 1.0
##################################################################

function setSectionName() {
	//determine current page
	/*the built-in function basename() takes the pathname of a file and extracts the filename.  $_SERVER['SCRIPT_NAME'] comes 
	from one of PHP's built-in superglobal arrays, and always give the absolute (site root-relative) pathname for the current page. */
	$currentPage = basename($_SERVER['SCRIPT_NAME']);
	
	//set page name based on $currentPage
	//we will use this to set section name in header of each page, and elsewhere
	
	switch ($currentPage) {
		case "products.php":
			return "Home";
			break;
		case "xbox360.php":
			return "XBox360";
			break;
		case "ps3.php":
			return "Playstation 3";
			break;
		case "wii.php":
			return "Nintendo WII";
			break;
		case "3ds.php":
			return "Nintendo 3DS";
			break;
		case "psp.php":
			return "Playstation Portable";
			break;
		case "testingviewcart.php":
			return "View Cart -- Test";
			break;
		default:
			return ""; //set the variable to an empty string to prevent the wrong section name
	}
}
/*to call this function in a page, create a variable that will be assigned the return value of the function.  for example,
call the function like this:  $mySectionName = setSectionName();   You can then use $mySectionName throughout the page. */


##for images

define('SHOWMAX', 3);

##################################################################
#Function to select random featured products based on # passed
#Date:  2-15-10
#Version: 1.0
##################################################################
#### TO DO FIX THIS FEATURE FROM RANDOM TO RELATED CATEGORIES
function featuredGames($number=1) { //$number passed in call, indicates how many to get
	
			//connect to db
			$conn = dbConnect('query');
			
			//get product info from  product and image tables
						   
			$sqlRandom = "SELECT * FROM product
						  LEFT JOIN image
						  ON image.image_id = product.main_image_id
						  ORDER BY RAND()
						  LIMIT $number";

			//submit the SQL query to the database and get the result
			$result = $conn->query($sqlRandom) or die(mysqli_error());	

			//loop through and display categories
			while ($row = $result->fetch_assoc()) {
				//loop through the results of the product query and display product info.
				//Plus build the link dynamically to a detail page
				echo '<ul class="feature">';
				echo '<li><a href="testingdetails.php?product_id='.$row['product_id'] .' "> ' . $row['title'] . '</a><br/>';
				echo '<a href="testingdetails.php?product_id='.$row['product_id'] .' "><img  border="0" src="images/' . $row['image_filename'] .'" /></a></li>';
				echo '</ul>';
			}
			
			$result->free_result();
			dbClose($conn); 
			
}

##################################################################
#Function for footer copyright notice
#Date:  4-26-09
#Version:  1.0
##################################################################

function setCopyright($startYear) {
			ini_set('date.timezone', 'America/Los_Angeles');
			$thisYear = date('Y');
			
			if ($startYear == $thisYear) {
				echo $startYear;
			} else {
				echo "$startYear - $thisYear";
			}
}


##################################################################
#Function to close the db
##################################################################

function dbClose($conn) {
	mysqli_close($conn);	
}

##################################################################
#Function that strips out backslashes for security
#Written by David Powers, and included in the codebase for "PHP Solutions: Dynamic Web Design Made Easy"
##################################################################

function nukeMagicQuotes() {
  if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value) {
      $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
      return $value;
      }
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    }
  }
  
################################################################
###Redirect to last page
#################################################################
 
// SET REFERRER
			
	function strleft($s1, $s2) { 
		return substr($s1, 0, strpos($s1, $s2));
	}   
			  
	function selfURL() { 
		if(!isset($_SERVER['REQUEST_URI'])) { 
		   $serverrequri = $_SERVER['PHP_SELF']; 
		}
		else { 
		   $serverrequri = $_SERVER['REQUEST_URI']; 
		} 
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
		$_SESSION['ref'] = $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri; 
	}				



?>