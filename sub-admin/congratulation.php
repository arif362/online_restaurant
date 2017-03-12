<?php
if(isset($_SESSION['admin_id']))
{
	$admin_id=$_SESSION['admin_id'];	
}
else if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
}
else if(isset($_SESSION['name'])) {
	$name = $_SESSION['name'];
}
else {
	header('location:../index.php');
}
include("../config.php");
?>


<section class="notif notif-notice">
      <h6 class="notif-title">Congratulations!</h6>
      <p><b><?php echo $_SESSION['name'];?> !</b> You are successfully Sign In To Our Restaurant. </p>
</section>