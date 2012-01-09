<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style type="text/css">
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
        width: 60%;
        position: relative;
        font-size: 18px;
        height:100%;
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
	tr {
		vertical-align: top;
	}
	tr.header {
		background: none repeat scroll 0 0 #FFFFFF;
	}
	tr.footer {
		background: none repeat scroll 0 0 #FFFFFF;
		height: 200px;
	}
	tr:hover td {
    	background: none repeat scroll 0 0 #EFF2FF;
    	color: #333399;
	}
	td {
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
</style>
</head>
<body>
<h2>
Product Detail:
</h2>
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
	<tr>
		<td class="detail_field">Current Price: </td>
		<td class="detail_content"><?php echo '$'.$price ?></td>
	</tr>
	<tr id="comment">
		<td class="detail_field">Comment: </td>
		<td class="detail_content"><?php echo $comment ?></td>
	</tr>
</tbody>
<tfoot>
	<tr class="footer"><th colspan="2"></th></tr>
</tfoot>
</table>
</div>
</body>
</html>