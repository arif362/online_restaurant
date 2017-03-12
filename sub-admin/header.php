<?php
include("../config.php");

ob_start();
session_start();
if(isset($_SESSION['restaurant_id']))
{
	$restaurant_id=$_SESSION['restaurant_id'];	
}
else if(isset($_SESSION['sub_username'])) {
	$sub_username = $_SESSION['sub_username'];
}
else if(isset($_SESSION['sub_name'])) {
	$sub_name = $_SESSION['sub_name'];
}
else if(isset($_SESSION['restaurant_name'])) {
	$restaurant_name = $_SESSION['restaurant_name'];
}
else if(isset($_SESSION['sub_email'])) {
	$sub_email = $_SESSION['sub_email'];
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
		<!--Form Validation-->
		 <script type="text/javascript" language="javascript" src="js/member-validation.js"></script>
		 <script type="text/javascript" language="javascript" src="js/admin-validation.js"></script>
		 
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
			return confirm('are you sure! you want to Approver This Order?') ;}
		</script>
		<!--Approved Permission Code by Java Script-->
		<script type='text/javascript'>
			function confirm_send() {
			return confirm('are you sure! you want to Send Your Message...') ;}
		</script>
		<script type='text/javascript'>
		function confirm_message() {
			return confirm('are you sure! you want to Approver This Member?') ;}
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
		<!-- Ajax Date Wish Search Scripts-->
		<script type="text/javascript">
		$(document).ready(function(){
		  $("#generate_report").click(function(){
			  var from_date=jQuery("#fromdate").val();
			  var to_date=jQuery("#todate").val();
			  var data =
			  {		
				from_date	 : from_date,
				to_date		 : to_date
			  }
			jQuery.ajax({	
							type: "POST",
							url: "get-order.php",
							data: data,
							success: function(responce){
								$("#txtHint").after(responce);
						  }	
					 });
		  });
		});
		</script>
		<!-- Ajax Date Wish Search Scripts-->
		<script type="text/javascript">
		$(document).ready(function(){
		  $("#generate_report2").click(function(){
			  var from_date=jQuery("#fromdate").val();
			  var to_date=jQuery("#todate").val();
			  var data =
			  {		
				from_date	 : from_date,
				to_date		 : to_date
			  }
			jQuery.ajax({	
							type: "POST",
							url: "get-order2.php",
							data: data,
							success: function(responce){
								$("#txtHint").after(responce);
						  }	
					 });
		  });
		});
		</script>
		<!-- Ajax Month Wish Search Scripts-->
		<script type="text/javascript">
		$(document).ready(function(){
		  $("#monthly_report").click(function(){
			  var month=jQuery("#month").val();
			  var year=jQuery("#year").val();
			  var data =
			  {		
				month	 : month,
				year		 : year
			  }
			jQuery.ajax({	
							type: "POST",
							url: "monthly-order.php",
							data: data,
							success: function(responce){
								$("#MtxtHint").after(responce);
						  }	
					 });
		  });
		});
		</script>
		<!-- Ajax Month Wish Search Scripts-->
		<script type="text/javascript">
		$(document).ready(function(){
		  $("#monthly_report2").click(function(){
			  var month=jQuery("#month").val();
			  var year=jQuery("#year").val();
			  var data =
			  {		
				month	 : month,
				year		 : year
			  }
			jQuery.ajax({	
							type: "POST",
							url: "monthly-order2.php",
							data: data,
							success: function(responce){
								$("#MtxtHint2").after(responce);
						  }	
					 });
		  });
		});
		</script>
	</head>
	
	<body>
		<header>
			<div class="top_bar">
				<div class="top_bar_left">
					<h1>Welcome <span style="color:#FFFFFF"><?php echo $_SESSION['sub_name'];?></span> ! To Our <?php echo $_SESSION['restaurant_name'];?> </h1>
				</div>
				<div class="top_bar_right">
					<ul class="navigation">
						<li class="highlight"><a href="index.php">Home</a></li>
						<li><a href="logout.php">Log Out</a></li>
					</ul>
				</div>
			</div>
		</header>