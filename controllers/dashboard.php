<?php
        require_once "dblib.php";
        function dashboard()
        {
                $db = getDB();
                
                $searchQuery = "SELECT * from wishlist";
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
