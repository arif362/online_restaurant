
<?php
include('config.php');


if(isset($_POST['add_food']))
{
	$food_id=$_POST['food_id'];
	
	try {
		 if(empty($_POST['cat_id'])) {
			throw new Exception("Category can not be empty.");
				
		}

			
			
		$add_date = date('d-m-Y');
		$add_time = date('H:i:s', time());
		
		$active=0;
		
		foreach($food_id as $each)
		{
		$statement = $db->prepare("INSERT INTO order_list (food_id,cat_id,admin_id,send_date,send_time,status) VALUES (?,?,?,?,?,?)");
		$statement->execute(array($each,$_POST['cat_id'],$_POST['admin_id'],$add_date,$add_time,$active));
		}
		
		$success_message = "Food has been Send successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
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
			<h2>Add Foods</h2>
					<p>&nbsp;</p>
				<?php
					if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
					if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
				?>
			<form action="" method="post" enctype="multipart/form-data">
				<table class="tbl1">
					
					<tr><td><input type="hidden" name="admin_id" value="<?php echo $_SESSION['admin_id'];?>"></td></tr>
					<tr>
						<td>
							<select class="short" name="cat_id"  id="cat_id">
							<option> --- Select Food Category ---</option>
								<?php
									$statement = $db->prepare("SELECT * FROM food_category ORDER BY cat_id ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach($result as $row)
									{
									$cat_id=$row['cat_id'];
									$cat_name=$row['cat_name'];
									?>
									<option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>	
									
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr><td><div id="category"></div></td></tr>
					<tr>
						<td><input type="submit" value="Add Food" name="add_food"></td>
					</tr>
					</table>	
				</form>

					
				</div>
			</div>
		</content>
		
<?php include('footer.php');?>	