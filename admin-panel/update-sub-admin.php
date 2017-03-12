<?php
include('config.php');
?>
<?php

if(isset($_REQUEST['restaurant_id'])) {

	$restaurant_id = $_REQUEST['restaurant_id'];
}
?>
<?php

if(isset($_POST['update_sub_admin'])) {
	
		$sub_name = $_POST['name'];
		$restaurant_name = $_POST['restaurant_name'];
		$sub_username = $_POST['username'];
		$sub_email = $_POST['email'];
		$sub_address = $_POST['address'];
		$sub_mobile = $_POST['mobile'];
		$sub_birthday = $_POST['birthday'];;
		$sub_sex = $_POST['sex'];
		$sub_types = $_POST['admin_types'];
		$sub_password = $_POST['password'];
		
	
		 $emailCHecker = mysql_real_escape_string($sub_email);
		 $emailCHecker = str_replace("`", "", $emailCHecker);
		 
	   // Database duplicate username check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT sub_username FROM sub_admin WHERE sub_username=?");
		 $statement->execute(array($sub_username));
		 $uname_check = $statement->rowCount();
		 
		 // Database duplicate e-mail check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT sub_email FROM sub_admin WHERE sub_email=?");
		 $statement->execute(array($emailCHecker));
		 $email_check = $statement->rowCount();
		 
		 // Database duplicate mobile check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT sub_mobile FROM sub_admin WHERE sub_mobile=?");
		 $statement->execute(array($sub_mobile));
		 $mobile_check = $statement->rowCount();
	 
	try {

		
		//duplicate username check 
		if ($uname_check > 0)  {
			throw new Exception('Your User Name is already in use inside of our system. Please try another.');
		}
		
		if(!(preg_match("/^[A-Za-z][A-Za-z0-9]{3,21}$/", $sub_username))) {
			throw new Exception('Please Enter The Valid User Name');
		}
		

		
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $sub_email))) {
			throw new Exception('Please Enter Valid email address');
		}
		//duplicate email check 
		if ($email_check > 0){
			throw new Exception('Your Email address is already in use inside of our system. Please use another');
		}
		
		if(empty ($_POST['mobile'])) {
			throw new Exception('Mobile Number can not be empty');
		}	
		//duplicate mobile check 
		if ($mobile_check > 0)  {
			throw new Exception('Your Mobile is already in use inside of our system. Please try another.');
		}
	

		
		//user login password convert md5 mode
		$password = md5($sub_password);
		$add_date = date('d-m-Y');
		
		$status = '1';
		
		include('config.php');
			
		//for restaurant image 
			
		$uploaded_file = $_FILES["restaurant_logo"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $sub_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["restaurant_logo"]["tmp_name"],"../photo/restaurant/" . $f1);
		
		//for sub-admin image 
			
		$uploaded_file = $_FILES["sub_admin_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f2 = $sub_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["sub_admin_pic"]["tmp_name"],"../photo/admin/" . $f2);
		//for Sign image 
			
		$uploaded_file = $_FILES["sub_sign"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f3 = $sub_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["sub_sign"]["tmp_name"],"../photo/signature/" . $f3);
		
		
		
		//for sub-admin insert sql	
		$statement = $db->prepare("UDATE sub_admin SET sub_name=?,restaurant_name=?,sub_username=?,sub_email=?,sub_address=?,sub_mobile=?,sub_birthday=?,sub_sex=?,sub_types=?,sub_password=?,restaurant_logo=?,sub_pic=?,sub_sign,sub_add_date=?,sub_status=? WHERE restaurant_id=?");
		$statement->execute(array($sub_name,$restaurant_name,$sub_username,$sub_email,$sub_address,$sub_mobile,$sub_birthday,$sub_sex,$sub_types,$password,$f1,$f2,$f3,$add_date,$status,$restaurant_id));
		
		$success_message ='Sub-Admin Updated is Complete Successfully.';
	
	
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
					<h2>Add Sub-Admin</h2>
		<p>&nbsp;</p>
		<?php
		if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
		if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
		?>
			<?php
		$statement = $db->prepare("SELECT * FROM sub_admin WHERE restaurant_id=? ");
			$statement->execute(array($restaurant_id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
			
		{	
		?>
		<form class="form_part" action="" method="post" enctype="multipart/form-data">
			<table class="tbl1">
					
			<tr>
				<td>Name</td>
				<td><input class="medium2" type="text" name="name" value="<?php echo $row['sub_name'];?>"></td>
			</tr>
				
			<tr>
				<td>Hospital Name</td>
				<td><input class="medium2" type="text" name="restaurant_name" value="<?php echo $row['restaurant_name'];?>"></td>
			</tr>
			
			<tr>
				<td>User Name</td>
				<td><input class="medium2" type="text" name="username" value="<?php echo $row['sub_username'];?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input  class="medium2" type="text" name="email" value="<?php echo $row['sub_email'];?>"></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input  class="medium2" type="text" name="address" value="<?php echo $row['sub_address'];?>"></td>
			</tr>
			<tr>
				<td>Mobile No</td>
				<td><input  class="medium2" type="text" name="mobile" value="<?php echo $row['sub_mobile'];?>"></td>
			</tr>
			
			<tr>
			<td>Select Birthday</td>
					<td>	
						<input  class="medium2" type="text" name="birthday" value="<?php echo $row['sub_birthday'];?>">	
					</td>
			</tr>
			<tr>
			<td>Gender</td>
				<td>
					<select name="sex" class="short">
						<option value="<?php echo $row['sub_sex'];?>"> <?php echo $row['sub_sex'];?></option>
						<option> -------- Select Gender ---------</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Admin Types</td>
				<td>
				
					<select name="admin_types" class="short">
						<option value="<?php echo $row['sub_types'];?>"> <?php echo $row['sub_types'];?></option>
						<option> ------- Select Admin Types --------</option>
						<option value="Sub-Admin">Sub-Admin</option>
						<option value="Manager">Manager</option>
							
					</select>
				</td>
			</tr>
		
		
			<tr>
				<td>Enter Passowrd</td>
				<td><input  class="medium2" type="password" name="password" placeholder="Password"></td>
			</tr>
			<tr>
				<td>Restaurant Logo Images</td>
				<td><input type="file" name="restaurant_logo"></td>
			</tr>	
			<tr>
				<td>Admin Profile Picture</td>
				<td><input type="file" name="sub_admin_pic"></td>
			</tr>
			<tr>
				<td>Admin Sign Images</td>
				<td><input type="file" name="sub_sign"></td>
			</tr>	
			<tr>
				<td><input class="short" type="submit" value="SAVE" name="update_sub_admin"></td>
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