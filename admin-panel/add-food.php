<?php
include("config.php");
?>


<?php
if(isset($_POST['add_food']))
{
	try {
		

		if(empty($_POST['cat_id'])) {
			throw new Exception("Category can not be empty.");
		}
		if(empty($_POST['food_title'])) {
			throw new Exception("Food Title  can not be empty.");
		}
			
		$statement = $db->prepare("SHOW TABLE STATUS LIKE 'food_details'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
				$new_id = $row[10];
		//for food image 
			
		$uploaded_file = $_FILES["food_image"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $new_id. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["food_image"]["tmp_name"],"../photo/foods/" . $f1);
	
		$add_date = date('d-m-Y');
		
		$statement = $db->prepare("INSERT INTO food_details(admin_id,cat_id,food_image,food_title,food_price,food_summary,add_date) VALUES(?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['admin_id'],$_POST['cat_id'],$f1,$_POST['food_title'],$_POST['food_price'],$_POST['food_summary'],$add_date));
		
		$success_message1 = "Food has been Add successfully.";
		
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
								<h2>Add Food</h2>
				<br>
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
			
		
					<form action="" method="post" enctype="multipart/form-data">
									
									<table class="tbl1">
									<tr><td><input type="hidden" value="<?php echo $_SESSION['admin_id'];?>" name="admin_id"></td></tr>
									<tr>
										<td>Food Category</td>
									</tr>
									<tr>
										<td>
											<select name="cat_id" class="short">
											
												<option> ----- Select Category ----- </option>
												<?php
												$statement = $db->prepare("SELECT * FROM food_category ORDER BY cat_id ASC");
												$statement->execute();
												$result = $statement->fetchAll(PDO::FETCH_ASSOC);
												foreach($result as $row)
												{	
												$cat_id=$row['cat_id'];
												$category=$row['cat_name'];
												?>
												<option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>	<?php
												}
												?>
												
											</select>
										</td>
									</tr>
									<tr>
										<td>Food Image</td>
									</tr>
									<tr>
										<td><input type="file" name="food_image"></td>
									</tr>
										<tr>
											<td>Food Title</td>
										</tr>
										<tr>
											<td><input class="medium" type="text" name="food_title" placeholder="Food Title"></td>
										</tr>
										<tr>
											<td>Food Price (BDT.)</td>
										</tr>
										<tr>
											<td><input class="short" type="text" name="food_price" placeholder="Food Price"></td>
										</tr>
										<tr>
										
											<td>Add Food Details</td>
											
										</tr>
										<tr>
										<td style="width:760px;">
										<textarea name="food_summary" cols="20" rows="5"></textarea>
										<script type="text/javascript">
											if ( typeof CKEDITOR == 'undefined' )
											{
												document.write(
													'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
													'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
													'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
													'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
													'value (line 32).' ) ;
											}
											else
											{
												var editor = CKEDITOR.replace( 'food_summary' );
												//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
											}

										</script>
										</td>
										</tr>
									</table>
									
							<input class="submit2" type="submit" value="SAVE" name="add_food">
									
					</form>

			</br>
				</div>
			</div>


		</content>
		

<?php include('footer.php');?>