<?php
include("config.php");
$emp_email=$_SESSION['emp_email'];
?>
<?php
			$statement = $db->prepare("SELECT count(*) as active_status from message WHERE recipent_email='$emp_email' and recipent_status='1' and active_status='0' ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row)
	
			{
				$unread_message= $row['active_status'];
			}
		
				echo 'Total Unread Message: '.$unread_message;
	
			
	?>