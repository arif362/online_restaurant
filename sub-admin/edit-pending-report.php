<?php

include("config.php");
?>

<?php

if(isset($_REQUEST['sr_id'])) {

	$sr_id = $_REQUEST['sr_id'];
}
?>
<?php

if(isset($_POST['edit_send_report']))
{
	
	try {
		 if(empty($_POST['p_id'])) {
			throw new Exception("Patient ID can not be empty.");
			
			
		}
			$statement = $db->prepare("SHOW TABLE STATUS LIKE 'send_report'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
				$new_id = $row[10];
			
			$uploaded_file = $_FILES["disease_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $new_id. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.PNG')&&($file_ext!='.jpg')&&($file_ext!='.JPG')&&($file_ext!='.jpeg')&&($file_ext!='.JEPG')&&($file_ext!='.GIF')&&($file_ext!='.gif'))
			throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
			move_uploaded_file($_FILES["disease_pic"]["tmp_name"],"../photo/disease/" . $f1);
			
		$add_date = date('d-m-Y', time());
		$active=0;
		
		$statement = $db->prepare("UPDATE send_report SET disease_pic=?,p_id=?,p_name=?,p_age=?,p_sex=?,test_name=?,ref_doctor=?,doctor_id=?,admin_id=?,send_date=?,status=? WHERE sr_id=?");
		$statement->execute(array($f1,$_POST['p_id'],$_POST['p_name'],$_POST['p_age'],$_POST['p_sex'],$_POST['test_name'],$_POST['ref_doctor'],$_POST['doctor_id'],$_POST['admin_id'],$add_date,$active,$sr_id));
		
		$success_message = "Edit Report has been Send successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
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
			<h2>Edit Send Report</h2>
				<p>&nbsp;</p>
				<?php
				if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
				if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
				?>
				
				<?php	
				$statement = $db->prepare("SELECT doctor_list.doctor_id,doctor_list.doctor_name,doctor_list.doc_speciality,doctor_list.doc_sign,sr_id,disease_pic,p_id,p_name,p_age,p_sex,test_name,ref_doctor,status,send_date,report,reply_date FROM doctor_list,send_report WHERE doctor_list.doctor_id=send_report.doctor_id and status='0' and sr_id=? ");
				$statement->execute(array($sr_id));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
				
				foreach($result as $row)
				
				{		
						
				?>
				
				<form class="form_part" action="" method="post" enctype="multipart/form-data">
					<table class="tbl1">
						<tr><td><input type="hidden" value="<?php echo $_SESSION['admin_id'];?>" name="admin_id"></td></tr>
						<tr>
						<td>Previous Image</td>
							<td><a href="../photo/disease/<?php echo $row['disease_pic'];?>" alt="No image found" target="_blank"> <img src="../photo/disease/<?php echo $row['disease_pic'];?>" width="220"; height="200"> </a></td>
						</tr>
						<tr>
							<td class="profile_image"><strong>Disease Image &nbsp;&nbsp;&nbsp;</strong><input type="file" value="<?php echo $row['disease_pic'];?>" name="disease_pic" ></td>
						</tr>
						<tr>
							<td>Patient ID</td>
							<td><input class="medium2" type="text" value="<?php echo $row['p_id']; ?>"  name="p_id"></td>
						</tr>
			
						<tr>
							<td>Patient Name</td>
							<td><input type="text"  value="<?php echo $row['p_name']; ?>" class="medium2" name="p_name"></td>
						</tr>
						<tr>
							<td>Patient Age</td>
							<td><input type="text" value="<?php echo $row['p_age']; ?>"  name="p_age"></td>
						</tr>
						<tr>
							<td>Patient Sex</td>
							<td>
								<select class="medium2" name="p_sex" >							
									<option value="<?php echo $row['p_sex']; ?>"><?php echo $row['p_sex']; ?></option>			
									<option value="Male">Male</option>	
									<option value="Male">Female</option>	
											
								</select>

							</td>
						</tr>
						<tr>
							<td>Test Name</td>
							<td><input type="text" value="<?php echo $row['test_name']; ?>" class="medium2" name="test_name"></td>
						</tr>
						<tr>
							<td>Reference Doctor</td>
							<td><input type="text" value="<?php echo $row['ref_doctor']; ?>" class="medium2" name="ref_doctor"></td>
						</tr>
						<tr>
							<td>Report Send to Doctor</td>
							<td>
								<select class="medium2" name="doctor_id"  id="doctor_id">
								<option value="<?php echo $row['doctor_id']?> "> <?php echo $row['doctor_name']; ?></option>
								<option> --- Select Doctor ---</option>
									<?php
										$statement = $db->prepare("SELECT * FROM doctor_list  ORDER BY doctor_id DESC");
										$statement->execute();
										$result = $statement->fetchAll(PDO::FETCH_ASSOC);
										foreach($result as $row)
										{
										$doctor_id=$row['doctor_id'];
										$doctor_name=$row['doctor_name'];
										?>
										<option value="<?php echo $row['doctor_id']; ?>"><?php echo $row['doctor_name']; ?></option>	
										
									<?php
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
						<td></td>
						<td><div id="doctor"></div></td>
						</tr>
						<tr>
							<td><input type="submit" value="SAVE" name="edit_send_report"></td>
						</tr>
					</table>	
				</form>
			<?php
			}
			?>
					
				</div>
			</div>
		</content>
		
<?php include('footer.php');?>	