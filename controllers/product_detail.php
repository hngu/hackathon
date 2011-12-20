<?php

require_once "dblib.php";
function product_detail()
{
	//Dummy
	$prodUPC = "dell"; 
	
	$db = getDB();
	$upc = isset($_GET['upc']) ? $_GET['upc'] : null;
	$rows = '';
	$price = '';
	$url = '';
	$name = '';
	
	if(empty($upc))
	{
		include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'error_page.php';
	}
	else
	{
		$searchQuery = "SELECT * from wishlist where upc=" . $upc . " LIMIT 1";
		$result = $db->query($searchQuery) or die(mysql_error());
		//$rows = mysqli_num_rows($result);
		if(empty($result))
		{
			include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'error_page.php';
		}
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
				$price = $row['price'];
				$url = $row['url'];
				$name = $row['product_name'];
			include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'product_detail.php';
		}
	}
}

