<?php

	require_once "dblib.php";
        function add_to_wishlist()
        {
                if(isset($_POST['title']) && isset($_POST['url']) && isset($_POST['price']) && isset($_POST['comments']) && isset($_POST['image']))
                {
                        $db = getDB();
                        
                        $title = $db->real_escape_string($_POST['title']);
			$price = $db->real_escape_string($_POST['price']);
			$comments = $db->real_escape_string($_POST['comments']);
			$url = $db->real_escape_string($_POST['url']);
                        $image = $db->real_escape_string($_POST['image']);
                                                
                        $insertQuery = "INSERT into wishlist (product_name, url, price, comment, image, wish_date) VALUES ('" . $title . "', '" . $url . "', " . $price . ", '" . $comments . "', '" . $image . "', NOW());";
                        $result = $db->query($insertQuery);
                        if(!$result)
                        {
                                $response = array('isSuccess' => false, 'response' => $db->error);
                                echo json_encode($response);
                        }
                        else
                        {
                                $response = array('isSuccess' => true, 'response' => 'Added to wishlist! Click <a href="?action=dashboard" style="color:#FF0000;">Click here</a> to refresh the page');
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

