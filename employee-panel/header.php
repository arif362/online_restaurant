<?php
include("../config.php");

ob_start();
session_start();
if(isset($_SESSION['employee_id']))
{
	$employee_id=$_SESSION['employee_id'];	
}
else if(isset($_SESSION['emp_username'])) {
	$emp_username = $_SESSION['emp_username'];
}
else if(isset($_SESSION['employee_name'])) {
	$employee_name = $_SESSION['employee_name'];
}
else if(isset($_SESSION['emp_email'])) {
	$emp_email = $_SESSION['emp_email'];
}
else {
	header('location:../index.php');
}
?>


<!Doctype html>

<html>
	<head>
		<title>City Restaurant</title>
		<link rel="shortcut icon" type="image/icon" href="../images/icons.png">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
		<!--Menubar Highlight-->
		<script src="../js/highlightNav.js"></script>
		<!--Delete Permission Code by Java Script-->
		<script type='text/javascript'>
		function confirm_delete()
		{
			return confirm("Do you sure want to delete this item?");
		}
		</script>
		<!--Approved Permission Code by Java Script-->
		<script type='text/javascript'>
		function confirm_deliver() {
			return confirm('are you sure! you want to Approver This Application?') ;}
		</script>
		<!-- Fancybox jQuery -->
		<script type="text/javascript" src="../fancybox/jquery.fancybox.js"></script>
		<script type="text/javascript" src="../fancybox/main.js"></script>
		<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox.css" />
		<!-- //Fancybox jQuery -->
		
		<!-- CKEditor Start -->
		<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
		<!-- // CKEditor End -->
		
		<!-- Calendar Scripts-->
		<link rel="stylesheet" href="css/tcal.css" type="text/css" />
		<script type="text/javascript" src="css/tcal.js"></script>
		

		
	</head>
	
	<body>
		<header>
			<div class="top_bar">
				<div class="top_bar_left">
					<h1>Welcome <span style="color:#FFFFFF"><?php echo $_SESSION['employee_name'];?></span> ! To Our City Restaurant </h1>
				</div>
				<div class="top_bar_right">
					<ul class="navigation">
						<li class="highlight"><a href="index.php">Home</a></li>
						<li><a href="logout.php">Log Out</a></li>
					</ul>
				</div>
			</div>
		</header>