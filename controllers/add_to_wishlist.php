<?php

	require_once "dblib.php";
        function add_to_wishlist()
        {

                if(isset($_POST['title']) && isset($_POST['url']) && isset($_POST['price']) && isset($_POST['comments']))
                {
                        $title = $_POST['title'];
			$price = $_POST['price'];
			$comments = $_POST['comments'];
			$url = $_POST['url'];
                        
                        $db = getDB();
                        
                        $insertQuery = "INSERT into wishlist (product_name, url, price, comment, wish_date) VALUES ('" . $title . "', '" . $url . "', " . $price . ", '" . $comments . "', NOW());";
                        $result = $db->query($insertQuery);
                        if(!$result)
                        {
                                $response = array('isSuccess' => false, 'response' => $db->error);
                                echo json_encode($response);
                        }
                        else
                        {
                                $response = array('isSuccess' => true, 'response' => 'Added to wishlist!');
                                echo json_encode($response);
                        }
                }
                else
                {
                        $response = array('isSuccess' => false, 'response' => 'Not all parameters were passed to API!');
                        echo json_encode($response);
                }
        }
?>

