<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
unset($_SESSION["cart_item"]);
?>


<!DOCTYPE html>
<html>
<head>
<title>City Restaurant</title>
<link  rel="shortcut icon" type="image/icon" href="images/icons.png" />

 <style>
	#pop{
			margin:0px auto;
			margin-top:50px;
			height:280px;
			width:470px;
			bottom:50%;
			right:50%;
			border:2px solid;
			padding:10px;
			background:#FFFFFF;
		}
		#close{
			right:5px;
			top:5px;
			float:right;
			courser:pointer;
		}
		p{color:red; font-size:20px; margin-top:40px; line-height:30px;}
		
		</style>
</head>

<body>

					
		<div id="pop">
			<a href="order.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a></br>
			<p>Your Order is Send Successfully. We Send a link on your Email please click the link and complete your order than we can deliver your food item more than 24 hours. </p>
		
		</div>
			
	
</body>