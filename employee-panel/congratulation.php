<?php
if(isset($_SESSION['employee_id']))
{
	$employee_id=$_SESSION['employee_id'];	
}
else if(isset($_SESSION['employee_username'])) {
	$employee_username = $_SESSION['employee_username'];
}
else if(isset($_SESSION['employee_name'])) {
	$employee_name = $_SESSION['employee_name'];
}
else {
	header('location:../index.php');
}
include("../config.php");
?>

<section class="notif notif-notice">
      <h6 class="notif-title">Congratulations!</h6>
      <p><b><?php echo $_SESSION['employee_name'];?> !</b> You are successfully Sign In To Our Restaurant. </p>
</section>