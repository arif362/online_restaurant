<?php

include("config.php");
?>

<?php
if(isset($_REQUEST['order_id'])) 
{
	$order_id = $_REQUEST['order_id'];
	
	$statement = $db->prepare("DELETE FROM order_list WHERE status='0' and order_id=?");
	$statement->execute(array($order_id));
	
	$success_message2 = "Customer Pending Order has been deleted successfully.";
	
}
?>


<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					
				</div>
				<div class="content_part_right">
								<h2>View Pending Order</h2>
				
				<?php
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				?>
			<p>&nbsp;</p>
				<form method="post" action="day-pending-order.php">	
				<h3 style="color:green">Day Report:</h3>
				<p>&nbsp;</p>
				From date: <input type="text" name="from_date" class="tcal">   To date: <input type="text"  name="to_date" class="tcal">  
				<br><br><input type="submit" name="day_order"  value="Search Day Order" />
				</form>
			
				</br>
				
				<table class="tbl2" width="100%">
				<h3>All Pending Order List:-</h3>
					<tr>				
						<th>Order Id</th>
						<th>Mobile No</th>
						<th>Address</th>
						<th>User Types</th>
						<th>Food Title</th>			
						<th>Quantity</th>			
						<th>Total Price</th>			
						<th>Send Date</th>
						<th>Time</th>
						<th>Delete</th>
					</tr>
		<?php	
					/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM order_list WHERE status='0' and confirm_code='0' and member_id='$member_id' ORDER BY order_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 15;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM order_list WHERE status='0' and confirm_code='0' and member_id='$member_id' ORDER BY order_id DESC LIMIT $start, $limit");
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
					
					<td><?php echo $row['order_id']; ?></td>
					<td><?php echo $row['c_mobile']; ?></td>
					<td><?php echo $row['c_address']; ?></td>
					<td><?php echo $row['user_types']; ?></td>
					<td><?php echo $row['food_title']; ?></td>
					<td><?php echo $row['quantity']; ?></td>
					<td><?php echo 'BDT. '.$row['total']; ?></td>
					<td><?php echo $row['send_date']; ?></td>
					<td><?php echo $row['send_time']; ?></td>
					
					<td>
						<a onclick='return confirm_delete();' href="view-pending-order.php?order_id=<?php echo $row['order_id']; ?>"><img src="../images/delete.gif"></a>
					</td>					
					</tr>
					<?php
					}
					?>
					
					
				</table>
		
					<?php
					$statement = $db->prepare("SELECT SUM(total),SUM(total_quantity) FROM order_list WHERE status='0' and confirm_code='0' and member_id='$member_id' ");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
					foreach($result as $row)
					{		
	
					?>
		<div class="total" align=right><b>Total Quantity: <?php echo $row['SUM(total_quantity)'];?></b></div>
		<div class="total" align=right><b>Total Amount: <?php echo 'BDT. '.$row['SUM(total)'];?></b></div>
		
		<?php
		}
		?>
				</div>
			</div>


<div class="pagination">
<?php 
echo $pagination; 
?>
</div>
		</content>
		
	<script type="text/javascript">
	function PrintContent()
	{
		var subumentContainer = subument.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.subument.writeln(subumentContainer.innerHTML);
		WindowObject.subument.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>
<?php include('footer.php');?>