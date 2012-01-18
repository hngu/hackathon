<?php
require_once "dblib.php";

function update_item()
{	
	$db = getDB();
        if(isset($_POST['title']) && isset($_POST['url']) && isset($_POST['price']) && isset($_POST['comments'])&& isset($_POST['wid']) && isset($_POST['image']))
        {
                $wid = $db->real_escape_string($_POST['wid']);
                $title = $db->real_escape_string($_POST['title']);
                $url = $db->real_escape_string($_POST['url']);
                $price = $db->real_escape_string($_POST['price']);
                $comments = $db->real_escape_string(($_POST['comments']));
                $image = $db->real_escape_string(($_POST['image']));
                
                $updateQuery = "UPDATE wishlist SET price=" . $price . ", product_name='" . $title . "', url='" . $url . "', comment='" . $comments . "', image='" . $image . "', wish_date=NOW() WHERE id=" . $wid;
		$result = $db->query($updateQuery);
                
                if($result)
                {
                        $response = array('isSuccess' => true, 'response' => 'Item saved! Click <a href="?action=dashboard" style="color:#FF0000;">Click here</a> to refresh the page');
                        echo json_encode($response);
                }
                else
                {
                        $response = array('isSuccess' => false, 'response' => $db->error);
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
