<?php 
require_once "dblib.php";

function price_change() {
	$db = getDB();
	if(!isset($_GET['wid'])){
		$error = 'Invalid wishlist product ID!';
    	include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'error_page.php';
    	exit;
	} else {
    	$wid = $_GET['wid'];
	    // edit this part !!!!!!!!!!!!!!!!!
	    switch($wid) {
    		case 1:
	    		echo '120.3';
    			break;
    		case 2:
	    		echo '50';
    			break;
    		case 3:
	    		echo '-4.25';
    			break;
    		case 4:
	    		echo '0';
    			break;
    		default:
	    		echo '0';
    			break;
    	}
	}
}	
?>