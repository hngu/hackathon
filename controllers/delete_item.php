<?php
require_once "dblib.php";

function delete_item()
{	
	$db = getDB();
        if(isset($_GET['wid']))
        {
                $wid = $db->real_escape_string($_GET['wid']);
                
                $updateQuery = "DELETE FROM wishlist WHERE id = " . $wid;
				$result = $db->query($updateQuery);
                
                if($result)
                {
                        $response = array('isSuccess' => true, 'response' => 'Successfullly deleted, please click OK to refresh');
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
                $response = array('isSuccess' => false, 'response' => 'Id is null or empty');
                echo json_encode($response);
        }
}
?>
