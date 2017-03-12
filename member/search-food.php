<?php
include("config.php");
 
include('header.php');
?>
		
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
		button{padding:5px; courser:pointer;}
	</style>
		<content>
			<div class="content_part">
			<div id="pop">
			<a href="index.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a>
			
				<h2>Search Result of Foods</h2>
<?php
include("config.php");	

if (isset($_POST['search'])) {
    $searchq =$_POST['search'];
	
	if(!(preg_match("/^[a-zA-Z]/", $searchq)))
	{
		echo '<br>You Press Wrong Keyword </br>';
	}
	$i=0;	
	$statement = $db->prepare("SELECT * FROM food_details WHERE food_title LIKE'%$searchq%' Order by food_id DESC");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
	$num = $statement->rowCount();			
	
	if($num==0)
	{
		echo '<br>No Result Found</br>';
	}
	else
	{
		
	echo "<table class='tbl2' width='100%'>";
	
		echo "<tr>"; 
		echo "<th width='5%'>Serial</th>"; 
		echo "<th width='10%'>Food Id</th>";  
		echo "<th width='30%'>Food Image</th>"; 
		echo "<th width='20%'>Food Title</th>"; 
		echo "<th width='10%'>Food Price</th>";
		echo "<th width='10%'>Action</th>"; 
		echo "</tr>";

			foreach($result as $row)
	
	{		
					
		$i++;
		?>
			
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row['food_id'];; ?></td>
		<td><a href="photo/foods/<?php echo $row['food_image']; ?>"><img  src="photo/foods/<?php echo $row['food_image']; ?>" alt="Photo" width="150" height="120"/></a></td>
		<td><?php echo $row['food_title']; ?></td>
		<td><?php echo $row['food_price'];; ?></td>
		<td>
			<a href="order.php">Order</a>
		</td>	
		</tr>
				

				
		<?php
	}
	}
}
	?>
	
</table>
</br>
<a href="index.php"> Search Again </a>
		</div>
	</div>
</br>

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