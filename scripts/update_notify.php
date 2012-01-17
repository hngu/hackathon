<?php
        ini_set("memory_limit","128M");
        require_once '../lib/simple_html_dom.php';
        
	$username = 'root';
	$host = 'localhost';
	$password = 'developer';
	$database = 'hackathon';
	
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
                        mail("feng.zheng@freecause.com", "Error running update_notify", $e->getMessage());
                        echo $e->getMessage() . "\n";
                        continue;
                }
		
                $parsed_url = parse_url($url);
                $domain = $parsed_url['host'];
                $html->load($scraped_product_page);
                
                if($domain == 'www.bestbuy.com')
                {
                        $priceElement = $html->find("div#saleprice span.price");
                        if(!empty($priceElement))
                        {
                                $curr_price = $priceElement[0]->plaintext;
                                $curr_price = substr(trim($curr_price), 1);
                        
                                if(!empty($curr_price))
                                {
                                        preg_match('/([0-9]+[\.]*[0-9]*)/', $curr_price, $match);
                                        $curr_price = $match[1];
                                        
                                        if(!empty($curr_price) && is_numeric($curr_price))
                                        {
                                                echo "Scraped price is $curr_price \n";
                                                
                                                if($curr_price != $price)
                                                {
                                                        $priceChange = true;
                                                }
                                        }
                                }
                        }
                }
                
                else if($domain == 'www.amazon.com')
                {
                        $priceElement = $html->find("div#priceBlock b.priceLarge");
                        if(!empty($priceElement))
                        {
                                $curr_price = $priceElement[0]->plaintext;
                                $curr_price = substr(trim($curr_price), 1);
                        
                                if(!empty($curr_price))
                                {
                                    preg_match('/([0-9]+[\.]*[0-9]*)/', $curr_price, $match);
                                    $curr_price = $match[1];
                                        
                                    if(!empty($curr_price) && is_numeric($curr_price))
                                    {
                                            echo "Scraped price is $curr_price \n";
                                            
                                            if($curr_price != $price)
                                            {
                                                    $priceChange = true;
                                            }
                                    }
                                }
                        }
                }
                
                else if($domain == 'www.walmart.com')
                {
                        echo "Dont know what to do with walmart!";
                }
                
                else if($domain == 'www.target.com')
                {
                        $priceElement = $html->find("div#price_main p.price");
                        if(!empty($priceElement))
                        {
                                $curr_price = $priceElement[0]->plaintext;
                                $curr_price = substr(trim($curr_price), 1);
                        
                                if(!empty($curr_price))
                                {
                                    preg_match('/([0-9]+[\.]*[0-9]*)/', $curr_price, $match);
                                    $curr_price = $match[1];
                                        
                                    if(!empty($curr_price) && is_numeric($curr_price))
                                    {
                                            echo "Scraped price is $curr_price \n";
                                            
                                            if($curr_price != $price)
                                            {
                                                    $priceChange = true;
                                            }
                                    }
                                }
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
                                
                                if($curr_price != $price)
                                {
                                        $priceChange = true;
                                }
                        }
                }
                
                //If there is a price change, update the database 
                if($priceChange)
                {
                        $updateQuery = "UPDATE wishlist SET new_price=" . $curr_price . ", wish_date=NOW() WHERE id=" . $id;
                        echo $updateQuery . "\n";
                        $updatePrice = $db->query($updateQuery);
                        
                        if(!$updatePrice)
                        {
                                echo "Error: $db->error";
                        }
                }
                
                $html->clear();
	}
?>