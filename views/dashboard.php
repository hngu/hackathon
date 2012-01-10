<!DOCTYPE html>
<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<link rel="stylesheet" href="stylesheets/boxy.css" type="text/css" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
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
	.item_name{
		font-size: 24px;
		color: #0091B5;
		margin: 10px 0px 10px 30px;
	}
	.item_name a:link {
		text-decoration: none; 
		color: #0091B5;
	}
    .item_name a:visited {
		text-decoration: none; 
		color: #0091B5;
	}
	.item_url {
		margin: 0px 0px 10px 30px;
	}
	.price_tag {
		float: left;
		margin: 0px 0px 20px 30px;
	}
	.current_price {
		float: left;
		margin: 0px 0px 20px 0px;
	}
	.price_change {
		float: left;
		margin: 0px 0px 20px 30px;
	}
	.item_price_diff {
		float: right;
		margin: 5px 0px 20px 5px;
		font-size: 14px;
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
<script>
$(document).ready(function() {
	$('tr.wish_row').each(function(index) {
		var id = $(this).attr('id');
		var name = 'item_price_change_' + id;
		var price = $("#wishlist_price_"+id).text();
		var new_price = $("#current_price_"+id).text();
		var price_diff = new_price - price;
		var fill_in = '';
		if(price_diff > 0) {
			fill_in = "<img src='/images/up.png'/>" + '<div class="item_price_diff" color="green">$' + Math.abs(price_diff).toFixed(2);
			fill_in += ' (+' + (100*price_diff/price).toFixed(2) + '%)</div>';
		} else if(price_diff < 0) {
			fill_in = "<img src='/images/down.png'/>" + '<div class="item_price_diff" color="red">$' + Math.abs(price_diff).toFixed(2);
			fill_in += ' (' + (100*price_diff/price).toFixed(2) + '%)</div>';
		} else if(price_diff == 0) {
			fill_in = "<img src='/images/unchanged.png'/>" + '<div class="item_price_diff" color="gray">$' + Math.abs(price_diff).toFixed(2);
			fill_in += '</div>';
		} else {
			fill_in = "Price Error";
		}
		$("#"+name).html(fill_in);
	});
});
</script>
</head>
<body>
<h2>
Your Wishlist
</h2>
<div id="mainContainer">
<p>
<table class="wishlist">
<tr id="top-row"><td id="tl" colspan="2"><div class='action' style="float:right; margin-right: 20px;"><a href='#' onclick='showEditBox("", "", "", "", "0.00");'><img src='/images/add.png' title='Add New'/></a></div></td><td id="tr"></td></tr>
<?php
$n = 1;
while ($row = $result->fetch_object()){
	$prodId = htmlentities($row->id);
	$prodName = htmlentities($row->product_name);
	$url = htmlentities($row->url);
	$price = htmlentities($row->price);
	$newprice = htmlentities($row->new_price);
	$comment = htmlentities($row->comment);
	if($newprice == '0.00') $newprice = $price;
	if($n%2) {
		echo "<tr id='$prodId' class='wish_row'>";
	} else {
		echo "<tr id='$prodId' class='wish_row even'>";
	}
	echo "<td id='wishItem'>";
	echo "<div class='item_name'><a href='?action=product_detail&wid=$prodId'>$prodName</a></div>";
	$url_text = strlen($url) < 80 ? $url : (substr($url, 0, 80).'...');
	echo "<div class='item_url'><a href='$url' target='_blank'>$url_text</a></div>";
	echo "<div class='price_tag'>Wishlist Price: $</div><div class='current_price' id='wishlist_price_$prodId'>$price</div>";
	echo "<div></div>";
	echo "<div class='price_tag'>Current Price: $</div><div class='current_price' id='current_price_$prodId'>$newprice</div>";
	echo "<div class='price_change' id='item_price_change_$prodId'></div>";
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
<script type='text/javascript' src='javascripts/jquery.boxy.js'></script>
<script>
function showEditBox(wid, title, url, comments, price)
{
	var box_title = (wid) ? "Edit Item" : "Add New Item";
    new Boxy("<p class='editForm'><input type='hidden' style='display:none;' id='wid'/>Product:<br/><input type='text' size='60' id='title'/> <br/> Url:<br/><input type='text' size='60' id='url' /><br/>Comments:<br/><textarea rows='10' cols='47' id='comments'></textarea><br/>Price:<input type='text' size='10' id='price' /><img id='loader' src='http://s3toolbar.freecause.com/Tiny/images/ajax-loader.gif' style='display:none; margin: 0px 15px 0px 15px; position:relative; top:3px;'/><br/><input type='button' id='save' value='Submit' style='float:right;'/><br/>",
        {title:box_title, modal:true}
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

        var box_url = 'http://shopping.i-wishlist.dev/?action=' + ((wid) ? 'update_item' : 'add_to_wishlist');
        $.post(box_url,
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