<?php

include("config.php");

?>
<?php include('header.php');?>
	<style>
		#pop{
			width: 960px; margin: 0px auto;
			margin-top:10px;
			margin-bottom:10px;
			border:2px solid;
			background:#FFFFFF;
		}
		#close{
			right:5px;
			top:5px;
			float:right;
			courser:pointer;
		}
		button{padding:5px;}
	</style>
		
		<content>
			<div class="content_part">
			
			<div id="pop">
			<a href="view-pending-order.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a>
			
				<h2>Search Result of Monthly Pending Order</h2>
<?php
include("config.php");	

if (isset($_POST['monthly_order'])) {
    $month =$_POST['month'];
    $year =$_POST['year'];
	
	if(!(preg_match("/^[A-Za-z0-9]/", $month.$year)))
	{
		echo '<br> You Press Wrong Keyword </br>';
	}
								
		$i=0;
		
			$statement = $db->prepare("Select * from order_list where status='0' and confirm_code='0' and month='$month' and year='$year' ORDER BY order_id DESC ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
			$num = $statement->rowCount();	
			
	if($num==0)
	{
		echo '<br>No Result Found!<br> ';
	}
	else
	{
	echo "</br><p align='right'><b><a href='javascript:void(0)' onclick='PrintContent()'>Print</a></p>";		
echo "<div id='prints'>";
echo "<style>";
echo "table.tbl2 {
	margin-top: 10px;
}";

echo "table.tbl2 tr th, table.tbl2 tr td {
	padding: 2px;
} ";

echo " table.tbl2 tr td {
	text-align: center; 
}";

echo "table.tbl2 tr th {
	background-color: #72BD4B;
	color: #fff;
}";

echo " table.tbl2 tr:nth-child(2n+1) td {
	background-color: #eee;
}";

echo " table.tbl2 tr:nth-child(2n) td {
	background-color: #ddd;
}";

echo " table.tbl2 tr td a {
	color: #70726e;
	text-decoration: none;
}";
echo "</style>";

		echo "<table class='tbl2' width='100%'>";
		echo '<h4>Pending Order of Month: '.$month.'- '.$year.'</h4>';
		echo "<tr>"; 
		echo "<th>Order Id</th>";
		echo "<th>Mobile No</th>";
		echo "<th>Address</th>";
		echo "<th>User Types</th>";
		echo "<th>Food Title</th>	";
		echo "<th>Quantity</th>";
		echo "<th>Total Price</th>";
		echo "<th>Send Date</th>";
		echo "<th>Time</th>";
		echo "<th>Month</th>";
		echo "<th>Year</th>";
		echo "</tr>";
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
					<td><?php echo $row['month']; ?></td>
					<td><?php echo $row['year']; ?></td>
								
					</tr>			
					
		<?php
	}
		
		echo "</table>";
		
				
					$statement = $db->prepare("SELECT SUM(total),SUM(total_quantity) FROM order_list WHERE status='0' and confirm_code='0' and month='$month' and year='$year'");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
					foreach($result as $row)
					{		
	
					echo "<div align=right><b>Total Quantity:".$row['SUM(total_quantity)']."</b></div>";
					echo "<div align=right><b>Total Amount: BDT. ".$row['SUM(total)']."</b></div>";
					}
	echo "</div>";	
	}
	}
	?>
									
</br>
<a href="view-pending-order.php"> Search Again </a>	

</div>				
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