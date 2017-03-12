<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
unset($_SESSION["cart_item"]);
?>

<!DOCTYPE html>
<html class=" js rgba boxshadow csstransitions"><head>
<title>City Restaurant</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/css.css" rel="stylesheet" type="text/css">
<link  rel="shortcut icon" type="image/icon" href="images/icons.png" />
<!--slider-->
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all">
 <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
 <script src="js/highlightNav.js"></script>
<!-- Calendar Scripts-->
		<link rel="stylesheet" href="css/tcal.css" type="text/css" />
		<script type="text/javascript" src="css/tcal.js"></script>
<!-- jQuery -->
 <script src="js/jquery.js"></script>
  <!-- FlexSlider -->
  <script defer="defer" src="js/jquery_002.js"></script>
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

<script async="" type="text/javascript" src="js/fancybar.js" id="_fancybar_js"></script>


<div class="header-box"></div>
<div class="wrap"> 
	<div class="total">
		<div class="header">
			<div class="header-bot">
				<div class="logo">
					<a href="index.php"><img src="images/logo.png" alt=""></a>
				</div>
				
			    <div class="clear"></div> 
			</div>
			<div class="search-bar">
				<form action="search-food.php" method="post">
			    <input kl_virtual_keyboard_secure_input="on" class="textbox" value="Search Food Items" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search Food Items';}" type="text" name="search">
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
					<li><a href="contact.php">Contact</a></li>  |
					<li><a href="member.php">Registration</a></li>  |
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>
		</div>	