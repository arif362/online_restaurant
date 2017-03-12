<?php
include("config.php");
?>
<?php
			$statement = $db->prepare("SELECT count(*) as status from order_list WHERE status='1' ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row)
	
			{
				$successful_order= $row['status'];
			}
		
				echo 'Total Successful Order: '.$successful_order;
	
			
	?>