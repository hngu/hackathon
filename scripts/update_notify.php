<?php

	$username = 'root';
	$host = 'localhost';
	$password = 'DyFroaHylt1';
	$database = 'hackathon';
	
	$db = new mysqli($host, $username, $password, $database);
	
	if (!$db) {
		die('Cannot connect to the database: ' . mysql_error());
	}
	
	$searchQuery = "SELECT * from wishlist";
	$row=''; $price=''; $url = '';
	$result = $db->query($searchQuery) or die(mysql_error());
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$price = $row['price'];
		$url = $row['url'];
		$upc = $row['upc'];
		
		try {
				//set up curl for screen-scraping
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$scraped_product_page = curl_exec($ch);
				curl_close($ch);
			} catch (Exception $e) {
				mail("huy.ngu@freecause.com", "Error running update_notify", $e->getMessage());
			}
		
		$priceRegex = '/(\$[0-9,]+(\.[0-9]{2})?)/';
		
		//Get the prices
		preg_match($priceRegex, $scraped_product_page, $matches);

		//Assume that the first price is the match
		$Curr_price = substr($matches[0], 1);
		
		if($Curr_price < $price)
		{
			mail("huy.ngu@freecause.com", "Price change!", "Price change at: $url for only $Curr_price");
			$updateQuery = "UPDATE wishlist SET price=" . $Curr_price . ", date_time=NOW() WHERE upc=" . $upc;
			//echo $updateQuery;
			$insertUpdate = $db->query($updateQuery) or die(mysql_error());
		}
	}
?>