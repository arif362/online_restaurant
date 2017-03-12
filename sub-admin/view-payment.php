<?php

include("../config.php");
?>

<?php

if(isset($_POST['form2']))
{
	try {
		
		if(empty($_POST['payment_types'])) {
			throw new Exception("Payment Types can not be empty.");
		}
		
		$statement = $db->prepare("UPDATE payment SET payment_types=?,payment=? WHERE payment_id=?");
		$statement->execute(array($_POST['payment_types'],$_POST['payment'],$_POST['hdn']));
		
		$success_message2 = "Payment Types has been Updated successfully.";
	
	}
	catch(Exception $e) {
		$error_message2 = $e->getMessage();
	}
		
}

if(isset($_REQUEST['payment_id'])) 
{
	$id = $_REQUEST['payment_id'];
	
	$statement = $db->prepare("DELETE FROM payment WHERE payment_id=?");
	$statement->execute(array($id));
	
	$success_message3 = "Payment Types has been deleted successfully.";
	header("Location:payment.php");
}

?>


								<h2>View/Edit Payment System</h2>
				<?php
				if(isset($error_message2)) {echo "<div class='error'>".$error_message2."</div>";}
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				if(isset($success_message3)) {echo "<div class='success'>".$success_message3."</div>";}
				?>
				<table class="tbl2" width="100%">
					<tr>
						<th width="10%">ID</th>
						<th width="30%">Payment Types</th>
						<th width="30%">Payment Number</th>
						<th width="15%">Action</th>
					</tr>
					
					<?php
					$i=0;
					$statement = $db->prepare("SELECT * FROM payment ORDER BY payment_id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
						$i++;
						?>
							
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row['payment_types']; ?></td>
					<td><?php echo $row['payment']; ?></td>
					<td>
						<a class="fancybox" href="#inline<?php echo $i; ?>"><img src="../images/edit.gif"></a>
						<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
							<h3>Edit Payment System</h3>
							<p>
								<form action="" method="post">
									<input type="hidden" name="hdn" value="<?php echo $row['payment_id']; ?>">
									<table>
										<tr>
											<td>Payment Types</td>
										</tr>
										<tr>
											<td><input type="text" name="payment_types" value="<?php echo $row['payment_types']; ?>">  </td>
										</tr>
										<tr>
											<td>Payment Number</td>
										</tr>
										<tr>
											<td><input type="text" name="payment" value="<?php echo $row['payment']; ?>">  </td>
										</tr>
										<tr>
											<td><input type="submit" value="UPDATE" name="form2"></td>
										</tr>
									</table>
								</form>
							</p>
						</div>
						&nbsp;|&nbsp;
						<a  onclick='return confirm_delete();' href="view-payment.php?payment_id=<?php echo $row['payment_id']; ?>"><img src="../images/delete.gif"></a>
					</td>
					</tr>
					
					<?php
					}
					?>
				</table>

			</br>
			