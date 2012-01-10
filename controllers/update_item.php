<?php
require_once "dblib.php";

function update_item()
{	
	$db = getDB();
        if(isset($_POST['title']) && isset($_POST['url']) && isset($_POST['price']) && isset($_POST['comments'])&& isset($_POST['wid']))
        {
                $wid = mysql_real_escape_string($_POST['wid']);
                $title = mysql_real_escape_string($_POST['title']);
                $url = mysql_real_escape_string($_POST['url']);
                $price = mysql_real_escape_string($_POST['price']);
                $comments = mysql_real_escape_string(nl2br($_POST['comments']));
                
                $updateQuery = "UPDATE wishlist SET price=" . $price . ", product_name='" . $title . "', url='" . $url . "', comment='" . $comments . "', wish_date=NOW() WHERE id=" . $wid;
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
