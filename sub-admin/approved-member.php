<?php

include("config.php");
?>


<?php
if(isset($_REQUEST['member_id'])) 
{
	$member_id = $_REQUEST['member_id'];
		
		
		$active=1;
		
		$statement = $db->prepare("UPDATE member_list SET  mem_status=? WHERE member_id=? ");
		$statement->execute(array($active,$member_id));
		
		header("Location:view-member.php");
	}

?>

