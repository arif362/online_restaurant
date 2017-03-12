<?php
include("config.php");
$mem_email=$_SESSION['mem_email'];
?>

<?php
if(isset($_REQUEST['message_id'])) 
{
	$id = $_REQUEST['message_id'];
	
	$statement = $db->prepare("UPDATE message SET recipent_status='2' WHERE message_id=?");
	$statement->execute(array($id));
	
	$success_message1 = "Message has been deleted successfully.";
	
	header('Location:view-message.php');
	
}
?>

<?php
	$statement = $db->prepare("SELECT count(*) as active_status from message WHERE recipent_email='$mem_email' and recipent_status='1' and active_status='0' ");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $row)
	
			{
				$unread_message= $row['active_status'];
			
			}
?>
<h2>View Unread Inbox Message (<?php echo $unread_message;?>)</h2>
<p>&nbsp;</p>
<?php
if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
?>
<table class="tbl2" width="100%">
	<tr>
		<th width="5%">Serial</th>
		<th width="10%">Date</th>
		<th width="20%">Name</th>
		<th width="20%">Sender Email</th>
		<th width="20%">Subject</th>
		<th width="10%">Action</th>
	</tr>
	
	<?php
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM message WHERE recipent_email='$mem_email' and recipent_status='1' ORDER BY message_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 50;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM message WHERE recipent_email='$mem_email' and recipent_status='1' ORDER BY message_id DESC LIMIT $start, $limit");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	
	
	foreach($result as $row)
	
	{		
					
			
		$i++;
		?>
			
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row['send_date']; ?></td>
		<td><?php echo $row['sender_name']; ?></td>
		<td><?php echo $row['sender_email']; ?></td>
		<td><?php echo $row['sender_subject'];; ?></td>
		<td>
			<a href="read-message.php?message_id=<?php echo $row['message_id']; ?> ">View</a>
			&nbsp;|&nbsp;
			<a onclick='return confirm_delete();' href="view-inbox-message.php?message_id=<?php echo $row['message_id']; ?>"><img src="../images/delete.gif"></a></td>
		</tr>
		
		<?php
	}
	?>
	
</table>