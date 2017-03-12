<?php

include("../config.php");
?>

<?php

if(isset($_REQUEST['cat_id'])) 
{
	$id = $_REQUEST['cat_id'];
	
	$statement = $db->prepare("DELETE FROM food_category WHERE cat_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Food category has been deleted successfully.";
	
}

?>
<?php include("header.php"); ?>
<div class="container">
	<div id="wrapper">
		<div id="container">
			<div id="sidebar">
				<ul class="navigation">
				<li class="highlight"><a href="index.php" class="button button-green">Dashboard</a></li>
				<li><a href="add-food-category.php" class="button button-red">Add Food Category</a></li>
				<li><a href="view-food-category.php" class="button button-blue">View/Edit Category</a></li>
				<li><a href="delete-category.php" class="button button-orange">Delete Category</a></li>
				<li><a href="logout.php" class="button button-gray">Logout</a></li>
				</ul>
				<p>&nbsp;</p>
			</div>
			<div id="content">
				<h2>Delete  Disease Category</h2>
				<?php
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				?>
				<table class="tbl2" width="100%">
					<tr>
						<th width="10%">ID</th>
						<th width="50%">Disease Category</th>
						<th width="15%">Action</th>
					</tr>
					
					<?php
					$i=0;
					$statement = $db->prepare("SELECT * FROM food_category ORDER BY cat_id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
						$i++;
						?>
							
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row['category']; ?></td>
					<td>
						<a onclick='return confirm_delete();' href="delete-category.php?cat_id=<?php echo $row['cat_id']; ?>"><img src="img/delete.gif"></a>
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