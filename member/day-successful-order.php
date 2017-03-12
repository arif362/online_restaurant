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
			<a href="view-successful-order.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a>
			
				<h2>Search Result of Daily Successful Order</h2>
<?php
include("config.php");	

if (isset($_POST['day_order'])) {
    $from_date =$_POST['from_date'];
    $to_date =$_POST['to_date'];
	
	if(!(preg_match("/^[A-Za-z0-9]/", $from_date.$to_date)))
	{
		echo '<br> You Press Wrong Keyword </br>';
	}
								
		$i=0;
		
			$statement = $db->prepare("Select * from order_list where status='1' and member_id='$member_id' and send_date between '".$from_date."' AND '".$to_date."' ORDER BY order_id DESC ");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
			$num = $statement->rowCount();	
			
	if($num==0)
	{
		echo '<br> No Result Found! </br>';
	}
	else
	{
	echo "<br><p align='right'><b><a href='javascript:void(0)' onclick='PrintContent()'>Print</a></p>";		
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
		echo '<h4>Successful Order Date: '.$from_date.' - '.$to_date.'</h4>';
		echo "<tr>"; 
		echo "<th>Order Id</th>";
		echo "<th>Mobile No</th>";
		echo "<th>Address</th>";
		echo "<th>User Types</th>";
		echo "<th>Food Title</th>	";
		echo "<th>Quantity</th>";
		echo "<th>Total Price</th>";
		echo "<th>Send Date</th>";
		echo "<th>Reply Date</th>";
		echo "<th>Action</th>";
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
					<td><?php echo $row['reply_date']; ?></td>
					
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
		
			<div id="inline<?php echo $i; ?>" style="width:600px;height:850px;display: none;">
				<div class="print">
				<a href="javascript:void(0)" onclick="PrintContent2()"><p align="center"><b>Print<b></p></a>
			</div>
			<div id="prints2" style="width:595px;height:842px">
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
<script type="text/javascript">
	function PrintContent2()
	{
		var DocumentContainer = document.getElementById('prints2');
		var WindowObject = window.open('', "PrintWindow", "width=595,height=842,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
</script>
	
			</div>
			</div>
		</td>
		</tr>
					
		<?php
	}
		
		echo "</table>";
		
				
					$statement = $db->prepare("SELECT SUM(total),SUM(total_quantity) FROM order_list WHERE status='1' and send_date between '".$from_date."' AND '".$to_date."'");
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
<a href="view-successful-order.php"> Search Again</a>	
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