<?php
include("config.php");
 

if(isset($_REQUEST['message_id'])) 
{
	$id = $_REQUEST['message_id'];
	
	$statement = $db->prepare("UPDATE message SET active_status='1' WHERE message_id=?");
	$statement->execute(array($id));
		
}
?>

<?php
include('header.php');
?>
		
	<style>
		#pop{
			width: 960px; margin: 0px auto;
			margin-top:10px;
			margin-bottom:10px;
			border:2px solid;
			background:#FFFFFF;
		}
		#close{
			right:5px;
			top:5px;
			float:right;
			courser:pointer;
		}
		button{padding:5px; courser:pointer;}
	</style>
		<content>
			<div class="content_part">
			<div id="pop">
			<a href="view-message.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a>
			
				<h2>Show Indox Message</h2></br>
				

			<?php
			include("config.php");	
			
			$statement = $db->prepare("SELECT * FROM message WHERE message_id='$id' and recipent_status='1' ORDER BY message_id DESC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
			
			foreach($result as $row)
			
			{		
							
			?>
				
							<table class="tbl1">
								<tr>
									<td><b>Send Date: </b><?php echo $row['send_date'];?></td>
								</tr>
								<tr>
									<td><b>Name: </b><?php echo $row['sender_name'];?></td>
								</tr>
								<tr>
									<td><b>Sender Email:</b> <?php echo $row['sender_email'];?></td>
								</tr>
								<tr>
									<td><b>Recipient Email:</b> <?php echo $row['recipent_email'];?></td>
								</tr>
								<tr>
									<td><b>Subject:</b> <?php echo $row['sender_subject'];?></td>
								</tr>
								<tr>
									<td><b>Message:</b></td>
								</tr>
								<tr>
									<td><?php echo $row['sender_message'];?></td>
								
								</tr>
							</table>

				
			<?php
			}
			?>
			</br>
			<a href="view-message.php"> << back </a>
			</div>
			</div>
		</content>

<?php include('footer.php');?>