<!DOCTYPE html>
<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<link rel="stylesheet" href="stylesheets/boxy.css" type="text/css" />
<style>
    body {
        background: url("http://static10.gog.com/www/forum_carbon/-img/body_bg.jpg") repeat-x scroll 0 0 #676767;
        color: #FFFFFF;
        font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
        font-size: 11px;
        width: 100%;
    }    
    div#mainContainer {
        margin-left: auto;
        margin-right: auto;
        width: 80%;
        background-color: #FFFFFF;
        position: relative;
        color: #333333;
        font-size: 18px;
        height:100%;
    }
    table.wishlist {
        width: 100%;
    	border: 0px;
    	border-collapse: collapse;
    }
    #top-row {
    	height: 20px;
    	background-color: #C9C9C9;
	}
	#bottom-row {
		height: 20px;
		background-color: #C9C9C9;
	}
	#t1{
		border-radius: 14px 14px 14px 14px;
	}
    td.actionItem {
        width: 30%;
    }
    tr.even{
    	background-color: #E8EDFF;
	}
    td#wishItem {
       width:70%;
    }
    
    td.actionItem div.action {
        float: right;
        margin: 0% 5%;
    }
    .wish_row:hover td {
    	background-color: yellow;
	}
	.item_name {
		font-size: 24px;
		color: #0091B5;
		margin: 10px 0px 10px 30px;
	}
        .item_name a:visited {
		text-decoration: none; color: #0091B5;
	}
	.item_url {
		margin: 0px 0px 10px 30px;
	}
	.item_price {
		margin: 0px 0px 20px 30px;
	}
	.view_more {
		float: right;
		margin: 0% 5%;
	}
	a:link {
		text-decoration: none; color: #ABAAAA;
	}
	a:visited {
		text-decoration: none; color: #ABAAAA;
	}
	a:active {
		text-decoration: none; color: #ABAAAA;
	}
	a:hover {
		text-decoration: underline; color: #0000FF;
	}
        
        p.editForm {
            color:#000000;
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
<tr id="top-row"><td id="tl"></td><td></td><td id="tr"></td></tr>
<?php
$n = 1;
while ($row = $result->fetch_object()){
	$prodId = htmlentities($row->id);
	$prodName = htmlentities($row->product_name);
	$url = htmlentities($row->url);
	$price = htmlentities($row->price);
        $comment = htmlentities($row->comment);

	if($n%2) {
		echo "<tr id='$prodId' class='wish_row'>";
	} else {
		echo "<tr id='$prodId' class='wish_row even'>";
	}
	echo "<td id='wishItem'>";
	echo "<div class='item_name'><a href='?action=product_detail&wid=$prodId'>$prodName</a></div>";
	$url_text = strlen($url) < 80 ? $url : (substr($url, 0, 80).'...');
	echo "<div class='item_url'><a href='$url' target='_blank'>$url_text</a></div>";
	echo "<div class='item_price'>Price: $$price</price>";
	echo "</td>";
	echo "<td class='actionItem' id='$prodId'>";
	echo "<div class='action'><a href='#'><img src='/images/RecycleBin_Empty-64.png' title='Delete'/></a></div>" . "\n";
	echo "<div class='action'><a href='#' onclick='showEditBox(\"$prodId\", \"$prodName\",\"$url\",\"$comment\",\"$price\");'><img src='/images/pencil.png' title='Edit'/></a></div>" . "\n";
	echo "<div class='view_more'><a href='?action=product_detail&wid=$prodId'><img src='/images/view_more.png' title='View More'/></a></div>";
	echo "</td>";
	echo "</tr>";
	$n++;
}
?>
<tr id="bottom-row"><td id="bl"></td><td></td><td id="br"></td></tr>
</table>
</div>
</body>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script type='text/javascript' src='javascripts/jquery.boxy.js'></script>
<script>
function showEditBox(wid, title, url, comments, price)
{
    new Boxy("<p class='editForm'><input type='hidden' style='display:none;' id='wid'/>Product:<br/><input type='text' size='60' id='title'/> <br/> Url:<br/><input type='text' size='60' id='url' /><br/>Comments:<br/><textarea rows='10' cols='47' id='comments'></textarea><br/>Price:<input type='text' size='10' id='price' /><img id='loader' src='http://s3toolbar.freecause.com/Tiny/images/ajax-loader.gif' style='display:none; margin: 0px 15px 0px 15px; position:relative; top:3px;'/><br/><input type='button' id='save' value='Submit' style='float:right;'/><br/>",
        {title:"Edit item", modal:true}
        );
    
    $('input#title').val(title);
    $('input#url').val(url);
    $('textarea#comments').val(comments);
    $('input#price').val(price);
    $('input#wid').val(wid);
    
    $('input#save').click(function(){
        var title = $('input#title').val();
        var url = $('input#url').val();
        var comments = $('textarea#comments').val();
        var price = $('input#price').val();
        var wid = $('input#wid').val();
        
        $(this).attr("disabled", true);
        $('img#loader').show();
        
        $.post('http://shopping.i-wishlist.dev/?action=update_item',
			{title: title, url: url, price: price, comments: comments, wid: wid},
			function(data)
			{
				if(data.isSuccess)
				{
                                        $('p.editForm').append(data.response);
                                        $('img#loader').hide();
					
				}
				else
				{
                                        $('img#loader').hide();
					alert(data.response);
                                        console.log(data.response);
				}
			}, "json");
    });
}
</script>
</html>