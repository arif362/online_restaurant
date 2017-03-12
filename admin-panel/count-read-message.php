<?php
include("config.php");
?>
<?php
			$statement = $db->prepare("SELECT count(*) as active_status from message WHERE recipent_email='$email' and recipent_status='1' and active_status='1' ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row)
	
			{
				$read_message= $row['active_status'];
			}
		
				echo 'Total Read Message: '.$read_message;
	
			
	?>