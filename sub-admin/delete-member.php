<?php

include("config.php");
?>

<?php
if(isset($_REQUEST['member_id'])) 
{
	$id = $_REQUEST['member_id'];
	
	$statement = $db->prepare("DELETE FROM member_list WHERE member_id=?");
	$statement->execute(array($id));
	
	$success_message3 = "Employee has been deleted successfully.";
	
	header("Location:view-member.php");
}
?>

