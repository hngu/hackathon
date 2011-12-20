<?php

	require_once 'dblib.php';

	function add_to_wishlist()
	{
		if(isset($_POST['upc']) && isset($_POST['url']) && isset($_POST['name']) && isset($_POST['price']))
		{
			$upcNum = $_POST['upc'];
			$price = $_POST['price'];
			$prodName = $_POST['name'];
			$url = $_POST['url'];
			
			$searchQuery = "SELECT * from wishlist where upc=" . $upcNum;
			$db = getDB();
			$result = $db->query($searchQuery);
			$rows = mysqli_num_rows($result);
			if(!empty($rows))
			{
				$response = array('hasError' => true, 'response' => 'Record is already in the database');
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
			$response = array('hasError' => true, 'response' => 'Not all parameters are passed in!');
			echo json_encode($response);
		}
	}

?>

