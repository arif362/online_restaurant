<?php
include("config.php");
?>

<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					<?php include('sidebar-menu.php');?>
				</div>
				<div class="content_part_right">
					<h2>View Successful Order</h2>
				<p>&nbsp;</p>
				<form method="post" action="day-successful-order.php">	
				<h3 style="color:green">Day Report:</h3>
				<p>&nbsp;</p>
				From date: <input type="text" name="from_date" class="tcal">   To date: <input type="text"  name="to_date" class="tcal">  
				<br><br><input type="submit" name="day_order"  value="Search Day Order" />
				</form>
				<br>
			
				<form method="post" action="monthly-successful-order.php">	
				<h3 style="color:green"> Monthly Report</h3>
				<p>&nbsp;</p>
				 Month: 
				<select name="month" id="month">
					<option> --- Select Month --- </option>
					<option value="January">January</option>
					<option value="February">February</option>
					<option value="March">March</option>
					<option value="April">April</option>
					<option value="May">May</option>
					<option value="June">June</option>
					<option value="July">July</option>
					<option value="August">August</option>
					<option value="September">September</option>
					<option value="October">October</option>
					<option value="November">November</option>
					<option value="December">December</option>
				</select>   
				&nbsp;&nbsp;Year: <select name="year" id="year">
					<option> --- Select Year --- </option>
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
				</select>    
				<br><br><input type="submit" name="monthly_order" value="Search Monthly Order" />
				</form>
			
			<br>
				<table class="tbl2" width="100%">
				<h3>All Successful Order List:-</h3>
					<tr>				
						<th>Order Id</th>
						<th>Mobile No</th>
						<th>Address</th>
						<th>User Types</th>
						<th>Food Title</th>			
						<th>Quantity</th>			
						<th>Total Price</th>			
						<th>Send Date</th>
						<th>Reply Date</th>
						<th>Action</th>
					</tr>
		<?php	
					/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM order_list WHERE status='1' ORDER BY order_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 15;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM order_list WHERE status='1' ORDER BY order_id DESC LIMIT $start, $limit");
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
					<td><?php echo $row['reply_date']; ?></td>
					
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
		
			<div id="inline<?php echo $i; ?>" style="width:600px;height:850px;display: none;">
				<div class="print">
				<a href="javascript:void(0)" onclick="PrintContent()"><p align="center"><b>Print</b></p></a>
			</div>
			<div id="prints" style="width:595px;height:842px">
<style>
	table.tbl3 {margin-top: 0px; border: 1px solid black;}

	table.tbl3 tr th, table.tbl3 tr td {padding: 2px;  font-size:16px; border: 1px solid black;}

	table.tbl3 tr td {text-align: left; font-size:16px; border: 1px solid black;}

	table.tbl3 tr th {text-align: left; background-color: #ddd; font-size:16px;}

	table.tbl3 tr:nth-child(2n+1) td {background-color: #ddd;}

	table.tbl3 tr:nth-child(2n) td {background-color: #eee;}

	table.tbl3 tr td a {color: #70726e; text-decoration: none;}
	
			
</style>

						<br/>
						<br/>
						<br/>
						<br/> <br/>
						<br/>
						<br/> 
					<h2 align="center"> Customer Order & Payment Slip  </h2><br>
					<p>
					<form action="" method="post">
					<table class="tbl3">
						<tr>
							<th width="250">Order Id: &nbsp;<?php echo $row['order_id']; ?></th>
							<th width="345">Mobile No: &nbsp;<?php echo $row['c_mobile']; ?></th>
						</tr>
						<tr>
							<td>User Types: &nbsp;<?php echo $row['user_types']; ?></td>
							<td>Address: &nbsp;<?php echo $row['c_address']; ?></td>
						</tr>
						<tr>
							<td>Order Date: &nbsp;<?php echo $row['send_date']; ?></td>
							<td>Order Time: &nbsp;<?php echo $row['send_time']; ?></td>
						</tr>
						<tr>
							<td>Deliver Date: &nbsp;<?php echo $row['reply_date']; ?></td>
							<td>Deliver Time: &nbsp;<?php echo $row['reply_time']; ?></td>
						</tr>
						<tr>
							<td>Food Name: &nbsp;<?php echo $row['food_title']; ?></td>
							<td>Food Price: &nbsp;<?php echo $row['food_price']; ?> <br/></td>
							
						</tr>
						
						<tr>
							<td>Food Quantity: &nbsp;<?php echo $row['quantity']; ?></td>
							<td>Total Price: &nbsp;<?php echo $row['total']; ?></td>
						</tr>	
						<tr>
							<td>Payment Method: &nbsp;<?php echo $row['payment_types']; ?></td>
							<td>Account No: &nbsp;<?php echo $row['c_account']; ?></td>
						</tr>						
					</table>
					<br>
			<br>
			<br>
			<br>
					<div class="sign" style="float:left">Customer Sign</div>
					<div class="sign" style="float:right">Manager Sign</div>
					</form>
					</p>
			
			</div>
			</div>
		</td>
		</tr>
		
		<?php
	}
	?>
	</table>
	<?php
					$statement = $db->prepare("SELECT SUM(total),SUM(total_quantity) FROM order_list WHERE status='1'");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
					foreach($result as $row)
					{		
	
					?>
					<div class="total" align=right><b>Total Quantity: <?php echo $row['SUM(total_quantity)'];?></b></div>
		<div class="total" style="float:right"><b>Total Amount: <?php echo 'BDT. '.$row['SUM(total)'];?></b></div>
		
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
		var DocumentContainer = document.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=595,height=842,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>
<?php include('footer.php');?>