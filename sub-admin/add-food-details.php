<?php

include("../config.php");
?>

<?php

if(isset($_POST['form1']))
{
	$food_name=$_POST['food_name'];
	
	try {
		if(empty($_POST['food_name'])) {
			throw new Exception("Food Name can not be empty.");
		}
		
		if(empty($_POST['food_description'])) {
			throw new Exception("Food Description can not be empty.");
		}
		if(empty($_POST['food_price'])) {
			throw new Exception("Food Price can not be empty.");
		}
		$statement = $db->prepare("SELECT * FROM food_details WHERE food_description=?");
		$statement->execute(array($_POST['food_description']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Food Details already exists.");
		}
		$uploaded_file = $_FILES["food_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $food_name. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["food_pic"]["tmp_name"],"../uploads/" . $f1);
		
		$add_date = date('d-m-Y H:i:s', time());
		
		$statement = $db->prepare("INSERT INTO food_details(food_pic,food_name,food_description,cat_id,food_price,add_date) VALUES (?,?,?,?,?,?)");
		$statement->execute(array($f1,$food_name,$_POST['food_description'],$_POST['cat_id'],$_POST['food_price'],$add_date));
		
		$success_message = "Food Details has been inserted successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
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
				<h2>Add Food Details</h2>
				<p>&nbsp;</p>
				<?php
				if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
				if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
				?>
				<form action="" method="post" enctype="multipart/form-data">
					<table class="tbl1">
						<tr>
							<td>Food Photo<input type="file" name="food_pic"></td>
						</tr>
						<tr>
							<td>Food Name </td>
						</tr>
						<tr>
							<td><input class="medium" type="text" name="food_name"></td>
						</tr>
						<tr>
							<td>Food Details </td>
						</tr>
						<tr>
							<td><textarea type="text" name="food_description" rows="1" cols="80"></textarea> </td>
						</tr>
						<tr>
							<td>Food Category </td>
						</tr>
						<tr>
							<td>
								<select name="cat_id" class="s_category">
								<option> ----- Select Category ----- </option>
								<?php
								$statement = $db->prepare("SELECT * FROM food_category ORDER BY cat_id ASC");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach($result as $row)
								{	
								$cat_id=$row['cat_id'];
								$category=$row['category'];
								?>
								<option value="<?php echo $row['cat_id']; ?>"><?php echo $row['category']; ?></option>	<?php
								}
								?>
								</select> 
							</td>
						</tr>
						<tr>
							<td>Food Price </td>
						</tr>
						<tr>
							<td>BDT.<input class="short" type="text" name="food_price"></td>
						</tr>
						<tr>
							<td><input type="submit" value="SAVE" name="form1"></td>
						</tr>
					</table>	
				</form>

			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>			