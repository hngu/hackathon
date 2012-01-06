<?php
        ini_set("memory_limit","128M");
        require_once '../lib/simple_html_dom.php';
        
	
	
	$db = new mysqli($host, $username, $password, $database);
	
	if (!$db) 
        {
		die('Cannot connect to the database: ' . mysql_error());
	}
	
	$searchQuery = "SELECT id, url, price from wishlist";
        $row = ''; $url= ''; $price = ''; $id = '';
	$result = $db->query($searchQuery) or die(mysql_error());
        $html = new simple_html_dom();
        
        while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
                $price = $row['price'];
		$url = $row['url'];
		$id = $row['id'];
                $scraped_product_page = '';
                $priceChange = false;
		
		try 
                {
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
                        $scraped_product_page = curl_exec($ch);
                        curl_close($ch);
		} 
                catch (Exception $e)
                {
                        mail("huy.ngu@freecause.com", "Error running update_notify", $e->getMessage());
                        continue;
                }
		
                $parsed_url = parse_url($url);
                $domain = $parsed_url['host'];
                $html->load($scraped_product_page);
                
                if($domain == 'www.bestbuy.com')
                {
                        $priceElement = $html->find("div#saleprice span.price");
			$curr_price = $priceElement[0]->plaintext;
                        $curr_price = substr(trim($curr_price), 1);
                        
                        if(!empty($curr_price))
                        {
                            echo $curr_price . "\n";
                        }
                }
                
                else if($domain == 'www.amazon.com')
                {
                        $priceElement = $html->find("div#priceBlock b.priceLarge");
			$curr_price = $priceElement[0]->plaintext;
                        $curr_price = substr(trim($curr_price), 1);
                        
                        if(!empty($curr_price))
                        {
                            echo $curr_price . "\n";
                        }
                }
                
                else if($domain == 'www.walmart.com')
                {
                        $priceElement = $html->find("div#priceBlock b.priceLarge");
			$curr_price = $priceElement[0]->plaintext;
                        $curr_price = substr(trim($curr_price), 1);
                        
                        if(!empty($curr_price))
                        {
                            echo $curr_price . "\n";
                        }
                }
                else if($domain == 'www.target.com')
                {
                        $priceElement = $html->find("div#price_main p.price");
			$curr_price = $priceElement[0]->plaintext;
                        $curr_price = substr(trim($curr_price), 1);
                        
                        if(!empty($curr_price))
                        {
                            echo $curr_price . "\n";
                        }
                }
                else 
                {
                        $priceRegex = '/(\$[0-9,]+(\.[0-9]{2})?)/';
		
                        //Get the prices
                        preg_match($priceRegex, $scraped_product_page, $matches);
                        
                        if(!empty($matches))
                        {
                                //Assume the first match is the actual price
                                $curr_price = substr($matches[0], 1);
                                
                                if($curr_price < $price)
                                {
                                        $priceChange = true;
                                        //mail("huy.ngu@freecause.com", "Price change!", "Price change at: $url for only $Curr_price");
                                        //$updateQuery = "UPDATE wishlist SET price=" . $Curr_price . ", date_time=NOW() WHERE upc=" . $upc;
                                        //echo $updateQuery;
                                        //$insertUpdate = $db->query($updateQuery) or die(mysql_error());
                                }
                        }
                }
                
                //If there is a price change, update the database 
                if($priceChange)
                {
                        $updateQuery = "UPDATE wishlist SET new_price=" . $curr_price . ", date_time=NOW() WHERE id=" . $id;
                }
                
                $html->clear();
	}
?>