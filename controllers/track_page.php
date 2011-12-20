<?php

	require_once 'simple_html_dom.php';
	require_once 'dblib.php';

	function track_page()
	{
		if(isset($_GET['url']))
		{
			$url = $_GET['url'];
			$scraped_product_page = '';
		
			try {
				//set up curl for screen-scraping
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$scraped_product_page = curl_exec($ch);
				curl_close($ch);
			} catch (Exception $e) {
				$response = array('hasError' => true, 'response' => $e->getMessage());
				echo json_encode($response);
			}
	
			//We need to find the product name, upc and price of product
			//Regexs will be conditional based on what website we are in
			//For Hackathon purposes, this will only work for target.com
		
			$priceRegex = '/(\$[0-9,]+(\.[0-9]{2})?)/';
			$prodNameRegex = "#<title[^>]*>(.*?)</title>#i";
			
			//Get the title of the page
			$title = preg_match_all($prodNameRegex,$scraped_product_page,$regs);
			$prodName = $regs[1][0];
			
			//Get the prices
			preg_match($priceRegex, $scraped_product_page, $matches);

			//Assume that the first price is the match
			$price = substr($matches[0], 1);
			
			//This is too slow!
			$html = new simple_html_dom();
			$html->load($scraped_product_page);
			$upcDiv = $html->find("div#upc");
			$upcNum = $upcDiv[0]->plaintext;
			
			if(isset($upcNum) && isset($price) && isset($prodName) && isset($url))
			{
				$searchQuery = "SELECT * from wishlist where upc=" . $upcNum;
				$db = getDB();
				$result = $db->query($searchQuery);
				$rows = mysqli_num_rows($result);
				if(!empty($rows))
				{
					$response = array('hasError' => true, 'response' => 'Record already in the database');
					echo json_encode($response);
				}
				else
				{
					$insertQuery = "INSERT into wishlist (upc, price, product_name, url, date_time) VALUES (" . $upcNum . ", " . $price . ", '" . $prodName . "', '" . $url . "', NOW());";
					$db->query($insertQuery);
					$response = array('hasError' => false, 'response' => 'Insertion completed');
					echo json_encode($response);
				}
			}
			else
			{
				$response = array('hasError' => true, 'response' => 'Missing fields in screen scrape');
				echo json_encode($response);
			}
		}
		else
		{
			$response = array('hasError' => true, 'response' => 'URL is not passed into the API');
			echo json_encode($response);
		}
	}

?>

