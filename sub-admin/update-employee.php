
<?php
include('config.php');
?>
<?php

if(isset($_REQUEST['employee_id'])) {

	$employee_id = $_REQUEST['employee_id'];
}
?>

<?php

if(isset($_POST['update_employee'])) {
	
		$employee_name = $_POST['name'];
		$emp_username = $_POST['username'];
		$emp_email = $_POST['email'];
		$emp_address = $_POST['address'];
		$emp_mobile = $_POST['mobile'];
		$emp_birthday = $_POST['birthday'];
		$emp_sex = $_POST['sex'];
		$emp_designation = $_POST['designation'];
		$emp_salary = $_POST['salary'];
		$emp_jdate = $_POST['joining_date'];
		$emp_duty_hour = $_POST['duty_hour'];
		$emp_off_day = $_POST['off_day'];
		$emp_password = $_POST['password1'];
		
	
	
	 
	try {
	

		//user login password convert md5 mode
		$password = md5($emp_password);
		$add_date = date('d-m-Y');
		
		$status = '1';
		
		include('config.php');
			
		//for emptor image 
			
		$uploaded_file = $_FILES["emp_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $emp_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["emp_pic"]["tmp_name"],"../photo/employee/" . $f1);
		
		
		//for emptor insert sql	
		$statement = $db->prepare("UPDATE employee_list  SET  employee_name=?,emp_username=?,emp_email=?,emp_address=?,emp_mobile=?,emp_birthday=?,emp_sex=?,emp_designation=?,emp_salary=?,emp_jdate=?,emp_duty_hour=?,emp_off_day=?,emp_password=?,emp_pic=?,emp_add_date=?,emp_status=? WHERE employee_id=?");
		$statement->execute(array($employee_name,$emp_username,$emp_email,$emp_address,$emp_mobile,$emp_birthday,$emp_sex,$emp_designation,$emp_salary,$emp_jdate,$emp_duty_hour,$emp_off_day,$password,$f1,$add_date,$status,$employee_id));
		
		$success_message ='Employee Profile has been Update Successfully.';
	
	
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
					<h2>Edit Employee</h2>
		<p>&nbsp;</p>
		<?php
		if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
		if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
		?>
		<?php
		$statement = $db->prepare("SELECT * FROM employee_list WHERE employee_id=? ");
			$statement->execute(array($employee_id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
			
			{	
		?>	
		<form class="form_part" action="" method="post" enctype="multipart/form-data">
			<table class="tbl1">
					
			<tr>
				<td>Employee Name</td>
				<td><input class="medium2" type="text" name="name" value="<?php echo $row['employee_name'];?>"></td>
			</tr>
				
			
			<tr>
				<td>User Name</td>
				<td><input class="medium2" type="text" name="username"  value="<?php echo $row['emp_username'];?>" ></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input  class="medium2" type="text" name="email"  value="<?php echo $row['emp_email'];?>"></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input  class="medium2" type="text" name="address"  value="<?php echo $row['emp_address'];?>"></td>
			</tr>
			<tr>
				<td>Mobile No</td>
				<td><input  class="medium2" type="text" name="mobile"  value="<?php echo $row['emp_mobile'];?>"></td>
			</tr>
			<tr>
				<td>Birthday</td>
				<td><input  class="medium2" type="text" name="birthday"  value="<?php echo $row['emp_birthday'];?>"></td>
			</tr>
			<tr>
			
			<tr>
			<td>Gender</td>
				<td>
					<select name="sex" class="short">
						<option value="<?php echo $row['emp_sex'];?>"><?php echo $row['emp_sex'];?></option>
						<option> -------- Select emptors Gender ---------</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</td>
			</tr>
			<tr>
			<td>Designation</td>
				<td>
					<select name="designation" class="short">
						<option value="<?php echo $row['emp_designation']; ?>"><?php echo $row['emp_designation']; ?></option>	
						<option> --- Select Designation ---</option>
						<option value="Waiter"> Waiter </option>
						<option value="Cooker"> Cooker </option>
						<option value="Cleaner"> Cleaner </option>
						
					</select>
				</td>
			</tr>
			<tr>
				<td>Salary</td>
				<td><input class="short" type="text" name="salary" value="<?php echo $row['emp_salary'];?>" placeholder="Net Salary"></td>
			</tr>
			<tr>
				<td>Joining Date</td>
				<td><input class="short tcal" type="text" name="joining_date" value="<?php echo $row['emp_jdate'];?>" placeholder="Joining Date"></td>
			</tr>
			<tr>
			<td>Duty Hour</td>
				<td>
					<select name="duty_hour" class="short">
					<option value="<?php echo $row['emp_duty_hour'];?>"> <?php echo $row['emp_duty_hour'];?></option>
						<option> --- Select Duty Hours ---</option>
						<option value="9.00AM - 5.00PM"> 9.00AM - 5.00PM </option>
						<option value="9.00AM - 9.00PM"> 9.00AM - 9.00PM </option>
						
					</select>
				</td>
			</tr>
			<tr>
			<td>Off Day</td>
				<td>
					<select name="off_day" class="short">
					<option value="<?php echo $row['emp_off_day'];?>"> <?php echo $row['emp_off_day'];?></option>
						<option> --- Select Off Day ---</option>
						<option value="Friday"> Friday </option>
						<option value="Saturday"> Saturday </option>
						
					</select>
				
				</td>
			</tr>
		
			<tr>
				<td>Enter Passowrd</td>
				<td><input  class="medium2" type="password" name="password1" ></td>
			</tr>
			
			<tr>
				<td>Employee Profile Picture</td>
				<td><input type="file" name="emp_pic"></td>
			</tr>
				
			<tr>
				<td><input class="short" type="submit" value="SAVE" name="update_employee"></td>
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