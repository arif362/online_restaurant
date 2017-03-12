<?php
include("../config.php");
?>

<?php

if(isset($_REQUEST['employee_id'])) {

	$employee_id = $_REQUEST['employee_id'];
}
?>
	
<?php
include('config.php');

if(isset($_POST['update_employee'])) {
	
	$username = $_POST['username'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$sex = $_POST['sex'];
	$birthday = $_POST['birthday'];
	$joining_date = $_POST['joining_date'];
	$salary = $_POST['salary'];
	$designation = $_POST['designation'];
	$duty_hour = $_POST['duty_hour'];
	$off_day = $_POST['off_day'];
	$contact_number = $_POST['contact'];
	$account_number = $_POST['account_number'];
	$address = $_POST['address'];
	$password = $_POST['password'];
	
	try {
	
		$password = md5($password);
		$add_date = date('d-m-Y');
		
			$uploaded_file = $_FILES["employee_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["employee_pic"]["tmp_name"],"../uploads/" . $f1);
			
		
		$statement = $db->prepare("UPDATE employee_list SET  employee_pic=?, employee_name=?,  email=?, sex=?, birthday=?, contact_number=?, account_number=?,  address=?, employee_password=?, add_date=? WHERE employee_id=? and employee_username=?");
		$statement->execute(array($f1, $_POST['name'],$_POST['email'],$_POST['sex'],$birthday,$_POST['contact'],$_POST['account_number'],$_POST['address'],$password,$add_date,$employee_id,$username));
		
		$success_message = "Employee Profile has been changed successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}

?>
<!--Call Hearder-->  	
<?php include('header.php');?>
<div class="container">
	<div id="wrapper">
		<div id="container">
			<div id="sidebar">
				<ul class="navigation">
				<li class="highlight"><a href="index.php" class="button button-green">Dashboard</a></li>
				<li><a href="view-my-profile.php" class="button button-blue">View MY Profile</a></li>
				<li><a href="edit-employee.php" class="button button-orange">Edit MY Profile</a></li>
				<li><a href="logout.php" class="button button-gray">Logout</a></li>
				</ul>
				<p>&nbsp;</p>
			</div>
		<div id="content">
	<h2>Update MY Profile</h2>
		<p>&nbsp;</p>
		<?php
		if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
		if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
		?>
	<?php
				
					$statement = $db->prepare("SELECT employee_designation.designation_id,employee_designation.designation,employee_id,employee_pic,employee_name,employee_username,sex,birthday,joining_date,salary,email,duty_hour,off_day,account_number,address,account_number,contact_number FROM employee_designation,employee_list WHERE  employee_designation.designation_id=employee_list.designation_id ORDER BY employee_id DESC");
					$statement->execute(array($employee_id));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					
				foreach($result as $row)
				{
			
					$employee_pic = $row['employee_pic'];
					$name = $row['employee_name'];
					$username = $row['employee_username'];
					$sex = $row['sex'];
					$birthday = $row['birthday'];
					$joining_date = $row['joining_date'];
					$salary = $row['salary'];
					$designation_id=$row['designation_id'];
					$designation = $row['designation'];
					$duty_hour = $row['duty_hour'];
					$off_day = $row['off_day'];
					$contact_number = $row['contact_number'];
					$account_number = $row['account_number'];
					$address = $row['address'];
					$email = $row['email'];
				}
				?>
	<form action="" method="post" enctype="multipart/form-data">

			
		<table class="tbl1">
		
		<tr>
			<td>Add Images</td>
		</tr>
		<tr>
			<td><input type="file" name="employee_pic"></td>
		</tr>
		<tr>
			<td><input class="short" type="hidden" name="username" value="<?php echo $username;?>" placeholder="Name"></td>
		</tr>
		<tr>
			<td><input class="short" type="text" name="name" value="<?php echo $name;?>" placeholder="Name"></td>
		</tr>
		<tr>
			<td><input  class="short" type="text" name="email" value="<?php echo $email;?>"  placeholder="Email"></td>
		</tr>

		<tr>
			<td>
				<select name="sex" class="short">
					<option value="<?php echo $row['sex'];?>"><?php echo $sex;?></option>
					<option> --- Select Gender ---</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</td>
		</tr>
		</tr>
		<tr >
				<td><input  class="short" type="text" name="birthday" value="<?php echo $birthday;?>" placeholder="Birthday"></td>
				
		</tr>
		
		<tr>
			<td><input  class="short" type="text" name="contact" value="<?php echo $contact_number;?>" placeholder="Contact Number"></td>
		</tr>
		<tr>
			<td><input  class="short" type="text" name="account_number" value="<?php echo $account_number;?>" placeholder="Account Number"></td>
		</tr>
			
		<tr class="address">
			<td><textarea class="short" name="address" value="" placeholder="Address"><?php echo $address;?></textarea></td>
		</tr>
		<tr>
			<td><input  class="short" type="password" name="password" placeholder=" Change Password"></td>
		</tr>
	
		<tr>
			<td><input type="submit" value="SAVE" name="update_employee"></td>
		</tr>

		</table>

	</form>
		</div>
	</div>
	</div>
</div>

<?php include("footer.php"); ?>			