
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
		$emp_username = $_POST['username'];	$emp_email = $_POST['email'];
		$emp_address = $_POST['address'];
		$emp_mobile = $_POST['mobile'];
		$emp_birthday = $_POST['birth_day']."-".$_POST['birth_month']."-".$_POST['birth_year'];
		$emp_sex = $_POST['sex'];
		$emp_password = $_POST['password1'];
		
	
		 $emailCHecker = mysql_real_escape_string($emp_email);
		 $emailCHecker = str_replace("`", "", $emailCHecker);
		 
	    $emailCHecker = mysql_real_escape_string($emp_email);
		 $emailCHecker = str_replace("`", "", $emailCHecker);
		 
	   // Database duplicate username check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT emp_username FROM employee_list WHERE emp_username=?");
		 $statement->execute(array($emp_username));
		 $uname_check = $statement->rowCount();
		 
		 // Database duplicate e-mail check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT emp_email FROM employee_list WHERE emp_email=?");
		 $statement->execute(array($emailCHecker));
		 $email_check = $statement->rowCount();
		 
		 // Database duplicate mobile check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT emp_mobile FROM employee_list WHERE emp_mobile=?");
		 $statement->execute(array($emp_mobile));
		 $mobile_check = $statement->rowCount();
	 
	try {
	

		//duplicate username check 
		if ($uname_check > 0)  {
			throw new Exception('Your User Name is already in use inside of our system. Please try another.');
		}
		
		if(!(preg_match("/^[A-Za-z][A-Za-z0-9]{3,21}$/", $emp_username))) {
			throw new Exception('Please Enter The Valid User Name');
		}
		
	
		
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $emp_email))) {
			throw new Exception('Please Enter Valid email address');
		}
		//duplicate email check 
		if ($email_check > 0){
			throw new Exception('Your Email address is already in use inside of our system. Please use another');
		}
		
	
		//duplicate mobile check 
		if ($mobile_check > 0)  {
			throw new Exception('Your Mobile is already in use inside of our system. Please try another.');
		}
	
		
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
		$statement = $db->prepare("UPDATE employee_list  SET  employee_name=?,emp_username=?,emp_email=?,emp_address=?,emp_mobile=?,emp_birthday=?,emp_sex=?,emp_password=?,emp_pic=?,emp_add_date=?,emp_status=? WHERE emptor_id=?");
		$statement->execute(array($employee_name,$emp_username,$emp_email,$emp_address,$emp_mobile,$emp_birthday,$emp_sex,$password,$f1,$add_date,$status,$employee_id));
		
		$success_message ='Employee Profile has benn Update Successfully.';
	
	
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
				<td>Enter Passowrd</td>
				<td><input  class="medium2" type="password" name="password1" ></td>
			</tr>
			
			<tr>
				<td>Emptor Profile Picture</td>
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