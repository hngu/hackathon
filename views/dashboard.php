<!DOCTYPE html>
<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<style>
    body {
        background: url("http://static10.gog.com/www/forum_carbon/-img/body_bg.jpg") repeat-x scroll 0 0 #676767;
        color: #FFFFFF;
        font-family: Arial;
        font-size: 11px;
        width: 100%;
    }
    
    div#mainContainer {
        margin-left: auto;
        margin-right: auto;
        width: 80%;
        background-color: #FFFFFF;
        position: relative;
        color: #000000;
        font-size: 18px;
        height:100%;
    }
    table.wishlist {
        width: 100%;
    }
    td.actionItem {
        width: 20%;
    }
    
    td#wishItem {
       width:80%;
    }
    
    td.actionItem div.action {
        float: right;
        margin: 0% 5%;
    }
</style>
</head>
<body>
<h2>
Your Wishlist
</h2>
<div id="mainContainer">
<p>
<table class="wishlist">
<?php
        while ($row = $result->fetch_object())
        {
                echo "<tr id='$row->id'>";
                echo "<td id='wishItem'>";
                echo "Item: $row->product_name";
                echo "<br/>";
                echo "Url: <a href='$row->url' >$row->url</a>";
                echo "<br/>";
                echo "Price: $row->price";
                echo "<br/>";
                echo "<a href='shopping.i-wishlist.dev/?action=product_detail&wid=$row->id'>View More</a>";
                echo "</td>";
                echo "<td class='actionItem' id='$row->id'>";
                echo "<div class='action'><img src='/images/RecycleBin_Empty-64.png' title='Delete'/></div>" . "\n";
                echo "<div class='action'><img src='/images/pencil.png' title='Edit' class='action'/></div>" . "\n";
                echo "<div class='action'><img src='/images/move.png' title='Move' class='action'/></div>" . "\n";
                echo "</td>";
                echo "</tr>";
        }
?>
</table>
</p>
</div>
</body>
</html>