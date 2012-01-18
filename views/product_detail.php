<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<link rel="stylesheet" href="stylesheets/boxy.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style type="text/css">
    body {
        background: url("http://static10.gog.com/www/forum_carbon/-img/body_bg.jpg") repeat-x scroll 0 0 #676767;
        color: #FFFFFF;
        font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
        font-size: 11px;
        width: 100%;
    	margin: 0;
    }    
    div#mainContainer {
        margin-left: auto;
        margin-right: auto;
        width: 65%;
        background-color: #FFFFFF;
        position: relative;
        color: #333333;
        font-size: 18px;
        height:100%;
    	top: 50px;
    }
    img {
    	border: none;
	}
    img.topDisplay {
        display: block;
        margin-left: auto;
        margin-right: auto;
    	margin-bottom: 10px;
    }
    table#detail_table {
    	width: 100%;
    	border-collapse: collapse;
    	font-family: "Lucida Sans Unicode","Lucida Grande",Sans-Serif;
    	text-align: left;
	}
	tr.header tr.footer {
		vertical-align: top;
	}
	tr.header {
		background: none repeat scroll 0 0 #FFFFFF;
	}
	tr.footer {
		background: none repeat scroll 0 0 #FFFFFF;
		height: 200px;
	}
	td.detail_field, td.detail_content {
		background: none repeat scroll 0 0 #E8EDFF;
    	border-bottom: 1px solid #FFFFFF;
    	border-top: 1px solid transparent;
    	color: #666699;
    	padding: 8px;
	}
	td.detail_field {
		width: 20%;
		color: green;
		background: none repeat scroll 0 0 #D0DAFD;
	}
	td.detail_content {
		width: 80%;
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
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher:'99118a14-3b38-493c-8594-fd6e7807832e'});</script>
</head>
<body>
<?php include 'include_head.php';?>
<div id="mainContainer">
<table id="detail_table" align="center">
<colgroup span="1"></colgroup>
<thead>
	<tr class="header"><th colspan="2"><img src='/images/starry_detail_transparent.png' class='topDisplay'/></th></tr>
</thead>
<tbody>
	<tr>
		<td class="detail_field">Product Name: </td>
		<td class="detail_content"><?php echo $name ?></td>
	</tr>
	<tr id="hyperlink">
		<td class="detail_field">Hyperlink: </td>
		<td class="detail_content"><?php echo "<a href='$url'>$url</a>"; ?></td>
	</tr>
        <tr id="hyperlink">
		<td class="detail_field">Image: </td>
		<td class="detail_content"><?php if(!empty($image)) echo "<img src='$image'/>"; ?></td>
	</tr>
	<tr>
		<td class="detail_field">Current Price: </td>
		<td class="detail_content"><?php echo '$'.$price ?></td>
	</tr>
	<tr id="comment">
		<td class="detail_field">Comment: </td>
		<td class="detail_content"><?php echo $comment ?></td>
	</tr>
	<tr id="share">
		<td class="detail_field">Share/Mention</td>
		<td class="detail_content">
			<span class='st_facebook_large' st_title='<?php echo $name ?>' st_url='<?php echo $url ?>' displayText='Check out this cool stuff @ $'+<?php echo $price ?>></span>
			<span class='st_twitter_large'  st_title='<?php echo $name ?>' st_url='<?php echo $url ?>' displayText='Check out this cool stuff @ $'+<?php echo $price ?>></span>
			<span class='st_email_large'  st_title='<?php echo $name ?>' st_url='<?php echo $url ?>' displayText='Check out this cool stuff @ $'+<?php echo $price ?>></span>
		</td>
	</tr>
        <tr id="stats">
		<td class="detail_field">Chart: </td>
		<td class="detail_content" id="chart"></td>
	</tr>
</tbody>
<tfoot>
	<tr class="footer"><th colspan="2"></th></tr>
</tfoot>
</table>
</div>
</body>
<script>
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Price');
        var price = <?php echo $price ?>;
        data.addRows([
          ['Yesterday', price],
          ['Today', price]
        ]);

        var options = {
          width: 400, height: 240,
          title: 'Price History'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
</script>
</html>