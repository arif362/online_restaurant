<!doctype html>


<html>
	<head>
		<title>City Restaurant</title>
		<link rel="shortcut icon" type="image/icon" href="images/icons.png">
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
			<a href="login.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a></br>
			<?php
include('config.php');

$email=$_GET['email'];
$confirm_code=$_GET['code'];

$statement = $db->prepare("SELECT * FROM member_list WHERE mem_email='$email' ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row)
			{
$db_code = $row['code'];

			}

			if ($confirm_code == $db_code)
			{
                              $statement = $db->prepare("UPDATE member_list SET code='0' WHERE mem_email='$email' ");
                              $statement->execute();
		
                                echo " <p>Your Confirmation Code is Active and Complete Your Member Registration Successfully now you can login your account.</p>";
			
			}
			else
			{
				echo "<p>You Email and Confirmation Code does not match</p>";
			}


?>

		
		</div>
	
	</body>

</html>	