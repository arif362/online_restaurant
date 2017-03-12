<?php
include("../config.php");

ob_start();
session_start();
if(isset($_SESSION['member_id']))
{
	$member_id=$_SESSION['member_id'];	
}
else if(isset($_SESSION['mem_username'])) {
	$mem_username = $_SESSION['mem_username'];
}
else if(isset($_SESSION['member_name'])) {
	$member_name = $_SESSION['member_name'];
}
else if(isset($_SESSION['mem_email'])) {
	$mem_email = $_SESSION['mem_email'];
}
else if(isset($_SESSION['mem_address'])) {
	$mem_address = $_SESSION['mem_address'];
}
else if(isset($_SESSION['mem_mobile'])) {
	$mem_mobile = $_SESSION['mem_mobile'];
}
else {
	header('location:../index.php');
}
?>

<!DOCTYPE html>
<html class=" js rgba boxshadow csstransitions"><head>
<title>City Restaurant</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/css.css" rel="stylesheet" type="text/css">
<link  rel="shortcut icon" type="image/icon" href="../images/icons.png" />
<!--slider-->
<link rel="stylesheet" href="../css/flexslider.css" type="text/css" media="all">
 <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
 <script src="../js/highlightNav.js"></script>
<!-- Calendar Scripts-->
		<link rel="stylesheet" href="../css/tcal.css" type="text/css" />
		<script type="text/javascript" src="../css/tcal.js"></script>
<!-- jQuery -->
 <script src="../js/jquery.js"></script>
<!-- Fancybox jQuery -->
		<script type="text/javascript" src="../fancybox/jquery.fancybox.js"></script>
		<script type="text/javascript" src="../fancybox/main.js"></script>
		<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox.css" />
<!-- //Fancybox jQuery -->
  <!-- FlexSlider -->
  <script defer="defer" src="../js/jquery_002.js"></script>
  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
  
  <!-- Ajax Selected Dropdown Scripts-->
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cat_id").change(function() {
				$(this).after('<div id="loader"><img src="img/loading.gif" alt="Loading Food Category" /></div>');
				$.get('get-category.php?cat_id=' + $(this).val(), function(data) {
					$("#category").html(data);
					$('#loader').slideUp(200, function() {
						$(this).remove();
					});
				});	
			});
		 
		});
		</script>
</head>

<body>

<script async="" type="text/javascript" src="../js/fancybar.js" id="_fancybar_js"></script>


<div class="header-box"></div>
<div class="wrap"> 
	<div class="total">
		<div class="header">
			<div class="header-bot">
				<div class="logo">
					<a href="index.php"><img src="../images/logo.png" alt=""></a>
				</div>
				<ul class="follow_icon">
					<li><a href="#"><img src="../images/fb1.png" alt=""></a></li>
					<li><a href="#"><img src="../images/rss.png" alt=""></a></li>
					<li><a href="#"><img src="../images/tw.png" alt=""></a></li>
					<li><a href="#"><img src="../images/g.png" alt=""></a></li>
				</ul>
			    <div class="clear"></div> 
			</div>
			<div class="search-bar">
				<form action="search-food.php" method="post">
			    <input kl_virtual_keyboard_secure_input="on" class="textbox" value=" Search Food Items" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" type="text" name="search">
			    <input name="searchsubmit" src="images/search-icon.png" value="Go" id="searchsubmit" class="btn" type="image">
         	    </form>
				 <div class="clear"></div>
    		</div>
			<div class="clear"></div> 
		 </div>	
		<div class="menu"> 	
			<nav>
				<ul class="navigation">
					<li class="highlight"><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li> |
					<li><a href="menu.php">Menu</a></li> |
					<li><a href="service.php">Services</a></li> |
					<li><a href="order.php">Order Foods</a></li> |
					<li><a href="#">Order List</a>
					<ul>
						<li><a href="view-pending-order.php">Pending Order</a></li>|
						<li><a href="view-successful-order.php">Successful Order</a></li> 
					</ul>
					</li> |
					<li><a href="contact.php">Contact</a></li>  |
					<li><a href="member.php">MY Profile</a></li>  |
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>	