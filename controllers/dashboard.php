<?php
        require_once "dblib.php";
        function dashboard()
        {
                $db = getDB();
                if(isset($_GET['sort'])) {
                	$keyword = $_GET['sort'];
                	switch($keyword) {
                		case "old_to_new":
                			$searchQuery = "SELECT * FROM wishlist ORDER BY wish_date ASC";
                			break;
                		case "new_to_old":
                			$searchQuery = "SELECT * FROM wishlist ORDER BY wish_date DESC";
                			break;
                		case "low_to_high":
                			$searchQuery = "SELECT * FROM wishlist ORDER BY price ASC";
                			break;
                		case "high_to_low":
                			$searchQuery = "SELECT * FROM wishlist ORDER BY price DESC";
                			break;
                		case "name":
                			$searchQuery = "SELECT * FROM wishlist ORDER BY product_name ASC";
                			break;
                		default:
                			$searchQuery = "SELECT * from wishlist";
                			break;
                	}
                } else {
                	$searchQuery = "SELECT * from wishlist";
                }
				$result = $db->query($searchQuery) or die(mysql_error());
                
                if(empty($result))
                {
                        $error = "INTERNAL DATABASE ERROR!!!";
                        include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'error_page.php';
                }
                else
                {
                        include APPLICATION_PATH . 'views'. DIRECTORY_SEPARATOR . 'dashboard.php';
                }
        }
?>
