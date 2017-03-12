<?php

if(isset($_POST['login'])) 
{
	
	try {
	
		
		if(empty($_POST['username'])) {
			throw new Exception('Username can not be empty');
		}
		
		if(empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
		}
		
		if(empty ($_POST['user_type'])) {
			throw new Exception('User Type can not be empty');
		
		}
		
		$password = $_POST['password']; // admin
		$password = md5($password);
	
		include('config.php');
		
		if($_POST['user_type']=='Admin')
		{	
		$num=0;	
		$statement = $db->prepare("SELECT * FROM admin WHERE username=?  and password=?");
		$statement->execute(array($_POST['username'],$password));		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$num = $statement->rowCount();
		
		if($num>0) 
		{
			foreach($result as $row)
			{
			session_start();
			$admin_id = $row["admin_id"];
			$_SESSION['admin_id'] = $admin_id;
			$username = $row["username"];
			$_SESSION['username'] = $username;
			$name = $row["name"];
			$_SESSION['name'] = $name;
			$email = $row["email"];
			$_SESSION['email'] = $email;
			
			header("location: admin-panel/index.php");
			}
		}
		else
		{
			throw new Exception('Invalid Use Name or password');
		}
		}
		else if($_POST['user_type']=='Manager')
		{
		$num=0;	
		$statement = $db->prepare("SELECT * FROM sub_admin WHERE sub_username=?  and sub_password=?");
		$statement->execute(array($_POST['username'],$password));		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$num = $statement->rowCount();
		
		if($num>0) 
		{
			foreach($result as $row)
			{
			session_start();
			$restaurant_id = $row["restaurant_id"];
			$_SESSION['restaurant_id'] = $restaurant_id;
			$sub_username = $row["sub_username"];
			$_SESSION['suv_username'] = $sub_username;
			$sub_name = $row["sub_name"];
			$_SESSION['sub_name'] = $sub_name;
			$restaurant_name = $row["restaurant_name"];
			$_SESSION['restaurant_name'] = $restaurant_name;
			$sub_email = $row["sub_email"];
			$_SESSION['sub_email'] = $sub_email;
			
			header("location: sub-admin/index.php");
			}
		}
		else
		{
			throw new Exception('Invalid Use Name or password');
		}
		}
		else if($_POST['user_type']=='Employee')
		{
		$num=0;	
		$statement = $db->prepare("SELECT * FROM employee_list WHERE emp_username=?  and emp_password=?");
		$statement->execute(array($_POST['username'],$password));		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$num = $statement->rowCount();
		
		if($num>0) 
		{
			foreach($result as $row)
			{
			session_start();
			$employee_id = $row["employee_id"];
			$_SESSION['employee_id'] = $employee_id;
			$emp_username = $row["emp_username"];
			$_SESSION['emp_username'] = $emp_username;
			$employee_name = $row["employee_name"];
			$_SESSION['employee_name'] = $employee_name;
			$emp_email = $row["emp_email"];
			$_SESSION['emp_email'] = $emp_email;
			
			header("location: employee-panel/index.php");
			}
		}
		else
		{
			throw new Exception('Invalid Use Name or password');
		}
		}
		else if($_POST['user_type']=='Member')
		{
		$num=0;	
		$statement = $db->prepare("SELECT * FROM member_list WHERE mem_username=?  and mem_password=? and mem_status='1'");
		$statement->execute(array($_POST['username'],$password));		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$num = $statement->rowCount();
		
		if($num>0) 
		{
			foreach($result as $row)
			{
			session_start();
			$member_id = $row["member_id"];
			$_SESSION['member_id'] = $member_id;
			$mem_username = $row["mem_username"];
			$_SESSION['mem_username'] = $mem_username;
			$member_name = $row["member_name"];
			$_SESSION['member_name'] = $member_name;
			$mem_email = $row["mem_email"];
			$_SESSION['mem_email'] = $mem_email;
			$mem_address = $row["mem_address"];
			$_SESSION['mem_address'] = $mem_address;
			$mem_mobile = $row["mem_mobile"];
			$_SESSION['mem_mobile'] = $mem_mobile;
			
			header("location: member/index.php");
			}
		}
		
		else
		{
			throw new Exception('Invalid Use Name or password');
		}
		}
	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}

?>


<!DOCTYPE html>
<html lang="en"> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Restaurant Login Form</title>
   <link  rel="shortcut icon" type="image/icon" href="images/icons.png" />
  <link rel="stylesheet" type="text/css" href="css/login_style.css">
  
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to Our Restaurant</h1>
	  
      <form method="post" action="">
		<?php 
			if(isset($error_message))
			{
				echo "<div class='error'>".$error_message."</div>";
			}
		?>
        <p><input type="text" name="username" placeholder="Username"></p>
        <p><input type="password" name="password"  placeholder="Password"></p>
		<p>
		<select name="user_type">
			<option> --- Select One ---</option>
			<option value="Admin">Admin</option>
			<option value="Manager">Manager</option>
			<option value="Employee">Employee</option>
			<option value="Member">Member</option>
		</select>
		</p>
		<div class="user_login">
			<div class="admin_login">
				<input type="submit" name="login" value="Login">
			</div>
		</div>
      </form>
    </div>

  </section>

  <section class="about">
    <p class="about_author">
      &copy; 2015&ndash;2016 <a href="" target="_blank">City Restaurant.</a>
      <br>
      Developed by <a href="" target="_blank">Jannat & Samin</a>
	 </p>
  </section>
</body>
</html>