<?php

include("config.php");
extract($_POST);
?>
<br>
<h5>Search All of Pending Order Date of <?php echo $from_date;?> - <?php echo $to_date;?></h5> 
<div class="print">
	<a href="javascript:void(0)" onclick="PrintContent()"><p align="right">Print</p></a>
</div>
<div id="prints">
<style>
table.tbl2 {
	margin-top: 10px;
}

table.tbl2 tr th, table.tbl2 tr td {
	padding: 2px;
} 

table.tbl2 tr td {
	text-align: center; 
}

table.tbl2 tr th {
	background-color: #72BD4B;
	color: #fff;
}

table.tbl2 tr:nth-child(2n+1) td {
	background-color: #eee;
}

table.tbl2 tr:nth-child(2n) td {
	background-color: #ddd;
}

table.tbl2 tr td a {
	color: #70726e;
	text-decoration: none;
}
</style>
<table class="tbl2" width="100%">
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
						<th>Accept</th>
						<th>Delete</th>
					</tr>
		<?php	
					/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("Select * from order_list where status='0' and send_date between '".$from_date."' AND '".$to_date."' ORDER BY order_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 50;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("Select * from order_list where status='0' and send_date between '".$from_date."' AND '".$to_date."' ORDER BY order_id DESC LIMIT $start, $limit");
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
					
					<td><a onclick='return confirm_deliver();' href="update-pending-order.php?order_id=<?php echo $row['order_id'];?>"><img src="../images/edit.gif"></a></td>
	
					<td>
						<a onclick='return confirm_delete();' href="view-pending-order.php?order_id=<?php echo $row['order_id']; ?>"><img src="../images/delete.gif"></a>
					</td>					
					</tr>
					<?php
					}
					?>
					
					
				</table>
		
					<?php
					$statement = $db->prepare("SELECT SUM(total),SUM(total_quantity) FROM order_list WHERE status='0' and send_date between '".$from_date."' AND '".$to_date."'");
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
	<script type="text/javascript">
	function PrintContent()
	{
		var DocumentContainer = document.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=595,height=842,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>