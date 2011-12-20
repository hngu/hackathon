<?php

	bootstrap('hackathon');
	require_once 'S3_helpers.php';
	require_once 'IniConfiguration.php';
	
	function google_shopping()
	{	
		$cfg = IniConfiguration::getInstance();
		$key = $cfg->GOOGLE_KEY;
		$array = array('status'=>'fail');
		if(!isset($_GET['keyword']) || $_GET['keyword'] == '') {
			echo json_encode($array);
			die();
		}
		else {
			$keyword = urlencode($_GET['keyword']);
			$api_url = "https://www.googleapis.com/shopping/search/v1/public/products?key=".$key."&country=US&q=".$keyword."&rankBy=relevancy";
			$content = json_decode(@file_get_contents($api_url));
			$result_num = $content->totalItems;
			
		if(!$result_num) {
			echo json_encode($array);
			die();
		} else {
			$array['status'] = 'success';
			$array_products = array();
			$products = $content->items;
			$n = 5;
			
			foreach($products as $product_t) {
				$product = $product_t->product;
				$single_product = array(
										'upc' => isset($product->gtin) ? $product->gtin : null,
										'googleId' => isset($product->googleId) ? $product->googleId : null,
										'merchant' => isset($product->author->name) ? $product->author->name : null,
										'title' => isset($product->title) ? $product->title : null,
										'description' => isset($product->description) ? $product->description : null,
										'link' => isset($product->link) ? $product->link : null,
										'brand' => isset($product->brand) ? $product->brand : null,
										'condition' => isset($product->condition) ? $product->condition : null,
										'price' => isset($product->inventories[0]->price) ? $product->inventories[0]->price : null,
										'shipping' => isset($product->inventories[0]->shipping) ? $product->inventories[0]->shipping : null,
										'tax' => isset($product->inventories[0]->tax) ? $product->inventories[0]->tax : null,
										'currency' => isset($product->inventories[0]->currency) ? $product->inventories[0]->currency : null,
										'images' => isset($product->images[0]->link) ? $product->images[0]->link : null
										);
										
				array_push($array_products, $single_product);
				$n--;
				
				if($n <= 0) {
					break;
				}
			}
			$array['products'] = $array_products;
			echo(json_encode($array));
			}
		}
	}
?>
