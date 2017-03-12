<?php

include("../config.php");
?>

<?php

if(isset($_REQUEST['food_id'])) 
{
	$id = $_REQUEST['food_id'];
	
	$statement = $db->prepare("DELETE FROM food_details WHERE food_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Food Details has been deleted successfully.";
	
}

?>
<?php include("header.php"); ?>
<div class="container">
	<div id="wrapper">
		<div id="container">
			<div id="sidebar">
				<ul class="navigation">
				<li class="highlight"><a href="index.php" class="button button-green">Dashboard</a></li>
				<li><a href="add-food-details.php" class="button button-red">Add Food Details</a></li>
				<li><a href="view-food-details.php" class="button button-blue">View/Edit Food Details</a></li>
				<li><a href="delete-food-details.php" class="button button-orange">Delete Food Details</a></li>
				<li><a href="logout.php" class="button button-gray">Logout</a></li>
				</ul>
				<p>&nbsp;</p>
			</div>
			<div id="content">
				<h2>Delete Food Details</h2>
				<?php
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				?>
				<table class="tbl2" width="100%">
					<tr>
						<th width="10%">ID</th>
						<th width="50%">Food Details</th>
						<th width="15%">Action</th>
					</tr>
					
					<?php
					$i=0;
					$statement = $db->prepare("SELECT * FROM food_details ORDER BY food_id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
						$i++;
						?>
							
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row['food_description']; ?></td>
					<td>
						<a onclick='return confirm_delete();' href="delete-food-details.php?food_id=<?php echo $row['food_id']; ?>"><img src="img/delete.gif"></a>
					</td>
					</tr>
					
					<?php
					}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>			