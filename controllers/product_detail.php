<?php

require_once "dblib.php";

function product_detail()
{	
	$db = getDB();
        if(!isset($_GET['wid']))
        {
                $error = 'wid is not set!';
                include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'error_page.php';
                exit;
        }
        else
        {
                $wid = $_GET['wid'];
                $searchQuery = "SELECT product_name, url, price, new_price, comment from wishlist where id=" . $wid . " LIMIT 1";
		$result = $db->query($searchQuery) or die(mysql_error());
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $price = $row['price'];
                $url = $row['url'];
                $name = $row['product_name'];
                $newPrice = $row['new_price'];
                $comment = $row['comment'];
                include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'product_detail.php';
        }			
				
}

