<?php 
include('config.php');

$payment_types = $_GET['payment_types'];

$statement = $db->prepare("SELECT * FROM payment WHERE payment_types='$payment_types' ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
		{
			$payment_types=$row['payment_types'];
			$payment=$row['payment'];
			
			?>
		
			Payment Number: <input type="hidden" name="payment" value="<?php echo $row["payment"]; ?>"><?php echo $row["payment"]; ?><br>
		
			<?php
		}
				
			
?>