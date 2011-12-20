<html>
<head>
<title>My Wishlist </title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Language" content="en-us">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style type="text/css">
div#mainDetail {
	width:400px;
	height:600px;
	border:2px solid #000000;   
	position:relative;
}
div#googleShopping {
}
div#bucksbeeShopping {
}
div#relatedProd {
	float:left;
	border:2px solid #000000;   
	position:relative;
}
</style>
</head>
<body>
<h2>
Placeholder
</h2>
<p>
<div id="mainDetail">
<?php echo $name ?>
<br/>
<a href ="<?php echo $url ?>"><?php echo $url ?></a>
<br/>
Current price: <?php echo $price ?>
</div>
</p>
<p>
<div id="googleShopping">
</div>
</p>
<p>
<div id="bucksbeeShopping">
</div>
</p>
</body>
<script>
var upc = '<?php echo $upc ?>';
$(document).ready(function(){
		//searchMall();
		searchGoogleShopping();
	});
	
	function searchMall()
	{
		$.ajax({
			dataType: "jsonp",
            jsonp: "callback",
            cache: false,
			jsonpCallback: 'parseResults',
            data: { "api_key": "d00676d8a5fb8b20a952a09307a7e79bb6c0744ceebb5871491467af18af4ed1" },
            url: "http://staging.cms.freecause.com/public_api/find/products/713/"+term+"/0/5?callback=?"

        });
	}
	
	function searchGoogleShopping()
	{
		var request = $.ajax({
							dataType: "json",
							cache: false,
							type: "GET",
							data: { "keyword": upc },
							url: "?action=google_shopping",
						});
						
		request.done(function(data) {
			var success = data.status,
				name = '',
				url = '',
				img = '',
				price = '';
			if(success == "success")
			{
				var products = data.products;
				for(var i=0; i < products.length; i++)
				{
					name = products[i].title;
					url = products[i].link;
					img = products[i].images;
					price = products[i].price;
				
					var prodDiv = "<div id = 'relatedProd'>"+name+"<br/><a href='"+url+"'><img src='"+img+"'></img></a><br/>"+price+"</div>";
					$("div#googleShopping").append(prodDiv);
				}
			}
		});

		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
		});
	}
	
	function parseResults(data)
	{
		var results = data.data,
			name = '',
			url = '',
			img = '',
			price ='';
			
			for(var i=0; i < results.length; i++)
			{
				name = results[i].name;
				url = results[i].dest_url;
				img = results[i].img;
				price = results[i].price;
				
				var prodDiv = "<div id = 'relatedProd'>"+name+"<br/><a href='"+url+"'><img src='"+img+"'></img></a><br/>"+price+"</div>";
				$("div#bucksbeeShopping").append(prodDiv);
			}
	}
</script>
</html>