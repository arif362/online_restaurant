<?php
include("config.php");
?>


<?php
if(isset($_POST['send_message']))
{
	try {
		
		if(empty($_POST['email'])) {
			throw new Exception("Recipent Email can not be empty.");
		}
	
		$send_date = date('d-m-Y');
		$send_status=1;
		$recipent_status=1;
		
		$statement = $db->prepare("INSERT INTO message(employee_id,sender_name,sender_email,recipent_email,sender_subject,sender_message,send_date,send_status,recipent_status) VALUES(?,?,?,?,?,?,?,?,?) ");
		$statement->execute(array($_POST['employee_id'],$_POST['name'],$_POST['sender_email'],$_POST['email'],$_POST['subject'],$_POST['message'],$send_date,$send_status,$recipent_status));
		
		$success_message1 = "Message has been Send successfully.";
		
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
								<h2>Send Message</h2>
				<br>
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
			
		
					<form action="" method="post" enctype="multipart/form-data">
									
									<table class="tbl1">
									<tr><td><input type="hidden" value="<?php echo $_SESSION['employee_id'];?>" name="employee_id"></td></tr>
										<tr>
											<td>Your Name</td>
										</tr>
										<tr>
											<td><input class="medium" type="text" name="name" placeholder="Write Your Name"></td>
										</tr>
										
										<tr>
											<td><input type="hidden" value="<?php echo $_SESSION['emp_email'];?>" name="sender_email"></td>
										</tr>
										<tr>
											<td>Recipent Email</td>
										</tr>
										<tr>
											<td><input class="medium" type="text" name="email" placeholder="Write Recipent Email"></td>
										</tr>
										<tr>
											<td>Subject</td>
										</tr>
										<tr>
											<td><input class="medium" type="text" name="subject" placeholder="Write Subject"></td>
										</tr>
										<tr>
											<td>Message</td>
										</tr>
										<tr>
										<td>
										<textarea name="message" cols="60" rows="10"></textarea>
										</td>
										</tr>
									</table>
								
							<input type="submit" value="SEND" name="send_message">
									
					</form>

			</br>
				</div>
			</div>


		</content>
		

<?php include('footer.php');?>