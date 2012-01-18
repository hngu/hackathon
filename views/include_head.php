<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.js"></script>
<script>
/*
$(document).ready(function() {
	$('.include_header').hover(
		function() {
			$('.include_header_tr').toggle(true);
		},
		function() {
			$('.include_header_tr').toggle(2000);
		}
	);
});
*/	
</script>
<style>
.head_option {
	float: right;
	font-size: 14px;
	margin: 0 30px 0 0;
	color: #999999;
}
.include_header {
	width: 100%;
	height: 62px;
	top: 0;
	border-collapse: collapse;
}
.include_header_tr {
	background: url("/images/header.png") repeat-x scroll left top transparent;
	/*display: none;*/
}
.head_title {
	width: 20%;
	font-size: 11px;
}
.head_option_cell {
	width: 80%;
}
.include_header_tr {
	vertical-align: middle;
}
h2{
	margin: 0;
}
.head_title, .head_option_cell {
	padding: 0;
}
</style>
</head>
<body>
<table class="include_header">
<tr class="include_header_tr">
<td class="head_title">
<h2><a href='http://shopping.i-wishlist.dev' style='color: white; margin-left: 10px;'>My Wishlist</a></h2>
</td>
<td class="head_option_cell">
<div class="head_option"><a href='#'>Promotions</a></div>
<div class="head_option"><a href='#'>Deals</a></div>
<div class="head_option"><a href='http://shopping.i-wishlist.dev'>Dashboard</a></div>
<div class="head_option"><a href='#'>Coupons</a></div>
<div class="head_option"><a href='#'>Community</a></div>
</td>
</tr>
</table>
</body>