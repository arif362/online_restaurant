<?php

include("config.php");
?>
<?php

if(isset($_REQUEST['food_id'])) {

	$food_id = $_REQUEST['food_id'];
}
?>

<?php
if(isset($_POST['update_food']))
{
	try {
		

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
		
		$statement = $db->prepare("UPDATE report SET admin_id=?,cat_id=?, food_image=?,food_title=?,food_price=?,food_summary=?,add_date=? WHERE food_id=? ");
		$statement->execute(array($_POST['admin_id'],$_POST['cat_id'],$f1,$_POST['food_title'],$_POST['food_price'],$_POST['food_summary'],$add_date,$food_id));
		
		$success_message1 = "Report has been Edit successfully.";
		
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
								<h2>Edit Food Details</h2>
					<p>&nbsp;</p>			
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
			

	<?php
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT food_category.cat_id,food_category.cat_name,food_id,food_image,food_title,food_price,food_summary FROM food_category,food_details WHERE food_category.cat_id=food_details.cat_id  ORDER BY food_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 50;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT food_category.cat_id,food_category.cat_name,food_id,food_image,food_title,food_price,food_summary FROM food_category,food_details WHERE food_category.cat_id=food_details.cat_id  ORDER BY food_id DESC LIMIT $start, $limit");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	
	
	foreach($result as $row)
	
	{		
		
			
		$i++;
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
												<option value="<?php echo $row['cat_id']; ?>"> <?php echo $row['cat_id']; ?> </option>
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
											<td><input class="medium" type="text" name="food_title" placeholder="Food Title" value=""></td>
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
							
							</br>		
							<input type="submit" value="SAVE" name="update_food">
									
					</form>
		<?php
	}
	?>
			</br>
				</div>
			</div>


		</content>
		

<?php include('footer.php');?>