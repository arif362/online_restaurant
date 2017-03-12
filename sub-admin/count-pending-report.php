<?php
include("config.php");
?>
<?php
			$statement = $db->prepare("SELECT count(*) as status from order_list WHERE status='0' ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row)
	
			{
				$pending_order= $row['status'];
			}
		
				echo 'Total Pending Order: '.$pending_order;
	
			
	?>