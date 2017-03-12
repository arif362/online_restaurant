<?php
include("config.php");
?>


<?php
if(isset($_POST['add_category']))
{
	try {
		

		if(empty($_POST['category'])) {
			throw new Exception("Category can not be empty.");
		}
		
		$statement = $db->prepare("SELECT * FROM food_category WHERE cat_name=?");
		$statement->execute(array($_POST['category']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Food category Name already exists.");
		}
		
		$add_date = date('d-m-Y');
		
		$statement = $db->prepare("INSERT INTO food_category(admin_id,cat_name,date) VALUES(?,?,?)");
		$statement->execute(array($_POST['admin_id'],$_POST['category'],$add_date));
		
		$success_message1 = "Food Category has been Add successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
		
}


?>



<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					<?php include('sidebar-menu.php');?>
				</div>
				<div class="content_part_right">
								<h2>Add Food Category</h2>
				<br>
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
			
		
					<form action="" method="post" enctype="multipart/form-data">
									
									<table class="tbl1">
									<tr><td><input type="hidden" value="<?php echo $_SESSION['admin_id'];?>" name="admin_id"></td></tr>
									<tr>
				
										<tr>
											<td>Food Category</td>
										</tr>
										<tr>
											<td><input class="medium" type="text" name="category" placeholder="Food Category"></td>
										</tr>
										
									</table>
							
							
							<input class="submit1" type="submit" value="SAVE" name="add_category">
									
					</form>

			</br>
			<?php include('view-food-category.php');?>
				</div>
			</div>


		</content>
		

<?php include('footer.php');?>