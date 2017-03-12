<?php

include("config.php");
?>
<?php
if(isset($_REQUEST['member_id'])) 
{
	$id = $_REQUEST['member_id'];
	
	$statement = $db->prepare("DELETE FROM member_list WHERE member_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Employee has been deleted successfully.";
	
}
?>

<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					<?php include('sidebar-menu.php');?>
				</div>
				<div class="content_part_right">
					<h2>View Pending Member List</h2>
<p>&nbsp;</p>
	<form method="post" action="search-pending-member.php">	
		<label for="name">Search Pending Member: </label>
		<input type="text" name="search" placeholder="Member Id" />
		<button>Search</button>	
	</form>
<p>&nbsp;</p>	
<?php
if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
?>
<table class="tbl2" width="100%">
	<tr>
		<th width="5%">Serial</th>
		<th width="10%">Member Id</th>
		<th width="20%">Photo</th>
		<th width="20%">Name</th>
		<th width="20%">Mobile</th>
		<th width="20%">Action</th>
	</tr>
	
	<?php
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM member_list WHERE mem_status='0' ORDER BY member_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 5;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM member_list WHERE mem_status='0' ORDER BY member_id DESC LIMIT $start, $limit");
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
		<td><?php echo $row['member_id'];; ?></td>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img class="Pimg" src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="" width="150" height="150"/></a></td>
		<td><?php echo $row['member_name']; ?></td>
		<td><?php echo $row['mem_mobile']; ?></td>
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
		
			<div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
			<div class="print">
				<a href="javascript:void(0)" onclick="PrintContent()">
				<p align="center"><b>Print</b></p></a>
			</div>
		<div id="prints">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View All Data</h3>
				<p>
					<form action="" method="post">
			
				
				
		<table class="tbl1">
		<tr>
			<td>Member Id: <?php echo $row['member_id'];?></td>
		</tr>
		<tr>
			<td>Employee Photo</td>
		</tr>
		<tr>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img  src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="Photo" width="230" height="220"/></a></td>
		</tr>
		<tr>
			<td>Username: <?php echo $row['mem_username'];?></td>
		</tr>
		<tr>
			<td>Name: <?php echo $row['member_name'];?></td>
		</tr>
		
		<tr>
			<td>Gender: <?php echo $row['mem_sex'];?></td>
		</tr>
		
		<tr>
			<td>Birthday: <?php echo $row['mem_birthday'];?></td>
		</tr>
	
		<tr>
			<td>Contact Number: <?php echo $row['mem_mobile'];?></td>
		</tr>
		
		<tr>
			<td>Address: <?php echo $row['mem_address'];?></td>
		</tr>			
		<tr>
			<td>Email: <?php echo $row['mem_email'];?></td>
		</tr>
		
		
				</p>
				</table>
				</form>
		</div>
	</div>
			&nbsp;|&nbsp;
			<a onclick='return confirm_message();' href="approved-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/edit.gif"></a>
			&nbsp;|&nbsp;
			<a onclick='return confirm_delete();' href="view-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/delete.gif"></a></td>
		</tr>
		
		<?php
	}
	?>
	
</table>
<div class="pagination">
<?php 
echo $pagination; 
?>
</div>
<p>&nbsp;</p>
<h2>View Approved Member List</h2>
<p>&nbsp;</p>
	<form method="post" action="search-approved-member.php">	
		<label for="name">Search Approved Member: </label>
		<input type="text" name="search" placeholder="Member Id" />
		<button>Search</button>	
	</form>
<p>&nbsp;</p>	
<?php
if(isset($success_message3)) {echo "<div class='success'>".$success_message3."</div>";}
?>
<table class="tbl2" width="100%">
	<tr>
		<th width="5%">Serial</th>
		<th width="10%">Member Id</th>
		<th width="20%">Photo</th>
		<th width="20%">Name</th>
		<th width="20%">Mobile</th>
		<th width="20%">Action</th>
	</tr>
	
	<?php
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM member_list WHERE mem_status='1' ORDER BY member_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 5;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM member_list WHERE mem_status='1' ORDER BY member_id DESC LIMIT $start, $limit");
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
		<td><?php echo $row['member_id'];; ?></td>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img class="Pimg" src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="" width="150" height="150"/></a></td>
		<td><?php echo $row['member_name']; ?></td>
		<td><?php echo $row['mem_mobile']; ?></td>
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
		
			<div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
			<div class="print">
				<a href="javascript:void(0)" onclick="PrintContent()">
				<p align="center"><b>Print</b></p></a>
			</div>
		<div id="prints">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View All Data</h3>
				<p>
					<form action="" method="post">
			
				
				
		<table class="tbl1">
		<tr>
			<td>Member Id: <?php echo $row['member_id'];?></td>
		</tr>
		<tr>
			<td>Employee Photo</td>
		</tr>
		<tr>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img  src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="Photo" width="230" height="220"/></a></td>
		</tr>
		<tr>
			<td>Username: <?php echo $row['mem_username'];?></td>
		</tr>
		<tr>
			<td>Name: <?php echo $row['member_name'];?></td>
		</tr>
		
		<tr>
			<td>Gender: <?php echo $row['mem_sex'];?></td>
		</tr>
		
		<tr>
			<td>Birthday: <?php echo $row['mem_birthday'];?></td>
		</tr>
	
		<tr>
			<td>Contact Number: <?php echo $row['mem_mobile'];?></td>
		</tr>
		
		<tr>
			<td>Address: <?php echo $row['mem_address'];?></td>
		</tr>			
		<tr>
			<td>Email: <?php echo $row['mem_email'];?></td>
		</tr>
		
		
				</p>
				</table>
				</form>
		</div>
	</div>
			&nbsp;|&nbsp;
			<a  href="update-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/edit.gif"></a>
			&nbsp;|&nbsp;
			<a onclick='return confirm_delete();' href="delete-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/delete.gif"></a></td>
		</tr>
		
		<?php
	}
	?>
	
</table>
<div class="pagination">
<?php 
echo $pagination; 
?>
</div>
				</div>
			</div>



		</content>
		
	<script type="text/javascript">
	function PrintContent()
	{
		var empumentContainer = empument.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.empument.writeln(empumentContainer.innerHTML);
		WindowObject.empument.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>
<?php include('footer.php');?>