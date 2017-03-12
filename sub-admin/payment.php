<?php
include("config.php");
?>


<?php
if(isset($_POST['add_payment']))
{
	try {
		

		if(empty($_POST['payment_types'])) {
			throw new Exception("Payment Types can not be empty.");
		}
		if(empty($_POST['payment'])) {
			throw new Exception("Payment Number can not be empty.");
		}
		$statement = $db->prepare("SELECT * FROM payment WHERE payment_types=?");
		$statement->execute(array($_POST['payment']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Payment Name already exists.");
		}
		
		$add_date = date('d-m-Y');
		
		$statement = $db->prepare("INSERT INTO payment(admin_id,payment_types,payment,date) VALUES(?,?,?,?)");
		$statement->execute(array($_POST['admin_id'],$_POST['payment_types'],$_POST['payment'],$add_date));
		
		$success_message1 = "Payment System has been Add successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
		
}


?>



<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					<?php include('sidebar-menu.php');?>
				</div>
				<div class="content_part_right">
								<h2>Add Payment</h2>
				<br>
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
			
		
					<form action="" method="post" enctype="multipart/form-data">
									
									<table class="tbl1">
									<tr><td><input type="hidden" value="<?php echo $_SESSION['admin_id'];?>" name="admin_id"></td></tr>
									<tr>
				
										<tr>
											<td>Add Payment Types</td>
										</tr>
										<tr>
											<td><input class="short" type="text" name="payment_types" placeholder="Payment Types"></td>
										</tr>
										<tr>
											<td>Add Payment Number</td>
										</tr>
										<tr>
											<td><input class="short" type="text" name="payment" placeholder="Payment Number"></td>
										</tr>
									</table>
							
							<input class="submit_p" type="submit" value="SAVE" name="add_payment">
									
					</form>

			</br>
			<?php include('view-payment.php');?>
				</div>
			</div>


		</content>
		

<?php include('footer.php');?>