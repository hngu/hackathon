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
        width: 80%;
        background-color: #FFFFFF;
        position: relative;
        color: #333333;
        font-size: 18px;
        height:100%;
    }
    img.topDisplay {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
</head>
<body>
<h2>
Product Detail:
</h2>
<div id="mainContainer">
<img src='/images/starry_detail.png' class='topDisplay'/>
<br/>
Name: <?php echo $name ?>
<br/>
Url: <?php echo $url ?>
<br/>
Price: <?php echo $price ?>
<br/>
Comment:
<br/>
<?php echo $comment ?>
<br/>
</div>
</body>
</html>