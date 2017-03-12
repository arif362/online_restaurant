<?php

include("config.php");
?>


<?php
if(isset($_REQUEST['order_id'])) 
{
	$order_id = $_REQUEST['order_id'];
		
		
		$active=1;
		$reply_date = date('d-m-Y');
		$time_zone = date_default_timezone_set("Asia/Dhaka");
		$reply_time = date("h:i:s A", time());
		
		$statement = $db->prepare("UPDATE order_list SET  reply_date=?, reply_time=?, status=? WHERE order_id=? ");
		$statement->execute(array($reply_date,$reply_time,$active,$order_id));
		
		header("Location:view-pending-order.php");
	}

?>

