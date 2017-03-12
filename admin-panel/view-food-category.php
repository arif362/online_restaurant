<?php

include("../config.php");
?>

<?php

if(isset($_POST['form2']))
{
	try {
		
		if(empty($_POST['category'])) {
			throw new Exception("Food category Name can not be empty.");
		}
		
		$statement = $db->prepare("UPDATE food_category SET cat_name=? WHERE cat_id=?");
		$statement->execute(array($_POST['category'],$_POST['hdn']));
		
		$success_message2 = "Food category Name has been updated successfully.";
		
	}
	catch(Exception $e) {
		$error_message2 = $e->getMessage();
	}
		
}

if(isset($_REQUEST['cat_id'])) 
{
	$id = $_REQUEST['cat_id'];
	
	$statement = $db->prepare("DELETE FROM food_category WHERE cat_id=?");
	$statement->execute(array($id));
	
	$success_message3 = "Food category has been deleted successfully.";
	header("Location:food-category.php");
	
}

?>


								<h2>View/Edit Food Category</h2>
				<?php
				if(isset($error_message2)) {echo "<div class='error'>".$error_message2."</div>";}
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				if(isset($success_message3)) {echo "<div class='success'>".$success_message3."</div>";}
				?>
				<table class="tbl2" width="100%">
					<tr>
						<th width="10%">ID</th>
						<th width="50%">Food Category</th>
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
					<td><?php echo $row['cat_name']; ?></td>
					<td>
						<a class="fancybox" href="#inline<?php echo $i; ?>"><img src="../images/edit.gif"></a>
						<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
							<h3>Edit Food Category</h3>
							<p>
								<form action="" method="post">
									<input type="hidden" name="hdn" value="<?php echo $row['cat_id']; ?>">
									<table>
										<tr>
											<td></td>
										</tr>
										<tr>
											<td><textarea type="text" name="category" rows="2" cols="50"> <?php echo $row['cat_name']; ?></textarea> </td>
										</tr>
										<tr>
											<td><input type="submit" value="UPDATE" name="form2"></td>
										</tr>
									</table>
								</form>
							</p>
						</div>
						&nbsp;|&nbsp;
						<a  onclick='return confirm_delete();' href="view-food-category.php?cat_id=<?php echo $row['cat_id']; ?>"><img src="../images/delete.gif"></a>
					</td>
					</tr>
					
					<?php
					}
					?>
				</table>

		